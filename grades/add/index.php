<?php
/**
 * @var CMain $APPLICATION
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->setTitle('Добавление оценки');
?>

<?php
$APPLICATION->includeComponent(
    'ezh1k:grade.add',
    '.default',
    []
);
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
?>
