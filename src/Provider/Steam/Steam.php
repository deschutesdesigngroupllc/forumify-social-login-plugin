<?php

namespace DeschutesDesignGroupLLC\SocialLoginPlugin\Provider\Steam;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Steam extends AbstractProvider
{
    use BearerAuthorizationTrait;

    public string $apiUrl = 'https://api.steampowered.com/ISteamUserOAuth/GetTokenDetails/v1/';

    public string $baseUrl = 'https://steamcommunity.com/oauth';

    public function getBaseAuthorizationUrl(): string
    {
        return "$this->baseUrl/authorize";
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return "$this->baseUrl/token";
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
            throw SteamIdentityProviderException::clientException($response, $data);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token): SteamResourceOwner
    {
        return new SteamResourceOwner($response);
    }
}
