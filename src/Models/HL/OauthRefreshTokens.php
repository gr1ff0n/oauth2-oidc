<?php

namespace App\Models\HL;

use App\Models\BaseD7Model;
use DateTime;
use Uru\BitrixModels\Exceptions\ExceptionFromBitrix;

/**
 *
 */
class OauthRefreshTokens extends BaseD7Model
{

    /**
     * @inheritdoc
     */
    public static function tableClass(): string
    {
        return highloadblock_class('oauth_refresh_tokens');
    }


    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this['UF_IDENTIFIER'];
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this['UF_ACCESS_TOKEN'];
    }


    /**
     * @return DateTime|null
     */
    public function getExpiryDateTime(): ?DateTime
    {
        return $this['UF_EXPIRY_DATETIME'] ? datetime($this['UF_EXPIRY_DATETIME']) : null;
    }


    /**
     * @param string $identifier
     * @return OauthRefreshTokens|false
     */
    public static function getTokenByIdentifier(string $identifier)
    {
        return self::filter(['UF_IDENTIFIER' => $identifier])->first();
    }

    /**
     * @param string $identifier
     * @return OauthRefreshTokens|false
     */
    public static function getTokenByAccessIdentifier(string $identifier)
    {
        return self::filter(['UF_ACCESS_TOKEN' => $identifier])->first();
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

}
