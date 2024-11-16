<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class PerscomResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    public function __construct(protected array $response = []) {}

    public function getId(): ?string
    {
        return $this->getValueByKey($this->response, 'sub');
    }

    public function getEmail(): ?string
    {
        return $this->getValueByKey($this->response, 'email');
    }

    public function getName(): ?string
    {
        return $this->getValueByKey($this->response, 'name');
    }

    public function getProfilePhoto(): ?string
    {
        return $this->getValueByKey($this->response, 'profile_photo_url');
    }

    public function toArray(): array
    {
        return $this->response;
    }
}
