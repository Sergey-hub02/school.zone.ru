<?php
/**
 * @var array $arResult
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<section class="section">
    <div class="container">
        <header class="section-header">
            <h2 class="section-title text-sm-start text-center">Расписание</h2>
        </header>

        <div class="section-content">
            <div class="row justify-content-between">
                <div class="col-xxl-4 col-xl-5 col-md-6 col-12">
                    <?php foreach ($arResult['SCHOOL_DAYS'] as $index => $schoolDay): ?>
                        <?php if ($index > 2) break ?>

                        <div class="card mb-3 school-day-card">
                            <header class="card-header">
                                <h6 class="card-title"><?= $schoolDay['NAME'] ?>, <?= $schoolDay['DATE'] ?></h6>
                            </header>

                            <div class="card-body pt-0">
                                <?php for ($i = 1; $i <= 8; ++$i): ?>
                                    <div class="row py-2 border-bottom">
                                        <div class="col-5"><?= $schoolDay['LESSON_' . $i] ?></div>
                                        <div class="col-2">&nbsp;</div>
                                        <div class="col-5">&nbsp;</div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="col-xxl-4 col-xl-5 col-md-6 col-12">
                    <?php foreach ($arResult['SCHOOL_DAYS'] as $index => $schoolDay): ?>
                        <?php if ($index <= 2) continue ?>

                        <div class="card mb-3 school-day-card">
                            <header class="card-header">
                                <h6 class="card-title"><?= $schoolDay['NAME'] ?>, <?= $schoolDay['DATE'] ?></h6>
                            </header>

                            <div class="card-body pt-0">
                                <?php for ($i = 1; $i <= 8; ++$i): ?>
                                    <div class="row py-2 border-bottom">
                                        <div class="col-5"><?= $schoolDay['LESSON_' . $i] ?></div>
                                        <div class="col-2">&nbsp;</div>
                                        <div class="col-5">&nbsp;</div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
