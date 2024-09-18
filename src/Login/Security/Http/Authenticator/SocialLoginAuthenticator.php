<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Login\Security\Http\Authenticator;

use DeschutesDesignGroupLLC\SocialLoginPlugin\Login\Service\SocialLoginService;
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
class SocialLoginAuthenticator extends OAuth2Authenticator
{
    public function __construct(
        protected SocialLoginService $service,
        protected UserRepository $userRepository,
        protected EntityManagerInterface $entityManager
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
        // TODO: Implement onAuthenticationSuccess() method.
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // TODO: Implement onAuthenticationFailure() method.
    }
}
