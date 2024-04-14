<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = [
    'NAME' => 'Личный кабинет',
    'DESCRIPTION' => 'Отображает личные данные пользователя и позволяет их менять',
    'COMPLEX' => 'N',
    'PATH' => [
        'ID' => 'utility',
        'CHILD' => [
            'ID' => 'user',
            'NAME' => 'Пользователь',
            'CHILD' => [
                'ID' => 'profile',
                'NAME' => 'Личный кабинет',
            ],
        ]
    ],
];
