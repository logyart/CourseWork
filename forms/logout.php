<?php
session_start();
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

if (isset($_POST['logout']['button'])) {
    unset($_SESSION['USER']);
    unset($_SESSION['cart']);
    header('Location: ' . PATH . '/' . $_POST['logout']['page']);
    exit();
}
