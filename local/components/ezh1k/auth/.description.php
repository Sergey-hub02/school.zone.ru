<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = [
    'NAME' => 'Форма авторизации',
    'DESCRIPTION' => 'Форма для авторизации пользователя',
    'COMPLEX' => 'N',
    'PATH' => [
        'ID' => 'service',
        'CHILD' => [
            'ID' => 'auth_registration',
            'NAME' => 'Авторизация и регистрация',
            'CHILD' => [
                'ID' => 'authentication',
                'NAME' => 'Форма авторизации',
            ],
        ],
    ],
];
