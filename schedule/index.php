<?php
/**
 * @var CMain $APPLICATION
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->SetTitle('Расписание');
?>

<?php
$APPLICATION->includeComponent(
    'ezh1k:schedule',
    '.default',
    []
);
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>
