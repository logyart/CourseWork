<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['basket']['delete'])) {
    try {
        $productHandler = ProductHandler::getInstance();

        switch ($_POST['delete_flag']) {
            case "ONE":
                $productHandler->deleteFromBasket($_POST['delete_id']);
                break;
            case "FULL":
                $productHandler->deleteFromBasket($_POST['delete_id'], true);
                break;
            case "ALL":
                $productHandler->deleteBasket();
                break;
        }

        header('Location: ' . PATH . '/basket.php');
        exit();
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
