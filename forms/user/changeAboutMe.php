<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['changeAboutMe'])) {

    try {
        $user = UserHandler::getInstance();
        $user->editUser(
            $_SESSION['USER']['id'],
            ['name', 'phone'],
            [trim($_POST['name']), $_POST['phone']]
        );

        header('Location: ' . PATH . '/' . $_POST['page']);
        exit();
    } catch (\Exception $e) {
        die($e->getMessage());
    }
}