<?php
/**
 * @var array $arResult
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock') || !Loader::includeModule('highloadblock')) {
    echo '<div class="container" style="color: var(--my-red)">Не удалось подключить нужные модули!</div>';
    return;
}

/*========== ПОЛУЧЕНИЕ ДИСЦИПЛИН ==========*/
$SUBJECTS_IB = getIblockIdByCode('subjects');

$arOrder = ['name' => 'asc'];

$arFilter = [
    'IBLOCK_ID' => $SUBJECTS_IB,
    'ACTIVE' => 'Y',
];

$arSelect = [
    'ID',
    'NAME',
];

$arSubjects = CIBlockElement::GetList(
    $arOrder,
    $arFilter,
    false,
    false,
    $arSelect
);

$arResult['SUBJECTS'] = [];
while ($subject = $arSubjects->GetNextElement()) {
    $subject = $subject->GetFields();

    $arResult['SUBJECTS'][$subject['ID']] = [
        'ID' => $subject['ID'],
        'NAME' => $subject['NAME'],
    ];
}

/*========== ПОЛУЧЕНИЕ КЛАССОВ ==========*/
$CLASSES_IB = getIblockIdByCode('classes');

$arFilter = [
    'IBLOCK_ID' => $CLASSES_IB,
    'ACTIVE' => 'Y',
];

$arClasses = CIBlockElement::GetList(
    $arOrder,
    $arFilter,
    false,
    false,
    $arSelect
);

$arResult['CLASSES'] = [];
while ($class = $arClasses->GetNextElement()) {
    $class = $class->GetFields();

    $arResult['CLASSES'][$class['ID']] = [
        'ID' => $class['ID'],
        'NAME' => $class['NAME'],
    ];
}

/*========== ВЫСТАВЛЕНИЕ ОЦЕНКИ ==========*/
$SCHEDULE_IB = getIblockIdByCode('schedule');
$SCHOOL_DAYS_IB = getIblockIdByCode('school_days');

$DAYS_OF_WEEK = [
    'sunday',
    'monday',
    'tuesday',
    'wednesday',
    'thursday',
    'friday',
    'saturday',
];

if (isset($_REQUEST['add_homework']) && check_bitrix_sessid()) {
    $homeworkDate = htmlspecialchars(trim($_REQUEST['homework_date']));
    $subject = $_REQUEST['subject'];
    $class = $_REQUEST['class'];
    $homework = htmlspecialchars(trim($_REQUEST['homework']));
    $attachment = $_FILES['attachment'];

    $errors = [];

    if (empty($homeworkDate)) {
        $errors[] = 'Пожалуйста, заполните поле "Дата"!';
    }
    if (empty($subject)) {
        $errors[] = 'Пожалуйста, выберите дисциплину!';
    }
    if (empty($class)) {
        $errors[] = 'Пожалуйста, выберите класс!';
    }
    if (empty($homework)) {
        $errors[] = 'Пожалуйста, заполните поле "Домашнее задание"!';
    }

    if (!empty($errors)) {
        $arResult['SUCCESS'] = 'N';
        $arResult['ERRORS'] = $errors;

        $this->includeComponentTemplate();
        return;
    }

    $homeworkDate = date('d.m.Y', strtotime($homeworkDate));
    $dayOfWeek = (int) date('w', strtotime($homeworkDate));

    $arFilter = [
        'IBLOCK_ID' => $CLASSES_IB,
        'ID' => $class,
        'ACTIVE' => 'Y',
    ];

    $arSelect = [
        'ID',
        'NAME',
        'PROPERTY_CLASS_SCHEDULE',
    ];

    $arClass = CIBlockElement::GetList(
        [],
        $arFilter,
        false,
        false,
        $arSelect
    );

    if (!($cls = $arClass->GetNextElement())) {
        $arResult['ERRORS'][] = 'Не удалось найти класс!';
        $this->includeComponentTemplate();
        return;
    }

    $cls = $cls->GetFields();
    $scheduleId = $cls['PROPERTY_CLASS_SCHEDULE_VALUE'];

    $arOrder = ['id' => 'asc'];

    $arFilter = [
        'IBLOCK_ID' => $SCHOOL_DAYS_IB,
        'ACTIVE' => 'Y',
        'PROPERTY_SCHOOL_DAY_SCHEDULE' => $scheduleId,
        'PROPERTY_SCHOOL_DAY_DAY_OF_WEEK' => $DAYS_OF_WEEK[$dayOfWeek],
    ];

    $arSelect = [
        'ID',
        'NAME',
        'PROPERTY_SCHOOL_DAY_DAY_OF_WEEK',
        'PROPERTY_SCHOOL_DAY_LESSON_1',
        'PROPERTY_SCHOOL_DAY_LESSON_2',
        'PROPERTY_SCHOOL_DAY_LESSON_3',
        'PROPERTY_SCHOOL_DAY_LESSON_4',
        'PROPERTY_SCHOOL_DAY_LESSON_5',
        'PROPERTY_SCHOOL_DAY_LESSON_6',
        'PROPERTY_SCHOOL_DAY_LESSON_7',
        'PROPERTY_SCHOOL_DAY_LESSON_8',
        'PROPERTY_SCHOOL_DAY_SCHEDULE',
    ];

    $arSchoolDays = CIBlockElement::GetList(
        $arOrder,
        $arFilter,
        false,
        false,
        $arSelect
    );

    if (!($schoolDay = $arSchoolDays->GetNextElement())) {
        $arResult['SUCCESS'] = 'N';
        $arResult['ERRORS'] = 'Не удалось найти учебный день!';

        $this->includeComponentTemplate();
        return;
    }

    $schoolDay = $schoolDay->GetFields();
    $lessonNumber = 0;

    for ($i = 1; $i <= 8; ++$i) {
        if ($schoolDay['PROPERTY_SCHOOL_DAY_LESSON_' . $i . '_VALUE'] == $subject) {
            $lessonNumber = $i;
            break;
        }
    }

    $homeworkHL = getHLEntity('Homework');

    $arHomeworkAdd = [
        'UF_HOMEWORK_DATE' => $homeworkDate,
        'UF_HOMEWORK_LESSON_NUMBER' => $lessonNumber,
        'UF_HOMEWORK_TEXT' => $homework,
        'UF_HOMEWORK_CLASS' => $class,
        'UF_HOMEWORK_ATTACHMENT' => $attachment,
    ];

    if (!$homeworkHL::add($arHomeworkAdd)->isSuccess()) {
        $arResult['SUCCESS'] = 'N';
        $arResult['ERRORS'][] = 'Не удалось добавить домашнее задание!';

        $this->includeComponentTemplate();
        return;
    }

    $arResult['SUCCESS'] = 'Y';
    $_REQUEST = [];
}

$this->includeComponentTemplate();
