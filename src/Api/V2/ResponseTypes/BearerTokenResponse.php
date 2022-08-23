<?php

namespace App\Api\V2\ResponseTypes;

use App\Api\V2\CryptKey;
use App\Api\V2\Entities\Interfaces\ClaimEntityInterface;
use App\Api\V2\ResponseTypes\Interfaces\ResponseTypeInterface;
use League\OAuth2\Server\CryptKey as BaseCryptKey;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\ResponseTypes\BearerTokenResponse as LeagueBearerTokenResponse;

/**
 * Class BearerTokenResponse
 * @package App\Api\V2\ResponseTypes
 */
class BearerTokenResponse extends LeagueBearerTokenResponse implements ResponseTypeInterface
{
    /**
     * @var mixed|null
     */
    protected $idToken = null;

    /**
     * @var CryptKey|BaseCryptKey
     */
    protected $privateKey;

    /**
     * @param $idToken
     * @return void
     */
    public function setIdToken($idToken): void
    {
        $this->idToken = $idToken;
    }

    /**
     * @return mixed|null
     */
    public function getIdToken()
    {
        return $this->idToken;
    }

    /**
     * @return AccessTokenEntityInterface
     */
    public function getAccessToken(): AccessTokenEntityInterface
    {
        return $this->accessToken;
    }

    /**
     * @param AccessTokenEntityInterface $accessToken
     * @return array
     */
    protected function getExtraParams(AccessTokenEntityInterface $accessToken): array
    {

        /*
         The Claims requested by the profile, email, address, and phone scope values
         are returned from the UserInfo Endpoint, as described in Section 5.3.2,
         when a response_type value is used that results in an Access Token being issued.
         However, when no Access Token is issued (which is the case for the response_type
         value id_token), the resulting Claims are returned in the ID Token.
         */
        if ($this->getIdToken() !== null) {
            $idToken = $this->getIdToken()->convertToJWT($this->privateKey);

            // FIXME: Since an AuthorizationServer does not get re-created for every call, the BearerTokenResponse object does not either.
            // Clear the IdToken since it should be set seperatly for every request
            $this->setIdToken(null);

            return [
                ClaimEntityInterface::TYPE_ID_TOKEN => $idToken->toString()
            ];
        }

        return [];
    }
}
