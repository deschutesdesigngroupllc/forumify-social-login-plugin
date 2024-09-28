<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Components;

use Forumify\Core\Repository\SettingRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('DeschutesDesignGroupLLC\SocialLogin\Google', '@ForumifySocialLoginPlugin/components/google-login.html.twig')]
class GoogleLogin
{
    public string $url;

    public bool $enabled = false;

    public function __construct(
        private readonly UrlGeneratorInterface $router,
        private readonly SettingRepository $settingRepository,
    ) {}

    public function mount(): void
    {
        $this->enabled = $this->settingRepository->get('sociallogin.google.client_id') !== null
            && $this->settingRepository->get('sociallogin.google.client_secret') !== null;

        $this->url = $this->router->generate(
            name: 'sociallogin_redirect',
            parameters: [
                'provider' => 'google',
            ],
            referenceType: UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
