<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['auth'])) {
    try {
        $user = UserHandler::getInstance();
        $user->tryToAuth(
            trim($_POST['login']),
            $_POST['password'],
        );
        header('Location: ' . PATH . '/' . $_POST['page']);
        exit();
    } catch (\Exception $e) {
        die($e->getMessage());
    }
}
