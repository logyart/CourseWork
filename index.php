<?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php';
?>

<main>
    <div class="container">
        <section class="sales container" id="sales">
            <div class="row">
                <div id="carouselExampleDark" class="carousel carousel-dark slide ms-auto me-auto" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner row">
                        <div class="carousel-item active" data-bs-interval="10000">
                            <div class="row align-items-center sales-slide">
                                <div class="col-8">
                                    <div class="carousel-text">
                                        <span class="sales-title">Празднуй день рождения вместе с Che Pizza и получи скидку 25%!</span>
                                        <p class="sales-description">Скидкой можно воспользоваться за 3 дня до, во время дня рождения и 4 после него.</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <img src="assets/img/logo/ChePizzaGreen.svg" class="d-block w-100">
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item" data-bs-interval="2000">
                            <div class="row align-items-center sales-slide">
                                <div class="col-8">
                                    <div class="carousel-text">
                                        <span class="sales-title">При заказе 3 пицц получи 4 в подарок!</span>
                                        <p class="sales-description">Закажи на доставку 3 любых пиццы и получи маргариту в подарок!</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <img src="assets/img/menu/pepperoni.webp" class="d-block w-100">
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="row align-items-center sales-slide">
                                <div class="col-8">
                                    <div class="carousel-text">
                                        <span class="sales-title">Бесплатная доставка!</span>
                                        <p class="sales-description">Всегда при заказе даже на минимальную стоимость (699₽)</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <img src="assets/img/icons/delivery-white.svg" class="d-block w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        $productHandler = ProductHandler::getInstance();
        $categories = $productHandler->getCategories();
        $newCategoryID = count($categories) + 1?>

        <?php if (!empty($_SESSION['USER']) && strtolower($_SESSION['USER']['login']) === 'admin'):?>
            <!-- Кнопка-триггер модального окна добавления-->
            <section class="food container">
                <button type="button" class="btn row row-cols-2 align-items-center" data-bs-toggle="modal" data-bs-target="#addCategoryModal<?=$newCategoryID;?>">
                    <img class="col-auto" src="assets/img/icons/plus.svg" height="40vh">
                    <span class="col-auto fs-4">Добавить категорию</span>
                </button>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/modals/admin/addCategoryModal.php'?>
            </section>
        <?php endif?>

        <?php foreach ($categories as $category):
            $subcategories = $productHandler->getSubcategories($category['id']);?>

            <section class="food container" id="<?=$category['title_en'];?>">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="row align-items-center">
                            <div class="col-4 col-sm-5 col-md-7 col-lg-6">
                                <a href="<?=PATH . '/index.php' . '#' . $category['title_en']?>" style="text-decoration: none; color: black">
                                    <h2><?=$category['title_ru'];?></h2>
                                </a>
                            </div>
                            <div class="col">
                                <div class="row row-cols-2">
                                    <?php
                                    foreach ($subcategories as $subcategory):?>
                                        <div class="col text-center">
                                            <a href="<?=PATH . '/index.php?subcategory=' . $subcategory['id'] . '#' . $category['title_en']?>" class="btn food-category fs-4 text-nowrap"><?=$subcategory['title']?></a>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-6 pt-4">
                    <?php if (!empty($_SESSION['USER']) && strtolower($_SESSION['USER']['login']) === 'admin'):?>
                        <!-- Кнопка-триггер модального окна добавления-->
                        <div class="col p-4">
                            <div class="row">
                                <br>
                            </div>
                            <div class="row row-cols-2 row-cols-md-1 align-items-center">
                                <button type="button" class="btn col" data-bs-toggle="modal" data-bs-target="#addProductModal<?=$category['id'];?>">
                                    <img src="assets/img/icons/plus.svg" width="100%" height="100%">
                                </button>
                                <span class="col text-center fs-4">Добавить товар</span>
                                <?php require $_SERVER['DOCUMENT_ROOT'] . '/modals/admin/addProductModal.php'?>
                            </div>
                        </div>
                    <?php endif?>
                    <?php
                    $products = $productHandler->getProducts($category['id']);
                    if (isset($_GET['subcategory'])) {
                        if (in_array($_GET['subcategory'], array_column($subcategories, 'id'))) {
                            $products = $productHandler->getProducts($category['id'], $_GET['subcategory']);
                        }
                    }

                    foreach ($products as $product):?>
                        <div class="col p-4" id="product<?=$product['id']?>" style="position: relative">
                            <?php if (!empty($_SESSION['USER']) && strtolower($_SESSION['USER']['login']) === 'admin'):?>
                                <div class="row row-cols-2 justify-content-between">
                                    <!-- Кнопка-триггер модального окна редактирования -->
                                    <div class="col-3">
                                        <button type="button" class="btn col" data-bs-toggle="modal" data-bs-target="#editProductModal<?=$product['id'];?>">
                                            <img src="assets/img/icons/pencil-fill.svg" style="transform: scale(-1, 1)">
                                        </button>
                                        <?php require $_SERVER['DOCUMENT_ROOT'] . '/modals/admin/editProductModal.php'?>
                                    </div>


                                    <!-- Кнопка удаления -->
                                    <div class="col-3">
                                        <form action="<?=PATH . '/forms/admin/deleteProduct.php'?>" method="post">
                                            <input type="hidden" name="delete[id]" value="<?=$product['id'];?>">
                                            <input type="hidden" name="delete[category_en]" value="<?=$category['title_en'];?>">
                                            <button type="submit" class="btn" style="float: right">❌</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endif;?>

                            <div class="row row-cols-2 row-cols-md-1 mb-3" style="height: 100%">
                                <div class="col-5">
                                    <img src="<?=$product['img_path'];?>">
                                </div>
                                <div class="col-7 d-flex flex-column justify-content-between">
                                    <div class="mb-auto">
                                        <span class="food-name fs-4"><?=$product['title'];?></span>
                                        <p class="food-description fs-6 text-secondary"><?=$product['description'];?></p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="food-price fs-4 p-0"><?=$product['price'];?> ₽</div>
                                        <form action="<?=PATH . '/forms/addToBasket.php'?>" method="post">
                                            <input type="hidden" name="product" value="<?=http_build_query($product)?>">
                                            <input type="hidden" name="page" value="<?=basename($_SERVER['REQUEST_URI'])?>">
                                            <button class="btn food-basket fs-5 px-2 text-nowrap"  type="submit" name="basket[add]">В корзину</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach?>
                </div>
            </section>
        <?php endforeach;?>
    </div>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/footer.php'?>


тут правильаня версия
<div class="col p-4" id="product<?=$product['id']?>">
    <?php if (!empty($_SESSION['USER']) && strtolower($_SESSION['USER']['login']) === 'admin'):?>
        <div class="row row-cols-2 justify-content-between">
            <!-- Кнопка-триггер модального окна редактирования -->
            <div class="col-3">
                <button type="button" class="btn col" data-bs-toggle="modal" data-bs-target="#editProductModal<?=$product['id'];?>">
                    <img src="assets/img/icons/pencil-fill.svg" style="transform: scale(-1, 1)">
                </button>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/modals/admin/editProductModal.php'?>
            </div>


            <!-- Кнопка удаления -->
            <div class="col-3">
                <form action="<?=PATH . '/forms/admin/deleteProduct.php'?>" method="post">
                    <input type="hidden" name="delete[id]" value="<?=$product['id'];?>">
                    <input type="hidden" name="delete[category_en]" value="<?=$category['title_en'];?>">
                    <button type="submit" class="btn" style="float: right">❌</button>
                </form>
            </div>
        </div>
    <?php endif;?>

    <div class="row row-cols-2 row-cols-md-1 food-item">
        <div class="col-5">
            <img src="<?=$product['img_path'];?>">
        </div>
        <div class="col-7">
            <span class="row food-name fs-4"><?=$product['title'];?></span>
            <p class="row food-description fs-6 text-secondary fw-light"><?=$product['description'];?></p>
            <div class="row row-cols-2 align-items-center justify-content-between food-bottom">
                <div class="col food-price fs-4 p-0"><?=$product['price'];?> ₽</div>
                <form action="<?=PATH . '/forms/addToBasket.php'?>" method="post">
                    <input type="hidden" name="product" value="<?=http_build_query($product)?>">
                    <input type="hidden" name="page" value="<?=basename($_SERVER['REQUEST_URI'])?>">
                    <button class="col btn food-basket fs-5 px-2 text-nowrap"  type="submit" name="basket[add]">В корзину</button>
                </form>
            </div>
        </div>
    </div>
</div>
