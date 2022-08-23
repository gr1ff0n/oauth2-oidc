<?php

namespace App\Api\V2;

use League\OAuth2\Server\AuthorizationValidators\AuthorizationValidatorInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\ResourceServer;

/**
 * Class AdvancedResourceServer
 * @package App\Api\V2
 */
class AdvancedResourceServer extends ResourceServer
{

    /**
     * New server instance.
     *
     * @param AccessTokenRepositoryInterface $accessTokenRepository
     * @param CryptKey|string $publicKey
     * @param null|AuthorizationValidatorInterface $authorizationValidator
     */
    public function __construct(
        AccessTokenRepositoryInterface  $accessTokenRepository,
        $publicKey,
        AuthorizationValidatorInterface $authorizationValidator = null
    ) {
        parent::__construct($accessTokenRepository, $publicKey, $authorizationValidator);

        if ($publicKey instanceof CryptKey === false) {
            $publicKey = new CryptKey($publicKey);
        }
        $this->publicKey = $publicKey;
    }
}
