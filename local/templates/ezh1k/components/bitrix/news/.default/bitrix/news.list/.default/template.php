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
            <h2 class="section-title text-sm-start text-center">Школьные новости</h2>
        </header>

        <div class="section-content row row-gap-4">
            <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                <div class="news-item col-xl-3 col-md-4 col-sm-6 col-12">
                    <header class="news-item-header mb-1 text-sm-start text-center">
                        <div>
                            <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                                <img
                                    src="<?= $arItem['RESIZED_PICTURE']['src'] ?>"
                                    alt="<?= $arItem['NAME'] ?>"
                                    class="news-image shadow"
                                >
                            </a>
                        </div>

                        <h3 class="news-title mb-0">
                            <a
                                class="text-decoration-none"
                                href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                            ><?= $arItem['NAME'] ?></a>
                        </h3>

                        <div class="news-metadata">
                            <div>Дата публикации: <?= $arItem['TIMESTAMP_X'] ?></div>
                            <div>Автор: <?= $arItem['FIELDS']['CREATED_USER_NAME'] ?></div>
                        </div>
                    </header>

                    <hr>

                    <div class="news-item-content text-sm-start text-center">
                        <div><?= $arItem['PREVIEW_TEXT'] ?></div>

                        <div class="text-center mt-3">
                            <a
                                href="<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                class="btn btn-primary shadow"
                            >Читать далее</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
