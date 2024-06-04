<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['changePassword'])) {

    $user = UserHandler::getInstance();
    $user->tryToAuth(
        $_SESSION['USER']['login'],
        $_POST['old_password'],
    );

    if ($_POST['old_password'] == $_POST['password']) {
        die("Старый и новый пароль совпадают.");
    }

    if ($_POST['password'] !== $_POST['password_repeat']) {
        die("Введённые пароли не совпадают.");
    }

    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {

        $user->editUser(
            $_SESSION['USER']['id'],
            ['password'],
            [$hashedPassword],
        );

        header('Location: ' . PATH . '/' . $_POST['page']);
        exit();
    } catch (\Exception $e) {
        die($e->getMessage());
    }
}