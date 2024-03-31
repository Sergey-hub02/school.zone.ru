<?php
/**
 * @var array $arResult
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<button
    class="navbar-toggler custom-toggler"
    type="button"
    data-bs-toggle="collapse"
    data-bs-target="#top-mobile-menu"
    aria-controls="top-mobile-menu"
    aria-expanded="false"
    arial-label="Toggle navigation"
>
    <span class="navbar-toggler-icon"></span>
</button>

<div id="top-mobile-menu" class="navbar-collapse collapse">
    <ul class="navbar-nav">
        <?php foreach ($arResult as $arMenuItem): ?>
            <li class="nav-item">
                <a href="<?= $arMenuItem['LINK'] ?>" class="nav-link">
                    <?= $arMenuItem['TEXT'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
