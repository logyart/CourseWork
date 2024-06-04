<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['delivery']['order'])) {
    if (!isset($_POST['delivery']['user_id'])) {
        die("для заказа необходимо авторизоваться");
    }

    $user_id = $_POST['delivery']['user_id'];
    $total_amount = $_POST['delivery']['total_amount'];
    $payment = $_POST['delivery']['payment'];
    $comment = $_POST['delivery']['comment'];

    $address = [
        'street' => trim($_POST['delivery']['street']),
        'house' => trim($_POST['delivery']['house']),
        'entrance' => trim($_POST['delivery']['entrance']),
        'flat' => trim($_POST['delivery']['flat']),
    ];

    try {
        $orderHandler = OrderHandler::getInstance();
        $orderHandler->makeOrder($user_id, $total_amount, $payment, $comment, $address, $_SESSION['basket']);
        unset($_SESSION['basket']);
        $_SESSION['isOrderCompleted'] = true;
        header('Location: ' . PATH . '/basket.php');
        exit();
    } catch(Exception $e) {
        echo $e->getMessage();
    }

}