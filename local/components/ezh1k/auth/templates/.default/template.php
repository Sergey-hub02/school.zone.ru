<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<div class="auth-box">
    <form name="auth_form" method="post" class="auth-form">
        <header class="auth-form-header">
            <div class="auth-form-image-box">
                <img
                    class="auth-form-image"
                    src="/local/templates/ezh1k/images/school_zone_icon.png"
                    alt="School Zone"
                >
            </div>

            <h1 class="auth-form-title">Авторизация</h1>
        </header>

        <?php if (!empty($arResult['SUCCESS']) && $arResult['SUCCESS'] !== 'Y'): ?>
            <div class="alert-danger">
                <?php foreach ($arResult['ERRORS'] as $error): ?>
                    <div><?= $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?= bitrix_sessid_post() ?>

        <div class="auth-form-field">
            <input
                id="login"
                name="login"
                type="text"
                class="auth-form-element"
                placeholder="Логин"
                value="<?= $_REQUEST['login'] ?>"
            >
        </div>

        <div class="auth-form-field">
            <input
                id="password"
                name="password"
                type="password"
                class="auth-form-element"
                placeholder="Пароль"
            >
        </div>

        <div class="auth-form-field">
            <a class="auth-form-link" href="./?register">Перейти к регистрации</a>
        </div>

        <div class="auth-form-field text-center">
            <button
                id="do_login"
                name="do_login"
                type="submit"
                class="auth-form-btn"
            >Войти</button>
        </div>
    </form>
</div>
