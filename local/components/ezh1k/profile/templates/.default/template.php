<?php
/**
 * @var array $arResult
 * @var string $templateFolder
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<section class="section">
    <div class="container">
        <header class="section-header">
            <h2 class="section-title text-sm-start text-center">Личный кабинет</h2>
        </header>

        <div class="section-content">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="card profile-card text-center">
                        <div class="card-header">
                            <img
                                src="<?= $templateFolder ?>/images/profile_icon.svg"
                                alt="Profile icon"
                                class="profile-picture"
                            >
                        </div>

                        <div class="card-body">
                            <h6 class="card-title mb-0"><?= $arResult['USER']['FULL_NAME'] ?></h6>
                            <h6 class="card-title"><?= $arResult['USER']['LOGIN'] ?> (<?= $arResult['USER']['EMAIL']?>)</h6>

                            <div>Возраст: <?= $arResult['USER']['AGE'] ?> (<?= $arResult['USER']['PERSONAL_BIRTHDAY'] ?>)</div>
                            <div>Дата регистрации: <?= $arResult['USER']['DATE_REGISTER']->format('d.m.Y') ?></div>
                            <div>Последний вход: <?= $arResult['USER']['LAST_LOGIN'] ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-12 mt-lg-0 mt-3">
                    <form name="profile_form" method="post">
                        <h3 class="mb-3">Данные учащегося</h3>

                        <?= bitrix_sessid_post() ?>

                        <h5 class="form-section-title mb-2">Личные данные</h5>

                        <div class="form-group mb-3">
                            <label for="full_name" class="mb-1"><strong>ФИО</strong></label>

                            <input
                                id="full_name"
                                name="full_name"
                                type="text"
                                class="form-control"
                                value="<?= $arResult['USER']['FULL_NAME'] ?>"
                                readonly
                            >
                        </div>

                        <div class="form-group mb-3">
                            <label for="login" class="mb-1"><strong>Логин</strong></label>

                            <input
                                id="login"
                                name="login"
                                type="text"
                                class="form-control"
                                value="<?= $arResult['USER']['LOGIN'] ?>"
                                readonly
                            >
                        </div>

                        <div class="form-group mb-3">
                            <label for="gender" class="mb-1"><strong>Пол</strong></label>

                            <input
                                id="gender"
                                name="gender"
                                type="text"
                                class="form-control"
                                value="<?= $arResult['USER']['PERSONAL_GENDER'] ?>"
                                readonly
                            >
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="mb-1"><strong>Адрес электронной почты</strong></label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="form-control"
                                value="<?= $arResult['USER']['EMAIL'] ?>"
                            >
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone" class="mb-1"><strong>Номер телефона</strong></label>

                            <input
                                id="phone"
                                name="phone"
                                type="text"
                                class="form-control"
                                value="<?= $arResult['USER']['PERSONAL_PHONE'] ?>"
                            >
                        </div>

                        <h5 class="form-section-title mb-2">Учебные данные</h5>

                        <div class="form-group mb-3">
                            <label for="enrollment_year" class="mb-1"><strong>Год приёма</strong></label>

                            <input
                                id="enrollment_year"
                                name="enrollment_year"
                                type="text"
                                class="form-control"
                                value="<?= $arResult['STUDENT']['STUDENT_ENROLLMENT_YEAR_VALUE'] ?>"
                                readonly
                            >
                        </div>

                        <div class="form-group mb-3">
                            <label for="school_name" class="mb-1"><strong>Школа</strong></label>

                            <input
                                id="school_name"
                                name="school_name"
                                type="text"
                                class="form-control"
                                value="<?= $arResult['STUDENT']['IBLOCK_ELEMENTS_ELEMENT_STUDENTS_STUDENT_SCHOOL_ELEMENT_NAME'] ?>"
                                readonly
                            >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
