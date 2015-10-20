<?php

namespace Crew\Unsplash;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Entity\User;

class Provider extends AbstractProvider
{
	/**
	 * The default authorization header uses a bearer token
	 * @var string
	 */
	public $authorizationHeader = 'Bearer';

	/**
	 * Define the default scope.
	 * @var array
	 */
	public $scopes = ['public'];

	/**
	 * Define the scopes separator for the url
	 * @var string
	 */
	public $scopeSeparator = ' ';

	/**
	 * Define the authorize URL
	 *
	 * @return string
	 */
	public function urlAuthorize()
	{
		return 'https://unsplash.com/oauth/authorize';
	}

	/**
	 * Define the access token url
	 *
	 * @return string
	 */
	public function urlAccessToken()
	{
		return 'https://unsplash.com/oauth/token';
	}

	/**
	 * Define the current user details url
	 *
	 * @param AccessToken $token
	 * @return string
	 */
	public function urlUserDetails(AccessToken $token)
	{
		return "https://api.unsplash.com/me?access_token={$token}";
	}

	/**
	 * @param  \GuzzleHttp\Psr7\Response $response HTTP response
	 * @param  AccessToken $token Access token information for the current user
	 * @return User
	 */
	public function userDetails($response, AccessToken $token)
	{
		$user = new User();

		$user->exchangeArray([
            'uid' => $response->uuid,
            'name' => $response->first_name . ' ' . $response->last_name,
            'firstname' => $response->first_name,
            'lastname' => $response->last_name
        ]);

        return $user;
	}

	/**
	 * @param  \GuzzleHttp\Psr7\Response $response HTTP response
	 * @param  AccessToken $token Access token information for the current user
	 * @return string
	 */
	public function userUid($response, AccessToken $token)
    {
        return $response->uuid;
    }
}
