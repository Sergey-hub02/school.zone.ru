<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\UserTable;
use Bitrix\Iblock\Elements\ElementStudentsTable;

if (!Loader::includeModule('iblock')) {
    echo '<div class="container" style="color: var(--my-red)">Не удалось подключить модуль "iblock"!</div>';
    return;
}

/*========== ПОЛУЧЕНИЕ ПОЛЬЗОВАТЕЛЬСКИХ ДАННЫХ ==========*/
$arSelect = [
    'ID',
    'LAST_NAME',
    'NAME',
    'SECOND_NAME',
    'LOGIN',
    'EMAIL',
    'DATE_REGISTER',
    'LAST_LOGIN',
    'PERSONAL_GENDER',
    'PERSONAL_BIRTHDAY',
    'PERSONAL_PHONE',
];

$arFilter = ['=ID' => $GLOBALS['USER']->getID()];

$arUser = UserTable::getList([
    'select' => $arSelect,
    'filter' => $arFilter,
]);

if (!($user = $arUser->fetch())) {
    echo '<div class="container" style="color: var(--my-red)">Страница не доступна!</div>';
    return;
}

$user['FULL_NAME'] = trim($user['LAST_NAME'] . ' ' . $user['NAME'] . ' ' . $user['SECOND_NAME']);

$user['PERSONAL_GENDER'] = match ($user['PERSONAL_GENDER']) {
    'M' => 'Мужской',
    'F' => 'Женский',
    default => 'Неизвестный',
};

$birthday = explode('.', $user['PERSONAL_BIRTHDAY']->toString());
$age = (date("md", date("U", mktime(0, 0, 0, $birthday[1], $birthday[0], $birthday[2]))) > date("md")
    ? ((date("Y") - $birthday[2]) - 1)
    : (date("Y") - $birthday[2]));

$user['AGE'] = $age;

/*========== ПОЛУЧЕНИЕ ДАННЫХ УЧАЩИХСЯ ==========*/
$arFilter = ['=STUDENT_USER_ID.VALUE' => $GLOBALS['USER']->getID()];

$arSelect = [
    'ID',
    'NAME',
    'STUDENT_USER_ID_' => 'STUDENT_USER_ID',
    'STUDENT_SCHOOL.ELEMENT.NAME',
    'STUDENT_ENROLLMENT_YEAR_' => 'STUDENT_ENROLLMENT_YEAR',
];

$arStudent = ElementStudentsTable::getList([
    'select' => $arSelect,
    'filter' => $arFilter,
]);

if (!($student = $arStudent->fetch())) {
    echo '<div class="container" style="color: var(--my-red)">Страница не доступна!</div>';
    return;
}

$arResult['USER'] = $user;
$arResult['STUDENT'] = $student;

$this->includeComponentTemplate();
