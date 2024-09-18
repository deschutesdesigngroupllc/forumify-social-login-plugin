<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Login\Controller;

use DeschutesDesignGroupLLC\SocialLoginPlugin\Login\Service\SocialLoginService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

class RedirectController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/login/redirect/{provider}', 'redirect')]
    public function __invoke(SocialLoginService $service, string $provider): RedirectResponse
    {
        return $service
            ->getClient($provider)
            ->redirect();
    }
}
