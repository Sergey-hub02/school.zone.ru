<?php
/**
 * @var CMain $APPLICATION
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php'
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Школьный портал">
    <meta name="title" content="School Zone">
    <meta name="author" content="Пак Сергей Андреевич (s.park190802@gmail.com)">

    <title>Авторизация</title>
    <?php $APPLICATION->ShowHead() ?>
    <link rel="stylesheet" href="/auth/css/style.css">
</head>


<body>

<?php
$APPLICATION->includeComponent(
    'ezh1k:auth',
    '.default',
    []
);
?>

</body>

</html>
