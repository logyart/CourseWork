<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['product']['add'])) {
    try {
        if ($_POST['product']['price'] < 0 || $_POST['product']['price'] > 65535)
            die('Цена должна быть в диапазоне от 0 до 65535 включительно.');

        $uploadFolder = '/assets/img/uploads/'; // имя папки
        $uploadName = basename($_FILES['product']['name']); // записываем имя файла
        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $uploadFolder . $uploadName; // куда грузить файл
        // перемещение загруженного файла из временной папки сервера в папку, которую указали (uploadPath)
        if (!move_uploaded_file($_FILES['product']['tmp_name'], $uploadPath))
            die("Файл не удалось загрузить из временной папки в $uploadName");

        $adminHandler = AdminHandler::getInstance();
        $adminHandler->addProduct(
            $_POST['product']['category_id'],
            trim($_POST['product']['title']),
            $_POST['product']['subcategory_id'],
            trim($_POST['product']['description']),
            PATH . $uploadFolder . $uploadName,
            $_POST['product']['price']
        );

        header('Location: ' . PATH . '/index.php' . '#' . $_POST['product']['category_en']);
        exit();
    } catch (Exception $e) {
        echo $e;
    }
}


