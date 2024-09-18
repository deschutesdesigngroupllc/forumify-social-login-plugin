<?php

namespace DeschutesDesignGroupLLC\ForumifySocialLoginPlugin\Login\Controller;

use DeschutesDesignGroupLLC\ForumifySocialLoginPlugin\Login\Service\SocialLoginService;
use Symfony\Component\Routing\Attribute\Route;

class RedirectController
{
    #[Route('/sociallogin/redirect')]
    public function __invoke(SocialLoginService $service)
    {
        dd('test');
    }
}