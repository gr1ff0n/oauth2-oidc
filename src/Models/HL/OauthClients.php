<?php

namespace App\Models\HL;

use App\Models\User;
use App\Models\BaseD7Model;

/**
 *
 * @property  User $user
 */
class OauthClients extends BaseD7Model
{

    /**
     * @inheritdoc
     */
    public static function tableClass(): string
    {
        return highloadblock_class('oauth_clients');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this['UF_NAME'];
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this['UF_SECRET'];
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        return $this['UF_REDIRECT_URI'];
    }

    /**
     * @return bool
     */
    public function isConfidential(): bool
    {
        return (int)$this['UF_IS_CONFIDENTIAL'] > 0;
    }

    /**
     * @return array
     */
    public function getCustomVariables(): array
    {
        return $this['UF_CUSTOM_VARIABLES'];
    }

    /**
     * @param $name
     * @return OauthClients | false
     */
    public static function getClientByName($name)
    {
        return self::filter(['UF_NAME' => $name])->first();
    }

}
