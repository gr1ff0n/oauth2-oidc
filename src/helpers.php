<?php

use App\Models\User;
use Bitrix\Main\Entity\Base;
use Monolog\Logger;
use Monolog\Registry;
use Uru\BitrixIblockHelper\HLblock;
use Uru\BitrixIblockHelper\IblockId;

/**
 * Получение ID инфоблока по коду (или по коду и типу).
 * Всегда выполняет лишь один запрос в БД на скрипт.
 *
 * @param string $code
 * @param string|null $type
 * @return int
 *
 * @throws RuntimeException
 */
function iblock_id(string $code, ?string $type = null): int
{
    return IblockId::getByCode($code, $type);
}

/**
 * Получение данных хайлоадблока по названию его таблицы.
 * Всегда выполняет лишь один запрос в БД на скрипт и возвращает массив вида:
 *
 * array:3 [
 *   "ID" => "2"
 *   "NAME" => "Subscribers"
 *   "TABLE_NAME" => "app_subscribers"
 * ]
 *
 * @param string $table
 * @return array
 */
function highloadblock(string $table): array
{
    return HLblock::getByTableName($table);
}

/**
 * Компилирование и возвращение класса для хайлоадблока для таблицы $table.
 *
 * Пример для таблицы `app_subscribers`:
 * $subscribers = highloadblock_class('app_subscribers');
 * $subscribers::getList();
 *
 * @param string $table
 * @return string
 */
function highloadblock_class(string $table): string
{
    return HLblock::compileClass($table);
}

/**
 * Компилирование сущности для хайлоадблока для таблицы $table.
 * Выполняется один раз.
 *
 * Пример для таблицы `app_subscribers`:
 * $entity = \Uru\BitrixIblockHelper\HLblock::compileEntity('app_subscribers');
 * $query = new Entity\Query($entity);
 *
 * @param string $table
 * @return Base
 */
function highloadblock_entity(string $table): Base
{
    return HLblock::compileEntity($table);
}

/**
 * logger()->error('Error message here');
 *
 * @param string $name
 * @return Logger
 */
function logger(string $name = 'common'): Logger
{
    if (!Registry::hasLogger($name)) {
        Registry::addLogger(new Logger($name), $name);
    }
    return Registry::getInstance($name);
}

/**
 * @param int|null $id
 * @return User|bool
 */
function user(?int $id = null)
{
    return is_null($id) ? User::current() : User::query()->getById($id);
}

/**
 * Получить объект работы с датой
 * @param string $date
 * @param string|null $format
 * @return DateTime
 */
function datetime(string $date, ?string $format = null): DateTime
{
    if (is_null($format)) {
        $dateTime = DateTime::createFromFormat(date_format_full(), $date);
        if ($dateTime) {
            return $dateTime;
        }

        $format = date_format_short();
    }

    return DateTime::createFromFormat($format, $date);
}

/**
 * @param bool $midnight Получить не текущее время, а полночь
 * @return string
 */
function date_format_full(bool $midnight = false): string
{
    global $DB;
    $format = $DB->DateFormatToPHP(CSite::GetDateFormat());

    if ($midnight) {
        return str_replace(
            ['H', 'i', 's'],
            '00',
            $format
        );
    }

    return $format;
}

/**
 * @return string
 */
function date_format_short(): string
{
    global $DB;
    return $DB->DateFormatToPHP(CSite::GetDateFormat("SHORT"));
}

/**
 * @param bool $dateOnly Показывать только дату или еще и время
 * @return string
 */
function date_format_filter(bool $dateOnly = false): string
{
    return $dateOnly ? 'Y-m-d' : 'Y-m-d H:i:s';
}
