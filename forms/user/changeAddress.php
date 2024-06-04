<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['changeAddress'])) {

    try {
        $user = UserHandler::getInstance();
        $user->editUser(
            $_SESSION['USER']['id'],
            [
                'street',
                'house',
                'entrance',
                'flat'
            ],
            [
                trim($_POST['street']),
                trim($_POST['house']),
                empty($_POST['entrance']) ? NULL : $_POST['entrance'],
                empty($_POST['flat']) ? NULL : $_POST['flat'],
            ]
        );

    } catch (\Exception $e) {
        die($e->getMessage());
    }

    header('Location: ' . PATH . '/' . $_POST['page']);
    exit();
}