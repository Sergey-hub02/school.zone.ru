<?php
/**
 * @var array $arResult
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<div class="container">
    <form method="post" class="row">
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
                    <div>Вы успешно поставили оценку!</div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-6">
            <div class="form-group mb-3">
                <label for="grade-date" class="form-label">
                    <strong>Дата</strong>
                </label>

                <input
                    id="grade-date"
                    name="grade_date"
                    type="date"
                    class="form-control"
                    value="<?= $_REQUEST['grade_date'] ?>"
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
        </div>

        <div class="col-6">
            <div class="form-group mb-3">
                <label for="student" class="form-label">
                    <strong>Учащийся</strong>
                </label>

                <select name="student" id="student" class="form-control">
                    <option value="">Выберите учащегося</option>

                    <?php foreach ($arResult['STUDENTS'] as $student): ?>
                        <option
                            value="<?= $student['ID'] ?>"
                            <?= $_REQUEST['student'] != $student['ID'] ?: 'selected' ?>
                        ><?= $student['FIO'] ?> (<?= $student['CLASS'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="grade" class="form-label">
                    <strong>Оценка</strong>
                </label>

                <select name="grade" id="grade" class="form-control">
                    <option value="">Выберите оценку</option>

                    <?php for ($i = 1; $i <= 5; ++$i): ?>
                        <option
                            value="<?= $i ?>"
                            <?= $_REQUEST['grade'] != $i ?: 'selected' ?>
                        ><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>

        <div class="col-12">
            <button
                id="add-grade"
                name="add_grade"
                type="submit"
                class="btn btn-primary"
            >Поставить оценку</button>
        </div>
    </form>
</div>
