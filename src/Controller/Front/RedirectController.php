<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Controller\Front;

use DeschutesDesignGroupLLC\SocialLoginPlugin\Service\LoginService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

class RedirectController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/redirect/{provider}', 'redirect')]
    public function __invoke(LoginService $service, string $provider): RedirectResponse
    {
        return $service
            ->getClient($provider)
            ->redirect();
    }
}
