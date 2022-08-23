<?php

namespace App\Api\V2\ResponseTypes\Interfaces;

use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface as LeagueResponseTypeInterface;

/**
 *
 */
interface ResponseTypeInterface extends LeagueResponseTypeInterface
{
    /**
     * @param $idToken
     * @return void
     */
    public function setIdToken($idToken): void;

    /**
     * @return mixed
     */
    public function getIdToken();
}
