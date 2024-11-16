<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Controller\Admin;

use DeschutesDesignGroupLLC\SocialLoginPlugin\Form\SettingsType;
use Forumify\Core\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('forumify.admin.settings.plugins.manage')]
class SettingsController extends AbstractController
{
    #[Route('/settings', 'settings')]
    public function __invoke(Request $request, SettingRepository $settingRepository, UrlGeneratorInterface $router): RedirectResponse|Response
    {
        $form = $this->createForm(SettingsType::class, $settingRepository->toFormData('sociallogin'));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $settingRepository->handleFormData($data);

            return $this->redirectToRoute('sociallogin_admin_settings');
        }

        return $this->render('@ForumifySocialLoginPlugin/admin/settings.html.twig', [
            'form' => $form->createView(),
            'redirect' => [
                'perscom' => $router->generate(
                    name: 'sociallogin_callback',
                    parameters: [
                        'provider' => 'perscom',
                    ],
                    referenceType: UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'discord' => $router->generate(
                    name: 'sociallogin_callback',
                    parameters: [
                        'provider' => 'discord',
                    ],
                    referenceType: UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'google' => $router->generate(
                    name: 'sociallogin_callback',
                    parameters: [
                        'provider' => 'google',
                    ],
                    referenceType: UrlGeneratorInterface::ABSOLUTE_URL
                ),
            ],
        ]);
    }
}
