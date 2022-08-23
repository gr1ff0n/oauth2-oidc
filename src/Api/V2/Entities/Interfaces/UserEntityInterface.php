<?php

namespace App\Api\V2\Entities\Interfaces;

use App\Models\User;
use League\OAuth2\Server\Entities\UserEntityInterface as LeagueUserEntityInterface;

/**
 * Interface UserEntityInterface
 */
interface UserEntityInterface extends LeagueUserEntityInterface
{
    /**
     * @return User|bool
     */
    public function getUser();

    /**
     * @param $user
     * @return void
     */
    public function setUser($user): void;

    /**
     * @return bool
     */
    public function isUserExist(): bool;

}
