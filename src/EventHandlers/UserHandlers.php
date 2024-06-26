<?php

namespace App\EventHandlers;

use App\Api\V2\Oauth2Controller;

/**
 * Class UserHandlers
 */
class UserHandlers
{

    /**
     * Редиректим пользователей на страницу по умолчанию (или в переадресовываем)
     * @param $fields
     */
    public static function redirectAfterLogin(&$fields): void
    {
        $from = static::checkFromParam();
        $url = false;
        if ($fields['USER_ID'] && $from) {
            if ($from === 'oauth2') {
                $url = Oauth2Controller::getAuthorizationLink(static::checkClientParam());
            }
            unset($_COOKIE['sso_from']);
            setcookie('sso_from', null, -1, '/');
            LocalRedirect($url, true);
        }


        if ($fields && $fields['RESULT_MESSAGE']['TYPE'] !== 'ERROR') {
            $uri = parse_url($_SERVER['REQUEST_URI']);
            if ($uri['path'] === '/') {
                LocalRedirect('/');
            }
        }
    }

    /**
     * @return false|string
     */
    public static function checkRedirectParam()
    {
        return $_GET['redirect_uri'] ?? $_COOKIE['sso_redirect_uri'] ?? false;
    }

    /**
     * @return false|string
     */
    public static function checkFromParam()
    {
        return $_GET['from'] ?? $_COOKIE['sso_from'] ?? false;
    }

    /**
     * @return false|string
     */
    public static function checkClientParam()
    {
        return $_GET['client_id'] ?? $_COOKIE['sso_client_id'] ?? false;
    }
}
