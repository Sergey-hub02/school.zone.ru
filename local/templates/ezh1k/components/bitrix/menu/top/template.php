<?php
/**
 * @var array $arResult
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<!-- <pre> -->
    <?php // print_r($arResult) ?>
<!-- </pre> -->

<div class="menu shadow d-md-block d-none">
    <div class="container">
        <nav class="menu-navbar row">
            <?php foreach ($arResult as $arMenuItem): ?>
                <div class="menu-navbar-item d-flex justify-content-center align-items-center text-center col-2 py-3 px-4 <?= $arMenuItem['SELECTED'] ? 'active' : '' ?>">
                    <a href="<?= $arMenuItem['LINK'] ?>" class="navbar-item-link text-decoration-none">
                        <?= $arMenuItem['TEXT'] ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </nav>
    </div>
</div>
