<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Provider\Steam;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;

class SteamIdentityProviderException extends IdentityProviderException
{
    public static function clientException(ResponseInterface $response, $data): static
    {
        return static::fromResponse(
            $response,
            $data['error']['message'] ?? json_encode($data)
        );
    }

    protected static function fromResponse(ResponseInterface $response, $message = null): static
    {
        return new static($message, $response->getStatusCode(), (string) $response->getBody());
    }
}
