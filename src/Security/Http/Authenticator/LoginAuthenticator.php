<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Security\Http\Authenticator;

use DeschutesDesignGroupLLC\SocialLoginPlugin\Entity\UserSocial;
use DeschutesDesignGroupLLC\SocialLoginPlugin\Repository\UserSocialRepository;
use DeschutesDesignGroupLLC\SocialLoginPlugin\Security\Authentication\LoginFailureHandler;
use DeschutesDesignGroupLLC\SocialLoginPlugin\Security\Authentication\LoginSuccessHandler;
use DeschutesDesignGroupLLC\SocialLoginPlugin\Service\LoginService;
use Exception;
use Forumify\Core\Entity\User;
use Forumify\Core\Form\DTO\NewUser;
use Forumify\Core\Repository\UserRepository;
use Forumify\Core\Service\CreateUserService;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

#[AutoconfigureTag('forumify.authenticator')]
class LoginAuthenticator extends OAuth2Authenticator
{
    public function __construct(
        protected LoginService $service,
        protected UserSocialRepository $userSocialRepository,
        protected UserRepository $userRepository,
        protected LoginSuccessHandler $successHandler,
        protected LoginFailureHandler $failureHandler,
        protected CreateUserService $createUserService
    ) {
        //
    }

    public function supports(Request $request): ?bool
    {
        if ($request->attributes->get('_route') !== 'sociallogin_callback' || is_null($request->attributes->get('provider'))) {
            return false;
        }

        if (! $request->query->has('state')) {
            return false;
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function authenticate(Request $request): Passport
    {
        $client = $this->service->getClient(
            provider: $provider = $request->attributes->get('provider')
        );

        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function () use ($accessToken, $client, $provider) {
                $oauthUser = $client->fetchUserFromToken($accessToken);

                /** @var UserSocial $existingSocialUserByProviderId */
                $existingSocialUserByProviderId = $this->userSocialRepository->findOneBy(["{$provider}Id" => $oauthUser->getId()]);

                if ($existingSocialUserByProviderId) {
                    return $existingSocialUserByProviderId->getUser();
                }

                $email = $this->service->getEmail($oauthUser);
                $username = $this->service->getUsername($oauthUser);

                /** @var User $existingUser */
                $existingUser = $this->userRepository->findOneBy(['email' => $email]);

                if (! $existingUser) {
                    $newUser = new NewUser;
                    $newUser->setEmail($email);
                    $newUser->setUsername($username);
                    $newUser->setPassword(LoginService::generatePassword());

                    $existingUser = $this->createUserService->createUser(
                        newUser: $newUser,
                        requireEmailVerification: false
                    );
                }

                /** @var UserSocial $existingSocialUserByUserId */
                $existingSocialUserByUserId = $this->userSocialRepository->findOneBy(['user' => $existingUser->getId()]);

                $socialUser = $existingSocialUserByUserId ?? new UserSocial($existingUser);

                match ($provider) {
                    'discord' => $socialUser->setDiscordId($oauthUser->getId()),
                    'google' => $socialUser->setGoogleId($oauthUser->getId()),
                    'perscom' => $socialUser->setPerscomId($oauthUser->getId()),
                    default => throw new Exception('The provider you have provided is not supported.')
                };

                $this->userSocialRepository->save($socialUser);

                return $existingUser;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return $this->successHandler->onAuthenticationSuccess($request, $token);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return $this->failureHandler->onAuthenticationFailure($request, $exception);
    }
}
