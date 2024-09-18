<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sociallogin__discord__client_id', TextType::class, [
                'label' => 'Client ID',
            ])
            ->add('sociallogin__discord__client_secret', TextType::class, [
                'label' => 'Client Secret',
            ])
            ->add('sociallogin__google__client_id', TextType::class, [
                'label' => 'Client ID',
            ])
            ->add('sociallogin__google__client_secret', TextType::class, [
                'label' => 'Client Secret',
            ]);
    }
}
