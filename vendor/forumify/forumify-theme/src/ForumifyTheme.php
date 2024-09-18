<?php

declare(strict_types=1);

namespace Forumify;

use Forumify\Plugin\AbstractForumifyTheme;
use Forumify\Plugin\PluginMetadata;
use Forumify\Plugin\ThemeConfig;
use Forumify\Plugin\ThemeVar;
use Forumify\Plugin\ThemeVarType;

class ForumifyTheme extends AbstractForumifyTheme
{
    public function getPluginMetadata(): PluginMetadata
    {
        return new PluginMetadata(
            'Forumify Theme',
            'forumify',
            'The base theme that comes with every forumify installation.',
            'https://forumify.net'
        );
    }

    public function getThemeConfig(): ThemeConfig
    {
        return new ThemeConfig(
            hasDarkVariant: true,
            vars: [
                new ThemeVar(
                    key: 'c-primary',
                    label: 'Primary Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#2d3142',
                    defaultDarkValue: '#d5d8e3'
                ),
                new ThemeVar(
                    key: 'c-primary-accent',
                    label: 'Primary Accent Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#4a5496',
                    defaultDarkValue: '#878fc4',
                ),
                new ThemeVar(
                    key: 'c-primary-text',
                    label: 'Primary Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#ffffff',
                    defaultDarkValue: '#000000'
                ),
                new ThemeVar(
                    key: 'c-secondary',
                    label: 'Secondary Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#4f5d75'
                ),
                new ThemeVar(
                    key: 'c-secondary-text',
                    label: 'Secondary Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#ffffff'
                ),
                new ThemeVar(
                    key: 'c-call-to-action',
                    label: 'Call to Action Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#ef8354'
                ),
                new ThemeVar(
                    key: 'c-call-to-action-accent',
                    label: 'Call to Action Accent Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#d06335'
                ),
                new ThemeVar(
                    key: 'c-call-to-action-text',
                    label: 'Call to Action Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#000000'
                ),
                new ThemeVar(
                    key: 'c-text-primary',
                    label: 'Primary Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#1b1c1f',
                    defaultDarkValue: '#ffffff',
                ),
                new ThemeVar(
                    key: 'c-text-secondary',
                    label: 'Secondary Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#666879',
                    defaultDarkValue: '#ffffff',
                ),
                new ThemeVar(
                    key: 'c-success',
                    label: 'Success Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#E3FBE3'
                ),
                new ThemeVar(
                    key: 'c-success-text',
                    label: 'Success Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#0A470A'
                ),
                new ThemeVar(
                    key: 'c-info',
                    label: 'Info Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#E3EFFB'
                ),
                new ThemeVar(
                    key: 'c-info-text',
                    label: 'Info Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#12467B'
                ),
                new ThemeVar(
                    key: 'c-warning',
                    label: 'Warning Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#FDF0E1'
                ),
                new ThemeVar(
                    key: 'c-warning-text',
                    label: 'Warning Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#492B08'
                ),
                new ThemeVar(
                    key: 'c-error',
                    label: 'Error Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#fce4e4'
                ),
                new ThemeVar(
                    key: 'c-error-text',
                    label: 'Error Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#7d1212'
                ),
                new ThemeVar(
                    key: 'c-elevation-0',
                    label: 'Elevation 0 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#f9f9f9',
                    defaultDarkValue: '#272729'
                ),
                new ThemeVar(
                    key: 'c-elevation-1',
                    label: 'Elevation 1 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#ffffff',
                    defaultDarkValue: '#333438'
                ),
                new ThemeVar(
                    key: 'c-elevation-2',
                    label: 'Elevation 2 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#ececec',
                    defaultDarkValue: '#424246'
                ),
                new ThemeVar(
                    key: 'c-elevation-3',
                    label: 'Elevation 3 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#e3e3e3',
                    defaultDarkValue: '#46474d'
                ),
                new ThemeVar(
                    key: 'c-elevation-4',
                    label: 'Elevation 4 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#dedede',
                    defaultDarkValue: '#46474d'
                ),
                new ThemeVar(
                    key: 'c-elevation-5',
                    label: 'Elevation 5 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#d5d5d5',
                    defaultDarkValue: '#46474d'
                ),
                new ThemeVar(
                    key: 'c-hover',
                    label: 'Hover Color',
                    type: ThemeVarType::Color,
                    defaultValue: 'rgba(0, 0, 0, 0.03)',
                    defaultDarkValue: 'rgba(255, 255, 255, 0.03)'
                ),
                new ThemeVar(
                    key: 'border-style',
                    label: 'Border Style',
                    type: ThemeVarType::String,
                    defaultValue: 'solid'
                ),
                new ThemeVar(
                    key: 'border-width',
                    label: 'Border Width',
                    type: ThemeVarType::Size,
                    defaultValue: '1px'
                ),
                new ThemeVar(
                    key: 'border-color',
                    label: 'Border Color',
                    type: ThemeVarType::Color,
                    defaultValue: 'rgba(0, 0, 0, 0.1)',
                    defaultDarkValue: 'rgba(255, 255, 255, 0.1)'
                ),
                new ThemeVar(
                    key: 'border',
                    label: 'Border',
                    type: ThemeVarType::String,
                    defaultValue: 'var(--border-style) var(--border-width) var(--border-color)'
                ),
                new ThemeVar(
                    key: 'border-radius',
                    label: 'Border Radius',
                    type: ThemeVarType::Size,
                    defaultValue: '8px'
                ),
                new ThemeVar(
                    key: 'font-size',
                    label: 'Font Size',
                    type: ThemeVarType::Size,
                    defaultValue: '16px'
                ),
            ]
        );
    }
}
