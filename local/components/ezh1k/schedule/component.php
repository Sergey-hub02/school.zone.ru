<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Iblock\Elements\ElementStudentsTable;
use Bitrix\Iblock\Elements\ElementSchoolDaysTable;
use Bitrix\Highloadblock\HighloadBlockTable;

if (!Loader::includeModule('iblock') || !Loader::includeModule('highloadblock')) {
    echo '<div class="container" style="color: var(--my-red)">Не удалось подключить нужные модули!</div>';
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

    $arResult['SCHOOL_DAYS'][$day['DATE']] = [
        'ID' => $day['ID'],
        'NAME' => $day['NAME'],
        'DATE' => $day['DATE'],
    ];

    for ($i = 1; $i <= 8; ++$i) {
        $arResult['SCHOOL_DAYS'][$day['DATE']]["LESSON_$i"] = [
            'NAME' => $day['IBLOCK_ELEMENTS_ELEMENT_SCHOOL_DAYS_SCHOOL_DAY_LESSON_' . $i . '_ELEMENT_NAME'],
            'HOMEWORK' => '',
            'GRADE' => '',
        ];
    }

    $dayIterator->add($interval);
}

/*========== ПОЛУЧЕНИЕ ДОМАШНИХ ЗАДАНИЙ ==========*/
$daysArray = array_map(
    fn (array $day) => $day['DATE'],
    $arResult['SCHOOL_DAYS']
);

$studentClass = $student['IBLOCK_ELEMENTS_ELEMENT_STUDENTS_STUDENT_CLASS_ELEMENT_ID'];
$homeworkEntity = getHLEntity('Homework');

$arHomeworkOrder = ['UF_HOMEWORK_DATE' => 'ASC'];

$arHomeworkFilter = [
    'UF_HOMEWORK_DATE' => $daysArray,
    'UF_HOMEWORK_CLASS' => $studentClass,
];

$arHomeworkSelect = [
    'ID',
    'UF_HOMEWORK_DATE',
    'UF_HOMEWORK_LESSON_NUMBER',
    'UF_HOMEWORK_TEXT',
];

$arHomework = $homeworkEntity::getList([
    'order' => $arHomeworkOrder,
    'filter' => $arHomeworkFilter,
    'select' => $arHomeworkSelect,
]);

while ($hw = $arHomework->fetch()) {
    $date = $hw['UF_HOMEWORK_DATE']->toString();
    $lessonNumber = $hw['UF_HOMEWORK_LESSON_NUMBER'];
    $arResult['SCHOOL_DAYS'][$date]["LESSON_$lessonNumber"]['HOMEWORK'] = $hw['UF_HOMEWORK_TEXT'];
}

/*========== ПОЛУЧЕНИЕ ОЦЕНОК ==========*/
$gradesEntity = getHLEntity('Grades');

$arGradesOrder = ['UF_GRADE_DATE' => 'ASC'];

$arGradesFilter = [
    'UF_GRADE_DATE' => $daysArray,
    'UF_GRADE_USER' => $GLOBALS['USER']->GetID(),
];

$arGradesSelect = [
    'ID',
    'UF_GRADE_DATE',
    'UF_GRADE_TEXT',
    'UF_GRADE_LESSON_NUMBER',
    'UF_GRADE_USER',
];

$arGrades = $gradesEntity::getList([
    'order' => $arGradesOrder,
    'filter' => $arGradesFilter,
    'select' => $arGradesSelect,
]);

while ($grade = $arGrades->fetch()) {
    $date = $grade['UF_GRADE_DATE']->toString();
    $lessonNumber = $grade['UF_GRADE_LESSON_NUMBER'];
    $arResult['SCHOOL_DAYS'][$date]["LESSON_$lessonNumber"]['GRADE'] = $grade['UF_GRADE_TEXT'];
}

$this->includeComponentTemplate();
