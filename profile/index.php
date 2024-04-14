<?php
/**
 * @var CMain $APPLICATION
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->SetTitle('Личный кабинет');
?>

<?php
$APPLICATION->includeComponent(
    'ezh1k:profile',
    '.default',
    []
);
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>
