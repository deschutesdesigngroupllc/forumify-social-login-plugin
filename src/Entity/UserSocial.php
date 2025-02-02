<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Entity;

use DeschutesDesignGroupLLC\SocialLoginPlugin\Repository\UserSocialRepository;
use Doctrine\ORM\Mapping as ORM;
use Forumify\Core\Entity\User;

#[ORM\Entity(repositoryClass: UserSocialRepository::class)]
#[ORM\Table('user_social')]
class UserSocial
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(unique: true, nullable: true)]
    private string $discordId;

    #[ORM\Column(unique: true, nullable: true)]
    private string $googleId;

    #[ORM\Column(unique: true, nullable: true)]
    private string $perscomId;

    #[ORM\Column(unique: true, nullable: true)]
    private string $steamId;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getDiscordId(): ?string
    {
        return $this->discordId;
    }

    public function setDiscordId(string $discordId): void
    {
        $this->discordId = $discordId;
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(string $googleId): void
    {
        $this->googleId = $googleId;
    }

    public function getPerscomId(): ?string
    {
        return $this->perscomId;
    }

    public function setPerscomId(string $perscomId): void
    {
        $this->perscomId = $perscomId;
    }

    public function getSteamId(): ?string
    {
        return $this->steamId;
    }

    public function setSteamId(string $steamId): void
    {
        $this->steamId = $steamId;
    }
}
