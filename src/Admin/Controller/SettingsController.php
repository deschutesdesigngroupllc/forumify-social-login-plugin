<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Admin\Controller;

use DeschutesDesignGroupLLC\SocialLoginPlugin\Admin\Form\SettingsType;
use Forumify\Core\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('forumify.admin.settings.plugins.manage')]
class SettingsController extends AbstractController
{
    #[Route('/settings', 'settings')]
    public function __invoke(Request $request, SettingRepository $settingRepository): RedirectResponse|Response
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
        ]);
    }
}
