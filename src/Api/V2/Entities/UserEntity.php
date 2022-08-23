<?php

namespace App\Api\V2\Entities;

use App\Api\V2\Entities\Interfaces\UserEntityInterface;
use App\Models\User;


/**
 * Class UserEntity
 * @package App\Api\V2\Entities
 */
class UserEntity implements UserEntityInterface
{
    /**
     * @var User|bool
     */
    private $user;

    /**
     * @param User|null $user
     */
    public function __construct(User $user = null)
    {
        $this->user = $user ?: user();
    }

    /**
     * @return User|bool
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User|bool $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function isUserExist(): bool
    {
        return (bool)$this->user;
    }

    /**
     * Return the user's identifier.
     *
     * @return int|null
     */
    public function getIdentifier(): ?int
    {
        return $this->user ? $this->user->getId() : null;
    }
}
