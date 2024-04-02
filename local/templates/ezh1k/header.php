<?php
/**
 * @var CMain $APPLICATION
 */
use Bitrix\Main\Page\Asset;
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Школьный портал">
    <meta name="title" content="School Zone">
    <meta name="author" content="Пак Сергей Андреевич (s.park190802@gmail.com)">

    <title><?php $APPLICATION->ShowTitle() ?></title>
    <?php $APPLICATION->ShowHead() ?>

    <?php Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/libs/bootstrap-5.3.3/css/bootstrap.min.css') ?>
    <?php Asset::getInstance()->addJS(SITE_TEMPLATE_PATH . '/libs/bootstrap-5.3.3/js/bootstrap.min.js') ?>
    <?php Asset::getInstance()->addJS(SITE_TEMPLATE_PATH . '/libs/jquery/jquery-3.7.1.min.js') ?>
</head>


<body>

<?php $APPLICATION->ShowPanel() ?>

<header class="header">
    <nav class="navbar navbar-expand-md">
        <div class="container">
            <div class="navbar-brand d-flex align-items-center">
                <a href="http://school.zone.ru">
                    <img
                        src="<?= SITE_TEMPLATE_PATH ?>/images/school_zone_icon.png"
                        alt="School Zone"
                        class="d-inline-block align-text-top header-image"
                    >
                </a>

                <div class="ps-3 site-title-box">
                    <h1>
                        <a class="text-decoration-none site-title" href="http://school.zone.ru">School Zone</a>
                    </h1>
                </div>
            </div>

            <div id="navbar-menu" class="flex-grow-0 d-md-block d-none">
                <div class="navbar-nav">
                    <div class="auth-buttons shadow py-2 px-3">
                        <a class="auth-button auth-avatar text-decoration-none" href="/profile/">
                            <img
                                class="auth-avatar-icon"
                                src="<?= SITE_TEMPLATE_PATH ?>/images/icons/person-circle.svg"
                                alt="Профиль"
                            >
                            <?= $GLOBALS['USER']->GetFullName() ?>
                        </a>
                        <a class="auth-button auth-logout text-decoration-none" href="/logout/">Выход</a>
                    </div>
                </div>
            </div>

            <?php
            $APPLICATION->IncludeComponent(
                'bitrix:menu',
                'top_mobile',
                [
                    'ROOT_MENU_TYPE' => 'top',
                    'MENU_CACHE_TYPE' => 'N',
                    'MENU_CACHE_TIME' => 36000,
                    'MENU_CACHE_USE_GROUPS' => 'Y',
                    'MENU_CACHE_GET_VARS' => '',
                    'MAX_LEVEL' => 2,
                    'USE_EXT' => 'N',
                    'DELAY' => 'N',
                    'ALLOW_MULTI_SELECT' => 'N',
                ]
            );
            ?>
        </div>
    </nav>

    <?php
    $APPLICATION->IncludeComponent(
        'bitrix:menu',
        'top',
        [
            'ROOT_MENU_TYPE' => 'top',
            'MENU_CACHE_TYPE' => 'N',
            'MENU_CACHE_TIME' => 36000,
            'MENU_CACHE_USE_GROUPS' => 'Y',
            'MENU_CACHE_GET_VARS' => '',
            'MAX_LEVEL' => 2,
            'USE_EXT' => 'N',
            'DELAY' => 'N',
            'ALLOW_MULTI_SELECT' => 'N',
        ]
    );
    ?>
</header>

<main class="py-4">
