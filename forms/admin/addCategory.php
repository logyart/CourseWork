<?php
// для константы PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/Core.php';

function makeFirstLetterUpper(string $string):string {
    $char = mb_strtoupper(substr($string,0,2), "utf-8"); // это первый символ
    // русские буквы занимают по 2 байта, т.е. 2 символа
    $string[0] = $char[0];
    $string[1] = $char[1];
    return $string;
}

if (isset($_POST['category']['add'])) {
    try {
        $title_ru = makeFirstLetterUpper(mb_strtolower(trim($_POST['category']['title_ru'])));
        $title_en = mb_strtolower(trim($_POST['category']['title_en']));

        $subcategories = [];
        foreach ($_POST['subcategories'] as $subcategory) {
            if (!empty($subcategory))
                $subcategories[] = makeFirstLetterUpper(mb_strtolower(trim($subcategory)));
        }

        $adminHandler = AdminHandler::getInstance();
        $adminHandler->addCategories(
            $title_ru,
            $title_en,
            $subcategories,
        );

        header('Location: ' . PATH . '/index.php' . '#' . $title_en);
        exit();
    } catch (Exception $e) {
        echo $e;
    }
}


