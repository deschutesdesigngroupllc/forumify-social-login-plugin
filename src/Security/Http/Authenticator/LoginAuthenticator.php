<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Security\Http\Authenticator;

use DeschutesDesignGroupLLC\SocialLoginPlugin\Security\Authentication\LoginFailureHandler;
use DeschutesDesignGroupLLC\SocialLoginPlugin\Security\Authentication\LoginSuccessHandler;
use DeschutesDesignGroupLLC\SocialLoginPlugin\Service\LoginService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Forumify\Core\Repository\UserRepository;
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
        protected UserRepository $userRepository,
        protected EntityManagerInterface $entityManager,
        protected LoginSuccessHandler $successHandler,
        protected LoginFailureHandler $failureHandler,
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

                $user = $client->fetchUserFromToken($accessToken);

                $email = $this->service->getEmail($user);

                $existingUser = $this->userRepository->findOneBy(["{$provider}_id" => $user->getId()]);

                if ($existingUser) {
                    return $existingUser;
                }

                $user = $this->userRepository->findOneBy(['email' => $email]);

                $user->setFacebookId($user->getId());
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return $user;
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
