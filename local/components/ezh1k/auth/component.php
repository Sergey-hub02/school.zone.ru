<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (isset($_REQUEST['do_login']) && check_bitrix_sessid()) {
    $login = trim($_REQUEST['login']);
    $password = trim($_REQUEST['password']);

    $errors = [];

    if (empty($login)) {
        $errors[] = 'Не заполнено поле "Логин"!';
    }
    if (empty($password)) {
        $errors[] = 'Не заполнено поле "Пароль"!';
    }

    if (!empty($errors)) {
        $arResult['SUCCESS'] = 'N';
        $arResult['ERRORS'] = $errors;

        $this->includeComponentTemplate();
        return;
    }

    $user = new CUser;
    $authRes = $user->Login(
        $login,
        $password,
        'N',
        'Y'
    );

    if (!empty($authRes['TYPE']) && $authRes['TYPE'] === 'ERROR') {
        $arResult['SUCCESS'] = 'N';
        $arResult['ERRORS'] = [$authRes['MESSAGE']];

        $this->includeComponentTemplate();
        return;
    }

    LocalRedirect('/');
}

$this->includeComponentTemplate();
