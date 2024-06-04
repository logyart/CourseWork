<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['product']['edit'])) {
    try {
        if ($_POST['product']['price'] < 0 || $_POST['product']['price'] > 65535)
            die('Цена должна быть в диапазоне от 0 до 65535 включительно.');

        $imgPath = $_POST['product']['old_path'];
        // если файл был загружен без ошибок
        if (!$_FILES['product']['error']) {
            $uploadFolder = '/assets/img/uploads/'; // имя папки
            $uploadName = basename($_FILES['product']['name']); // записываем имя файла
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . $uploadFolder . $uploadName; // куда грузить файл
            // перемещение загруженного файла из временной папки сервера в папку, которую указали (uploadPath)
            if (!move_uploaded_file($_FILES['product']['tmp_name'], $uploadPath))
                die('Файл не удалось загрузить из временной папки в $uploadsPath');
            $imgPath = PATH . $uploadFolder . $uploadName;
        }
        echo $imgPath;


        $adminHandler = AdminHandler::getInstance();
        $adminHandler->editProduct(
            $_POST['product']['id'],
            $_POST['product']['category_id'],
            trim($_POST['product']['title']),
            $_POST['product']['subcategory_id'],
            trim($_POST['product']['description']),
            $imgPath,
            $_POST['product']['price']
        );

        header('Location: ' . PATH . '/index.php' . '#' . $_POST['product']['category_en']);
        exit();
    } catch (Exception $e) {
        echo $e;
    }

}


