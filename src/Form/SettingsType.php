<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sociallogin__perscom__enabled', CheckboxType::class, [
                'label' => 'Enabled',
                'required' => false,
            ])
            ->add('sociallogin__perscom__dashboard_url', TextType::class, [
                'label' => 'Dashboard URL',
                'required' => false,
            ])
            ->add('sociallogin__perscom__client_id', TextType::class, [
                'label' => 'Client ID',
                'required' => false,
            ])
            ->add('sociallogin__perscom__client_secret', TextType::class, [
                'label' => 'Client Secret',
                'required' => false,
            ])
            ->add('sociallogin__discord__enabled', CheckboxType::class, [
                'label' => 'Enabled',
                'required' => false,
            ])
            ->add('sociallogin__discord__client_id', TextType::class, [
                'label' => 'Client ID',
                'required' => false,
            ])
            ->add('sociallogin__discord__client_secret', TextType::class, [
                'label' => 'Client Secret',
                'required' => false,
            ])
            ->add('sociallogin__google__enabled', CheckboxType::class, [
                'label' => 'Enabled',
                'required' => false,
            ])
            ->add('sociallogin__google__client_id', TextType::class, [
                'label' => 'Client ID',
                'required' => false,
            ])
            ->add('sociallogin__google__client_secret', TextType::class, [
                'label' => 'Client Secret',
                'required' => false,
            ]);
    }
}
