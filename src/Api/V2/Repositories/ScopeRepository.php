<?php

namespace App\Api\V2\Repositories;

use App\Api\V2\Entities\ScopeEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

/**
 * Class ScopeRepository
 * @package App\Api\V2\Repositories
 */
class ScopeRepository implements ScopeRepositoryInterface
{

    /**
     * @var array|\string[][]
     */
    private array $scopes = [
        'basic' => [
            'description' => 'Basic details',
        ],
        'admin' => [
            'description' => 'Admin',
        ],
        'openid' => [
            'description' => 'OIDC',
        ],
        'profile' => [
            'description' => 'Profile',
        ]
    ];

    /**
     * @return array
     */
    public function getScopes(): array
    {
        $scopes = [];
        foreach ($this->scopes as $scope => $params) {
            $scopes[] = $scope;
        }
        return $scopes;
    }

    /**
     * @param $identifier
     * @return ScopeEntity|false
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        if (array_key_exists($identifier, $this->scopes) === false) {
            return false;
        }

        $scope = new ScopeEntity();
        $scope->setIdentifier($identifier);
        return $scope;
    }

    /**
     * @param array $scopes
     * @param $grantType
     * @param ClientEntityInterface $clientEntity
     * @param $userIdentifier
     * @return array|ScopeEntityInterface[]
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null): array
    {
        if ((int)$userIdentifier === 1) {
            $scope = new ScopeEntity();
            $scope->setIdentifier('admin');
            $scopes[] = $scope;
        }
        return $scopes;
    }
}
