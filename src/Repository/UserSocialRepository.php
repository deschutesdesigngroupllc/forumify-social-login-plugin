<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Repository;

use DeschutesDesignGroupLLC\SocialLoginPlugin\Entity\UserSocial;
use Forumify\Core\Repository\AbstractRepository;

class UserSocialRepository extends AbstractRepository
{
    public static function getEntityClass(): string
    {
        return UserSocial::class;
    }
}
