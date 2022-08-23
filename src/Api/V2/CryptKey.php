<?php

namespace App\Api\V2;

use League\OAuth2\Server\CryptKey as BaseCryptKey;

/**
 * Class CryptKey
 * @package App\Api\V2
 */
class CryptKey extends BaseCryptKey
{
    /**
     * The key id. The key is found on the Json Web Key Set (JWKS) endpoint of the issuer.
     * @var string|null
     */
    public ?string $kid = null;

    /**
     * @param $keyPath
     * @param $passPhrase
     * @param bool $keyPermissionsCheck
     */
    public function __construct($keyPath, $passPhrase = null, bool $keyPermissionsCheck = true)
    {
        parent::__construct($keyPath, $passPhrase, $keyPermissionsCheck);
        $this->setKid(self::generateKeyId());
    }

    /**
     * @return string|null
     */
    public function getKid(): ?string
    {
        return $this->kid;
    }


    /**
     * @param $kid
     * @return self
     */
    public function setKid($kid): self
    {
        $this->kid = $kid;

        return $this;
    }

    /**
     * @param $value
     * @return string
     */
    public static function generateKeyId($value = null): string
    {
        return hash("sha256", $value ?: SITE_SERVER_NAME);
    }
}
