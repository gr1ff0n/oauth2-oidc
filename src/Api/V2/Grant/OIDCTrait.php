<?php

namespace App\Api\V2\Grant;

/**
 * Trait OIDCTrait
 * @package App\Api\V2\Grant
 */
trait OIDCTrait
{
    /**
     * @var string
     */
    protected string $issuer;

    /**
     * @param $issuer
     * @return void
     */
    public function setIssuer($issuer): void
    {
        $this->issuer = $issuer;
    }

    /**
     * @return string
     */
    public function getIssuer(): string
    {
        return $this->issuer;
    }
}
