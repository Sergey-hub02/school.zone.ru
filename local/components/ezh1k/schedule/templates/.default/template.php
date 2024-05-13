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
                <?php foreach ($arResult['SCHOOL_DAYS'] as $date => $schoolDay): ?>
                    <div class="col-xl-5 col-md-6 col-12">
                        <div class="card mb-3 school-day-card">
                            <header class="card-header">
                                <h6 class="card-title"><?= $schoolDay['NAME'] ?>, <?= $date ?></h6>
                            </header>

                            <div class="card-body pt-0">
                                <?php for ($i = 1; $i <= 8; ++$i): ?>
                                    <div class="row py-2 align-items-center border-bottom">
                                        <div class="col-5"><?= $schoolDay['LESSON_' . $i]['NAME'] ?></div>
                                        <div class="col-2"><?= $schoolDay['LESSON_' . $i]['GRADE'] ?></div>
                                        <div class="col-5"><?= $schoolDay['LESSON_' . $i]['HOMEWORK'] ?></div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
