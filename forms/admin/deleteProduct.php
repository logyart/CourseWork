<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['delete']['id'])) {
    try {
        $adminHandler = AdminHandler::getInstance();
        $adminHandler->deleteProduct(
            $_POST['delete']['id']
        );

        header('Location: ' . PATH . '/index.php' . '#' . $_POST['delete']['category_en']);
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

}