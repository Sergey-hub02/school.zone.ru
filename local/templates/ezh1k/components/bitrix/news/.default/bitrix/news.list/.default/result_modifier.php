<?php
/**
 * @var array $arResult
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$resizedSize = [
    'width' => 350,
    'height' => 210,
];

foreach ($arResult['ITEMS'] as &$arItem) {
    $resizedImage = CFile::ResizeImageGet(
        $arItem['PREVIEW_PICTURE']['ID'],
        $resizedSize,
        BX_RESIZE_IMAGE_EXACT,
        true
    );

    $arItem['RESIZED_PICTURE'] = $resizedImage;
}
