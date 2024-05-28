<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = [
    'NAME' => 'Форма добавления оценки',
    'DESCRIPTION' => 'Форма для выставления оценки ученику',
    'COMPLEX' => 'N',
    'PATH' => [
        'ID' => 'content',
        'CHILD' => [
            'ID' => 'grades',
            'NAME' => 'Оценки',
        ],
    ],
];
