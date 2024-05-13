<?php
/**
 * Возвращает ID инфоблока по его символьному коду
 * @param string $code           символьный код инфоблока
 */
function getIblockIdByCode(string $code): int {
    if (empty($code)) {
        return -1;
    }

    Bitrix\Main\Loader::includeModule('iblock');

    $arIblock = Bitrix\Iblock\IblockTable::getList([
        'filter' => ['=CODE' => $code],
        'select' => ['ID'],
        'limit' => 1,
    ])->fetch();

    if (empty($arIblock)) {
        return -1;
    }

    return (int) $arIblock['ID'];
}

/**
 * Выводит на страницу содержимое функции print_r внутри тега <pre></pre>
 * @param mixed $value
 */
function printRPre(mixed $value): void {
    echo '<pre>' . print_r($value, true) . '</pre>';
}


/**
 * Получение дата-класса хайлоада по названию сущности
 * @param string $entityName        название сущности
 */
function getHLEntity(string $entityName): string {
    Bitrix\Main\Loader::includeModule('highloadblock');
    return Bitrix\Highloadblock\HighloadBlockTable::compileEntity($entityName)->getDataClass();
}
