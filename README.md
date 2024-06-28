# Oauth2 with OIDC for Bitrix
Адаптированный под PHP 8.3 вариант реализации Oauth 2.0 на основе сервера - oauth2-server, интеграции uru/bitrix-mvc и slim 4.
- league/oauth2-server - https://oauth2.thephpleague.com
- uru/bitrix-mvc - https://github.com/Uru-ruru/bitrix-mvc
- slim/slim - https://www.slimframework.com

Дополнен OpenID Connect https://openid.net/specs/openid-connect-core-1_0.html (OIDC) и реализует аутентификацию пользователя через логин/пароль так и SSO для внешних клиентов.
Может использоваться для интеграции Бека на Битрикс с React или Vue фронтом.

## Структура

- migrations - миграции по созданию необходимых HL инфоблоков в Битриксе
- src/Api/V2 - реализация сервера
- src/Models/HL - модели сущностей для работы сервера
- src/Models/User.php - обертка над $USER Битрикса (как пример работы с пользователем)
- src/api.php - роутинг API

## Настройка

В данном описании не учитываются настройки используемых пакетов. Настройка сервера https://oauth2.thephpleague.com/installation/,
slim https://www.slimframework.com/docs/v4/start/installation.html 

### Битрикс
- Добавить в `/local/php_interface/init.php`
````php
use App\EventHandlers\UserHandlers;
require_once ( $_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php' );

...

$em = Bitrix\Main\EventManager::getInstance();
$em->addEventHandler('main', 'OnAfterUserLogin', [UserHandlers::class, "redirectAfterLogin"]);
````
- Создать файл конфига в папке `'config/.env.php'` по примеру в папке `config/.env.example.php`


## Реализованные методы API

- /.well-known/openid-configuration - https://openid.net/specs/openid-connect-discovery-1_0.html
- /certs - https://openid.net/specs/draft-jones-json-web-key-03.html
- /authorize - https://openid.net/specs/openid-connect-core-1_0.html#AuthorizationEndpoint
- /access_token - https://openid.net/specs/openid-connect-core-1_0.html#TokenEndpoint
- /logout
- /v2/user

## Варианты авторизации

- https://oauth2.thephpleague.com/authorization-server/auth-code-grant/
- https://oauth2.thephpleague.com/authorization-server/resource-owner-password-credentials-grant/


