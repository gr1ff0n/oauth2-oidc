<?php

namespace App\Api\V2\Entities;

use App\Models\HL\OauthClients;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

/**
 * Class ClientEntity
 * @package App\Api\V2\Entities
 */
class ClientEntity implements ClientEntityInterface
{
    use EntityTrait;
    use ClientTrait;

    /**
     * @var array
     */
    private array $customVariables = [];

    /**
     * @var bool
     */
    private bool $loaded = false;

    /**
     * @param $clientIdentifier
     */
    public function __construct($clientIdentifier = null)
    {
        if ($clientIdentifier) {
            $client = OauthClients::getClientByName($clientIdentifier);
            if ($client) {
                $this->setLoaded();
                $this->setName($client->getName());
                $this->setRedirectUri($client->getRedirectUri());
                $this->setCustomVariables($client->getCustomVariables());
                if ($client->isConfidential()) {
                    $this->setConfidential();
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function isLoaded(): bool
    {
        return $this->loaded;
    }

    /**
     * Set client loaded status
     */
    public function setLoaded(): void
    {
        $this->loaded = true;
    }


    /**
     * @param $name
     * @return void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param $uri
     * @return void
     */
    public function setRedirectUri($uri): void
    {
        $this->redirectUri = $uri;
    }

    /**
     * @return void
     */
    public function setConfidential(): void
    {
        $this->isConfidential = true;
    }

    /**
     * @return array
     */
    public function getCustomVariables(): array
    {
        return $this->customVariables;
    }

    /**
     * @param array $customVariables
     */
    public function setCustomVariables(array $customVariables): void
    {
        $this->customVariables = $customVariables;
    }
}
