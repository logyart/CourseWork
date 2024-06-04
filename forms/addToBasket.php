<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['basket']['add'])) {
    try {
        parse_str($_POST['product'], $product);
        $productHandler = ProductHandler::getInstance();
        $productHandler->addToBasket($product);

        $page = $_POST['page'];
        if ($page == 'index.php')
            $page .= '#product' . $product['id'];

        header('Location: ' . PATH . '/' . $page);
        exit();
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}