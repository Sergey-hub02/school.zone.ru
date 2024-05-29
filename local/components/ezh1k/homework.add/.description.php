<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = [
    'NAME' => 'Добавление домашнего задания',
    'DESCRIPTION' => 'Форма для добавления домашнего задания',
    'COMPLEX' => 'N',
    'PATH' => [
        'ID' => 'content',
        'CHILD' => [
            'ID' => 'homework',
            'NAME' => 'Домашнее задание',
        ],
    ],
];
