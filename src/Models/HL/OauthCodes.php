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
class OauthCodes extends BaseD7Model
{

    /**
     * @inheritdoc
     */
    public static function tableClass(): string
    {
        return highloadblock_class('oauth_codes');
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
     * @return string
     */
    public function getRedirectURI(): string
    {
        return $this['UF_REDIRECT_URI'];
    }


    /**
     * @param $userId
     * @return OauthCodes| false
     */
    public static function getCodeByUserId($userId)
    {
        return self::filter(['UF_USER' => $userId])->first();
    }

    /**
     * @param string $identifier
     * @return OauthCodes|false
     */
    public static function getCodeByIdentifier(string $identifier)
    {
        return self::filter(['UF_IDENTIFIER' => $identifier])->first();
    }

    /**
     * @param string $identifier
     * @return bool
     * @throws ExceptionFromBitrix
     */
    public static function revokeUserCode(string $identifier): bool
    {
        $token = self::getCodeByIdentifier($identifier);
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
    public static function deleteUserCode($userId): bool
    {
        $token = self::getCodeByUserId($userId);
        if ($token) {
            return $token->delete();
        }
        return false;
    }

}
