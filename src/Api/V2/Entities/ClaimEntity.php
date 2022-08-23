<?php

namespace App\Api\V2\Entities;

use App\Api\V2\Entities\Interfaces\ClaimEntityInterface;

/**
 * Class ClaimEntity
 * @package App\Api\V2\Entities
 */
class ClaimEntity implements ClaimEntityInterface
{
    /**
     * @var string
     */
    private string $type;
    /**
     * @var bool|mixed
     */
    private bool $essential;
    /**
     * @var string
     */
    private string $identifier;

    /**
     * @param $identifier
     * @param $type
     * @param bool $essential
     */
    public function __construct($identifier, $type, bool $essential = true)
    {
        $this->identifier = $identifier;
        $this->type = $type;
        $this->essential = $essential;
    }


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function getEssential(): bool
    {
        return $this->essential;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'identifier' => $this->getIdentifier(),
            'type' => $this->getType(),
            'essential' => $this->getEssential()
        ];
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
