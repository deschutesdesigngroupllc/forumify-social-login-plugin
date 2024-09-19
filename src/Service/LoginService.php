<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Service;

use Exception;
use Forumify\Core\Repository\SettingRepository;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

readonly class LoginService
{
    public function __construct(
        private SettingRepository $settingRepository,
        private RequestStack $requestStack,
        private UrlGeneratorInterface $router
    ) {}

    /**
     * @throws Exception
     */
    public function getClient(string $provider): OAuth2ClientInterface
    {
        $provider = match ($provider) {
            'google' => new Google([
                'clientId' => $this->settingRepository->get('sociallogin.google.client_id'),
                'clientSecret' => $this->settingRepository->get('sociallogin.google.client_secret'),
                'redirectUri' => $this->router->generate(
                    name: 'sociallogin_callback',
                    parameters: [
                        'provider' => 'google',
                    ],
                    referenceType: UrlGeneratorInterface::ABSOLUTE_URL),
            ]),
            default => throw new Exception('The provider you have provided is not supported.')
        };

        return new OAuth2Client($provider, $this->requestStack);
    }

    /**
     * @throws Exception
     */
    public function getEmail(ResourceOwnerInterface $user): OAuth2ClientInterface
    {
        return match (get_class($user)) {
            GoogleUser::class => $user->getEmail(),
            DiscordResourceOwner::class => $user->getEmail(),
            default => throw new Exception('The resource owner you have provided is not supported.')
        };
    }
}
