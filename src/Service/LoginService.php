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
use Wohali\OAuth2\Client\Provider\Discord;
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

class LoginService
{
    public function __construct(
        private readonly SettingRepository $settingRepository,
        private readonly RequestStack $requestStack,
        private readonly UrlGeneratorInterface $router
    ) {}

    /**
     * @throws Exception
     */
    public function getClient(string $provider): OAuth2ClientInterface
    {
        $provider = match ($provider) {
            'discord' => new Discord([
                'clientId' => $this->settingRepository->get('sociallogin.discord.client_id'),
                'clientSecret' => $this->settingRepository->get('sociallogin.discord.client_secret'),
                'redirectUri' => $this->router->generate(
                    name: 'sociallogin_callback',
                    parameters: [
                        'provider' => 'discord',
                    ],
                    referenceType: UrlGeneratorInterface::ABSOLUTE_URL),
            ]),
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
    public function getEmail(ResourceOwnerInterface $user): string
    {
        return match (get_class($user)) {
            GoogleUser::class => $user->getEmail(),
            DiscordResourceOwner::class => $user->getEmail(),
            default => throw new Exception('The resource owner you have provided is not supported.')
        };
    }

    /**
     * @throws Exception
     */
    public function getUsername(ResourceOwnerInterface $user): string
    {
        return match (get_class($user)) {
            GoogleUser::class => $user->getName(),
            DiscordResourceOwner::class => $user->getUsername(),
            default => throw new Exception('The resource owner you have provided is not supported.')
        };
    }

    public static function generatePassword(): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;

        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }
}
