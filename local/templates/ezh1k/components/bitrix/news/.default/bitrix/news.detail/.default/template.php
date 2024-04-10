<?php
/**
 * @var array $arResult
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<section class="section">
    <div class="container">
        <header class="section-header mb-3">
            <h2 class="section-title text-sm-start text-center"><?= $arResult['NAME'] ?></h2>

            <div class="news-picture mb-3">
                <img
                    src="<?= $arResult['FIELDS']['PREVIEW_PICTURE']['SRC'] ?>"
                    alt="<?= $arResult['NAME'] ?>"
                    class="news-img"
                >
            </div>

            <div class="news-metadata">
                <div>
                    <strong>Дата публикации: <?= $arResult['TIMESTAMP_X'] ?></strong>
                </div>

                <div>
                    <strong>Автор: <?= $arResult['FIELDS']['CREATED_USER_NAME'] ?></strong>
                </div>
            </div>
        </header>

        <div class="section-content">
            <div class="news-content">
                <?= $arResult['DETAIL_TEXT'] ?>
            </div>
        </div>
    </div>
</section>
