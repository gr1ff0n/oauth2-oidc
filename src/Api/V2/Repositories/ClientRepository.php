<?php

namespace App\Api\V2\Repositories;

use App\Api\V2\Entities\ClientEntity;
use App\Models\HL\OauthClients;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

/**
 * Class ClientRepository
 * @package App\Api\V2\Repositories
 */
class ClientRepository implements ClientRepositoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier)
    {
        $client = new ClientEntity($clientIdentifier);
        $client->setIdentifier($clientIdentifier);
        return $client;
    }

    /**
     * {@inheritdoc}
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        $client = OauthClients::getClientByName($clientIdentifier);
        return $client && $client->getSecret() === $clientSecret;
    }
}
