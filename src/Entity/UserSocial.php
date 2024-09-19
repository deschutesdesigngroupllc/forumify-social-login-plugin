<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Forumify\Core\Entity\User;
use Forumify\Core\Repository\UserRepository;

#[ORM\Entity]
#[ORM\Table('sociallogin_user')]
class UserSocial
{
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private User $user;

    public function __construct(int $userId, UserRepository $userRepository)
    {
        $this->user = $userRepository->find($userId);
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
