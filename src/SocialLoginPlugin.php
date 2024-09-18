<?php

namespace DeschutesDesignGroupLLC\ForumifySocialLoginPlugin;

use Forumify\Plugin\AbstractForumifyPlugin;
use Forumify\Plugin\PluginMetadata;

class SocialLoginPlugin extends AbstractForumifyPlugin
{
    public function getPluginMetadata(): PluginMetadata
    {
        return new PluginMetadata(
            'Social Login',
            'deschutesdesigngroupllc',
            'Add social login support to your forumify platform.',
            'https://www.deschutesdesigngroup.com',
            'sociallogin_admin_settings'
        );
    }

    public function getPermissions(): array
    {
        return [
            'admin' => [
                'configuration' => [
                    'manage',
                ],
            ],
        ];

    }
}
