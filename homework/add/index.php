<?php
/**
 * @var CMain $APPLICATION
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->setTitle('Добавление домашнего задания');
?>

<?php
$APPLICATION->includeComponent(
    'ezh1k:homework.add',
    '.default',
    []
);
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>
