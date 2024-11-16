<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Perscom extends AbstractProvider
{
    use BearerAuthorizationTrait;

    public string $dashboardUrl;

    public function getBaseAuthorizationUrl(): string
    {
        return "$this->dashboardUrl/oauth/authorize";
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return "$this->dashboardUrl/oauth/token";
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return "$this->dashboardUrl/oauth/userinfo";
    }

    protected function getScopeSeparator(): string
    {
        return ' ';
    }

    protected function getDefaultScopes(): array
    {
        return [
            'profile',
            'email',
            'openid',
        ];
    }

    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if ($response->getStatusCode() >= 400) {
            throw PerscomIdentityProviderException::clientException($response, $data);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token): PerscomResourceOwner
    {
        return new PerscomResourceOwner($response);
    }
}
