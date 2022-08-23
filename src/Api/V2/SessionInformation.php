<?php

namespace App\Api\V2;

/**
 * Class SessionInformation
 * @package App\Api\V2
 */
class SessionInformation
{
    /**
     * @var
     */
    public $acr;
    /**
     * @var
     */
    public $amr;
    /**
     * @var
     */
    public $azp;

    /**
     * @throws \JsonException
     */
    public static function fromJSON($json): SessionInformation
    {
        $json = json_decode($json, false, 512, JSON_THROW_ON_ERROR);

        $result = new self();

        $result->setAzp($json->azp);
        $result->setAcr($json->acr);
        $result->setAzp($json->azp);

        return $result;
    }

    /**
     * @throws \JsonException
     */
    public function toJSON()
    {
        return json_encode(['acr' => $this->acr, 'amr' => $this->amr, 'azp' => $this->azp], JSON_THROW_ON_ERROR);
    }

    /**
     * @throws \JsonException
     */
    public function __toString(): string
    {
        return $this->toJSON() ?: '';
    }


    /**
     * Get the value of acr
     */
    public function getAcr()
    {
        return $this->acr;
    }

    /**
     * Set the value of acr
     *
     * @param $acr
     * @return  self
     */
    public function setAcr($acr): SessionInformation
    {
        $this->acr = $acr;

        return $this;
    }

    /**
     * Get the value of amr
     */
    public function getAmr()
    {
        return $this->amr;
    }

    /**
     * Set the value of amr
     *
     * @param $amr
     * @return  self
     */
    public function setAmr($amr): SessionInformation
    {
        $this->amr = $amr;

        return $this;
    }

    /**
     * Get the value of azp
     */
    public function getAzp()
    {
        return $this->azp;
    }

    /**
     * Set the value of azp
     *
     * @param $azp
     * @return  self
     */
    public function setAzp($azp): SessionInformation
    {
        $this->azp = $azp;

        return $this;
    }
}
