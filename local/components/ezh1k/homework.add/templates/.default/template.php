<?php
/**
 * @var array $arResult
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<div class="container">
    <form method="post" class="row" enctype="multipart/form-data">
        <?= bitrix_sessid_post() ?>

        <?php if ($arResult['SUCCESS'] !== 'Y' && !empty($arResult['ERRORS'])): ?>
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($arResult['ERRORS'] as $error): ?>
                        <div><?= $error ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php elseif ($arResult['SUCCESS'] === 'Y'): ?>
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <div>Вы успешно добавили домашнее задание!</div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-6">
            <div class="form-group mb-3">
                <label for="homework-date" class="form-label">
                    <strong>Дата</strong>
                </label>

                <input
                    id="homework-date"
                    name="homework_date"
                    type="date"
                    class="form-control"
                    value="<?= $_REQUEST['homework_date'] ?>"
                >
            </div>

            <div class="form-group mb-3">
                <label for="subject" class="form-label">
                    <strong>Дисциплина</strong>
                </label>

                <select name="subject" id="subject" class="form-control">
                    <option value="">Выберите дисциплину</option>

                    <?php foreach ($arResult['SUBJECTS'] as $subject): ?>
                        <option
                            value="<?= $subject['ID'] ?>"
                            <?= $_REQUEST['subject'] != $subject['ID'] ?: 'selected' ?>
                        ><?= $subject['NAME'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <button
                    id="add-homework"
                    name="add_homework"
                    type="submit"
                    class="btn btn-primary"
                >Добавить</button>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group mb-3">
                <label for="class" class="form-label">
                    <strong>Класс</strong>
                </label>

                <select name="class" id="class" class="form-control">
                    <option value="">Выберите класс</option>

                    <?php foreach ($arResult['CLASSES'] as $class): ?>
                        <option
                            value="<?= $class['ID'] ?>"
                            <?= $_REQUEST['class'] != $class['ID'] ?: 'selected' ?>
                        ><?= $class['NAME'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="homework" class="form-label">
                    <strong>Домашнее задание</strong>
                </label>

                <input
                    id="homework"
                    name="homework"
                    type="text"
                    class="form-control"
                    value="<?= $_REQUEST['homework'] ?>"
                >
            </div>

            <div class="form-group mb-3">
                <label for="attachment" class="form-label">
                    <strong>Вложение</strong>
                </label>

                <input
                    id="attachment"
                    name="attachment"
                    type="file"
                    class="form-control"
                >
            </div>
        </div>
    </form>
</div>
