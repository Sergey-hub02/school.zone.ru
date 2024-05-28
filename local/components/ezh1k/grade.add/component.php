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

/*========== ПОЛУЧЕНИ УЧАЩИХСЯ ==========*/
$STUDENTS_IB = getIblockIdByCode('students');

$arFilter = [
    'IBLOCK_ID' => $STUDENTS_IB,
    'ACTIVE' => 'Y',
];

$arSelect = [
    'ID',
    'NAME',
    'PROPERTY_STUDENT_CLASS',
    'PROPERTY_STUDENT_CLASS.NAME',
];

$arStudents = CIBlockElement::GetList(
    $arOrder,
    $arFilter,
    false,
    false,
    $arSelect
);

$arResult['STUDENTS'] = [];
while ($student = $arStudents->GetNextElement()) {
    $student = $student->GetFields();

    $arResult['STUDENTS'][$student['ID']] = [
        'ID' => $student['ID'],
        'FIO' => $student['NAME'],
        'CLASS' => $student['PROPERTY_STUDENT_CLASS_NAME'],
    ];
}

/*========== ВЫСТАВЛЕНИЕ ОЦЕНКИ ==========*/
$SCHEDULE_IB = getIblockIdByCode('schedule');
$CLASSES_IB = getIblockIdByCode('classes');
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

if (isset($_REQUEST['add_grade']) && check_bitrix_sessid()) {
    $gradeDate = htmlspecialchars(trim($_REQUEST['grade_date']));
    $subject = $_REQUEST['subject'];
    $student = $_REQUEST['student'];
    $grade = $_REQUEST['grade'];

    $errors = [];

    if (empty($gradeDate)) {
        $errors[] = 'Пожалуйста, заполните поле "Дата"!';
    }
    if (empty($subject)) {
        $errors[] = 'Пожалуйста, выберите дисциплину!';
    }
    if (empty($student)) {
        $errors[] = 'Пожалуйста, выберите учащегося!';
    }
    if (empty($grade)) {
        $errors[] = 'Пожалуйста, выберите оценку!';
    }

    if (!empty($errors)) {
        $arResult['SUCCESS'] = 'N';
        $arResult['ERRORS'] = $errors;

        $this->includeComponentTemplate();
        return;
    }

    $gradeDate = date('d.m.Y', strtotime($gradeDate));
    $dayOfWeek = (int) date('w', strtotime($gradeDate));

    $arFilter = [
        'IBLOCK_ID' => $STUDENTS_IB,
        'ID' => $student,
        'ACTIVE' => 'Y',
    ];

    $arSelect = [
        'ID',
        'NAME',
        'PROPERTY_STUDENT_CLASS.PROPERTY_CLASS_SCHEDULE',
        'PROPERTY_STUDENT_USER_ID',
    ];

    $arStudent = CIBlockElement::GetList(
        [],
        $arFilter,
        false,
        false,
        $arSelect
    );

    if (!($stud = $arStudent->GetNextElement())) {
        $arResult['ERRORS'][] = 'Не удалось найти учащегося!';
        $this->includeComponentTemplate();
        return;
    }

    $stud = $stud->GetFields();
    $scheduleId = $stud['PROPERTY_STUDENT_CLASS_PROPERTY_CLASS_SCHEDULE_VALUE'];

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

    $gradesHL = getHLEntity('Grades');

    $arGradeAdd = [
        'UF_GRADE_SUBJECT' => $subject,
        'UF_GRADE_USER' => $stud['PROPERTY_STUDENT_USER_ID_VALUE'],
        'UF_GRADE_LESSON_NUMBER' => $lessonNumber,
        'UF_GRADE_TEXT' => $grade,
        'UF_GRADE_DATE' => $gradeDate,
    ];

    if (!$gradesHL::add($arGradeAdd)->isSuccess()) {
        $arResult['SUCCESS'] = 'N';
        $arResult['ERRORS'][] = 'Не удалось поставить оценку!';
        $this->includeComponentTemplate();
        return;
    }

    $arResult['SUCCESS'] = 'Y';
    $_REQUEST = [];
}

$this->includeComponentTemplate();
