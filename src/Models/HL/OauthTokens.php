<?php

namespace App\Models\HL;

use App\Models\User;
use App\Models\BaseD7Model;
use DateTime;
use Uru\BitrixModels\Exceptions\ExceptionFromBitrix;
use Uru\BitrixModels\Queries\BaseQuery;

/**
 *
 * @property  User $user
 * @property  OauthClients $client
 */
class OauthTokens extends BaseD7Model
{

    /**
     * @inheritdoc
     */
    public static function tableClass(): string
    {
        return highloadblock_class('oauth_tokens');
    }

    /**
     * @return BaseQuery
     */
    public function user(): BaseQuery
    {
        return $this->hasOne(User::class, 'ID', 'UF_USER');
    }

    /**
     * @return BaseQuery
     */
    public function client(): BaseQuery
    {
        return $this->hasOne(OauthClients::class, 'ID', 'UF_CLIENT');
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this['UF_CLIENT'];
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this['UF_IDENTIFIER'];
    }

    /**
     * @return array
     */
    public function getScopes(): array
    {
        return $this['UF_SCOPES'];
    }

    /**
     * @return DateTime|null
     */
    public function getExpiryDateTime(): ?DateTime
    {
        return $this['UF_EXPIRY_DATETIME'] ? datetime($this['UF_EXPIRY_DATETIME']) : null;
    }


    /**
     * @param $userId
     * @return OauthTokens| false
     */
    public static function getTokenByUserId($userId)
    {
        return self::filter(['UF_USER' => $userId])->first();
    }

    /**
     * @param string $identifier
     * @return OauthTokens|false
     */
    public static function getTokenByIdentifier(string $identifier)
    {
        return self::filter(['UF_IDENTIFIER' => $identifier])->first();
    }

    /**
     * @param string $identifier
     * @return bool
     * @throws ExceptionFromBitrix
     */
    public static function revokeUserToken(string $identifier): bool
    {
        $token = self::getTokenByIdentifier($identifier);
        if ($token) {
            return $token->delete();
        }
        return false;
    }

    /**
     * @param $userId
     * @return bool
     * @throws ExceptionFromBitrix
     */
    public static function deleteUserToken($userId): bool
    {
        $token = self::getTokenByUserId($userId);
        if ($token) {
            return $token->delete();
        }
        return false;
    }

}
