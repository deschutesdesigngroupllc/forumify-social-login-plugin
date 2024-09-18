<?php

namespace DeschutesDesignGroupLLC\ForumifySocialLoginPlugin\Login\Controller;

use DeschutesDesignGroupLLC\ForumifySocialLoginPlugin\Login\Security\Http\Authenticator\SocialLoginAuthenticator;
use Forumify\Core\Security\Http\Authenticator\ForumifyAuthenticator;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class CallbackController
{
    #[Route('/callback', 'callback')]
    public function __invoke(Request $request) {
        dd($request);
    }
}