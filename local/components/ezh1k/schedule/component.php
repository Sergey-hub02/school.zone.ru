<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Iblock\Elements\ElementStudentsTable;
use Bitrix\Iblock\Elements\ElementSchoolDaysTable;

if (!Loader::includeModule('iblock')) {
    echo '<div class="container" style="color: var(--my-red)">Не удалось подключить модуль "iblock"!</div>';
    return;
}

$arSelect = [
    'ID',
    'NAME',
    'STUDENT_CLASS.ELEMENT.ID',
    'STUDENT_CLASS.ELEMENT.NAME',
    'STUDENT_CLASS.ELEMENT.CLASS_SCHEDULE',
];

$arFilter = ['=STUDENT_USER_ID.VALUE' => $GLOBALS['USER']->getID()];

$arStudent = ElementStudentsTable::getList([
    'select' => $arSelect,
    'filter' => $arFilter,
]);

if (!($student = $arStudent->fetch())) {
    echo '<div class="container" style="color: var(--my-red)">Страница недоступна!</div>';
    return;
}

$scheduleId = $student['IBLOCK_ELEMENTS_ELEMENT_STUDENTS_STUDENT_CLASS_ELEMENT_CLASS_SCHEDULE_VALUE'];

if (empty($scheduleId)) {
    echo '<div class="container" style="color: var(--my-red)">Не удалось найти расписание!</div>';
    return;
}

$scheduleId = (int) $scheduleId;

$arOrder = ['SCHOOL_DAY_DAY_OF_WEEK.ID' => 'asc'];

$arSelect = [
    'ID',
    'NAME',
    'SCHOOL_DAY_DAY_OF_WEEK',
    'SCHOOL_DAY_LESSON_1.ELEMENT.NAME',
    'SCHOOL_DAY_LESSON_2.ELEMENT.NAME',
    'SCHOOL_DAY_LESSON_3.ELEMENT.NAME',
    'SCHOOL_DAY_LESSON_4.ELEMENT.NAME',
    'SCHOOL_DAY_LESSON_5.ELEMENT.NAME',
    'SCHOOL_DAY_LESSON_6.ELEMENT.NAME',
    'SCHOOL_DAY_LESSON_7.ELEMENT.NAME',
    'SCHOOL_DAY_LESSON_8.ELEMENT.NAME',
];

$arFilter = ['=SCHOOL_DAY_SCHEDULE.VALUE' => $scheduleId];

$arSchoolDays = ElementSchoolDaysTable::getList([
    'order' => $arOrder,
    'select' => $arSelect,
    'filter' => $arFilter,
]);


$dayIterator = new DateTime(
    date('d.m.Y', strtotime('monday this week')),
    new DateTimeZone('Europe/Moscow')
);

$interval = DateInterval::createFromDateString('1 day');

$currentDate = date('d.m.Y');

$arResult['SCHOOL_DAYS'] = [];
while ($day = $arSchoolDays->fetch()) {
    $day['DATE'] = $dayIterator->format('d.m.Y');

    for ($i = 1; $i <= 8; ++$i) {
        $lessonName = $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_' . $i . '_ELEMENT_NAME'] ?? 'Нет урока';
        $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_' . $i . '_ELEMENT_NAME'] = $lessonName;
    }

    $arResult['SCHOOL_DAYS'][] = [
        'ID' => $day['ID'],
        'NAME' => $day['NAME'],
        'DATE' => $day['DATE'],
        'LESSON_1' => $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_1_ELEMENT_NAME'],
        'LESSON_2' => $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_2_ELEMENT_NAME'],
        'LESSON_3' => $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_3_ELEMENT_NAME'],
        'LESSON_4' => $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_4_ELEMENT_NAME'],
        'LESSON_5' => $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_5_ELEMENT_NAME'],
        'LESSON_6' => $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_6_ELEMENT_NAME'],
        'LESSON_7' => $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_7_ELEMENT_NAME'],
        'LESSON_8' => $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_8_ELEMENT_NAME'],
    ];

    $dayIterator->add($interval);
}

$this->includeComponentTemplate();
