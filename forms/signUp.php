<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['signUp'])) {

    if ($_POST['password'] !== $_POST['password_repeat']) {
        die("Введённые пароли не совпадают.");
    }

    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $user = UserHandler::getInstance();
        $user->createUser(
            trim($_POST['name']),
            $_POST['phone'],
            trim($_POST['login']),
            $hashedPassword,
        );

        header('Location: ' . PATH . '/' . $_POST['page']);
        exit();
    } catch (\Exception $e) {
        die($e->getMessage());
    }
}