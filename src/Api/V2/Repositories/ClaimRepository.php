<?php

namespace App\Api\V2\Repositories;

use App\Api\V2\Entities\ClaimEntity;
use App\Api\V2\Entities\Interfaces\ClaimEntityInterface;
use App\Api\V2\Repositories\Interfaces\ClaimRepositoryInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * Class ClaimRepository
 * @package App\Api\V2\Repositories
 */
class ClaimRepository implements ClaimRepositoryInterface
{

    /**
     * @var array|string[]
     */
    private array $claims = [
        "sub",
        'name',
        'last_name',
        'email',
        'country',
        'phone',
        'company',
        'delivery',
        'billing',
        'skype',
        'position',
        'partner_statuses',
        'groups',
        "scopes",
        "usertype"
    ];

    /**
     * @var array
     */
    private array $map;

    /**
     *
     */
    public function __construct()
    {
        $claims = [];
        $scopeRepository = new ScopeRepository();
        foreach ($scopeRepository->getScopes() as $scope) {
            foreach ($this->claims as $claim) {
                $claims[$scope][] = new ClaimEntity($claim, ClaimEntityInterface::TYPE_USERINFO, true);
            }
        }
        $this->map = $claims;
    }

    public function getClaims(): array
    {
        return $this->claims;
    }

    /**
     * @param string $identifier
     * @param $type
     * @param $essential
     * @return ClaimEntityInterface|null
     */
    public function getClaimEntityByIdentifier(string $identifier, $type, $essential): ?ClaimEntityInterface
    {
        return new ClaimEntity($identifier, $type, $essential);
    }

    /**
     * @param ScopeEntityInterface $scope
     * @return iterable
     */
    public function getClaimsByScope(ScopeEntityInterface $scope): iterable
    {
        return $this->map[$scope->getIdentifier()];
    }

    /**
     * @param array|null $json
     * @return array
     */
    public function claimsRequestToEntities(array $json = null): ?array
    {
        $claims = [];
        if ($json) {
            foreach ($json as $claim=>$value) {
                if (in_array($claim, $this->claims, true)) {
                    $claims[] = $claim;
                }
            }
        }
        return count($claims) > 0 ? $claims : null;
    }
}
