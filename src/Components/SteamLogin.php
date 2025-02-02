<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Components;

use Forumify\Core\Repository\SettingRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('DeschutesDesignGroupLLC\SocialLogin\steam', '@ForumifySocialLoginPlugin/components/steam-login.html.twig')]
class SteamLogin
{
    public string $url;

    public bool $enabled = false;

    public function __construct(
        private readonly UrlGeneratorInterface $router,
        private readonly SettingRepository $settingRepository,
    ) {}

    public function mount(): void
    {
        $this->enabled = $this->settingRepository->get('sociallogin.steam.enabled');

        $this->url = $this->router->generate(
            name: 'sociallogin_redirect',
            parameters: [
                'provider' => 'steam',
            ],
            referenceType: UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
