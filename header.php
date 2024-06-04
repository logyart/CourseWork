<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' .'/Core.php';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Marmelad&display=swap" rel="stylesheet">
    <link href="assets/css/base.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <link rel="icon" href="assets/img/logo/ChePizzaWhite.svg" type="image/svg+xml">
    <title>ChePizza</title>
</head>
<body>
<header class="sticky-top"><!---->
    <nav class="navbar navbar-expand-lg navbar-white bg-white">
        <div class="container">
            <a class="navbar-brand" href="<?=PATH . '/index.php'?>">
                <img src="assets/img/logo/ChePizzaWhite.svg" alt="" width="80" height="80" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="col-12 col-lg-9 ms-auto">
                    <div class="row row-cols-3">
                        <div class="col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2">
                            <img src="assets/img/icons/delivery-black.svg" height="70">
                        </div>

                        <div class="col-4">
                            <span class="delivery-time fs-6">Доставка от 30 минут!</span><br>
                            <span class="work-schedule fs-6">с 10:00 до 22:00</span>
                        </div>

                        <div class="col-4 col-sm-3 col-md-2 col-lg-3 col-xl-2 btn-group dropstart ms-auto align-self-center">
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <a href="<?=PATH . '/profile.php'?>" class="btn" type="button">
                                <img src="assets/img/icons/user.svg" height="55">
                            </a>

                            <ul class="dropdown-menu dropdown-menu-lg-end">
                                <?php if (empty($_SESSION['USER'])):?>
                                    <li><a class="dropdown-item" href="#authModal" data-bs-toggle="modal" data-bs-target="#authModal">Войти</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#signUpModal" data-bs-toggle="modal" data-bs-target="#signUpModal">Зарегистрироваться</a></li>
                                <?php else:?>
                                    <li><a class="dropdown-item" href="<?=PATH . '/orders.php'?>"><?= (strtolower($_SESSION['USER']['login']) === 'admin') ? "Все заказы"  : "Мои заказы"?></a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="<?=PATH . '/forms/logout.php'?>" method="post">
                                            <input type="hidden" name="logout[page]" value="<?=basename($_SERVER['REQUEST_URI'])?>">
                                            <button type="submit" class="dropdown-item" name="logout[button]">Выйти</button>
                                        </form>
                                    </li>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
<!--</header>

<header class="sticky-top">-->
    <nav class="navbar navbar-expand-lg navbar-white bg-white">
        <div class="container">

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav align-items-center col-12">
                    <?php
                    $productHandler = ProductHandler::getInstance();
                    $categories = $productHandler->getCategories();
                    foreach ($categories as $category):?>
                        <a class="nav-link fs-5" href="<?=PATH . '/index.php#' . $category['title_en'];?>"><?=$category['title_ru'];?></a>
                    <?php endforeach;?>
                    <!--<a class="nav-link fs-4" aria-current="page" href="#pizzas">Пиццы</a>
                    <a class="nav-link fs-4" href="#snacks">Закуски</a>
                    <a class="nav-link fs-4" href="#drinks">Напитки</a>-->
                    <a class="nav-link fs-5" href="<?=PATH . '/index.php#top'?>">Акции</a>
                    <a class="nav-link fs-5" href="#footer">Контакты</a>
                    <a href="<?=PATH . '/basket.php'?>" class="btn ms-auto">
                        <img src="assets/img/icons/Basket.svg" width="40" height="40">
                    </a>
                </div>

            </div>
        </div>
    </nav>

</header>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/modals/authModal.php'?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/modals/signUpModal.php'?>



