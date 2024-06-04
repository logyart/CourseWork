<?php include_once 'header.php';?>

<?php //unset($_SESSION['basket']);?>
<main>
<?php if (empty($_SESSION['basket'])):?>
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="row message align-items-center text-center">
                    <span class="fs-2 text-nowrap">
                        <?php if (empty($_SESSION['isOrderCompleted']))
                            echo 'Корзина пуста :(';
                        else {
                            echo 'Спасибо за заказ!';
                            unset($_SESSION['isOrderCompleted']);
                        }?>
                    </span>
                </div>
            </div>
        </div>
    </section>
<?php else:?>

    <section class="container" style="height: 100vh;">
        <div class="row h-100">
            <div class="col-12 col-lg-4 px-sm-2 px-0">
                <nav class="navbar navbar-expand-lg">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup1" aria-controls="navbarNavAltMarkup1" aria-expanded="false" aria-label="Toggle navigation">
                        <span>Заказы</span>
                        <img src="assets/img/icons/delivery-black.svg" height="55">
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup1">
                        <form action="<?=PATH . '/forms/makeOrder.php'?>" method="post">
                            <div class="container">
                                <div class="row row-cols-3 align-items-center">
                                    <div class="col-12 mb-3">
                                        <label for="street" class="form-label">Улица</label>
                                        <input type="text" class="form-control" id="street" name="delivery[street]" required value="<?= (!empty($_SESSION['USER'])) ? $_SESSION['USER']['street'] : '';?>">
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="house" class="form-label">Дом</label>
                                        <input type="text" class="form-control" id="house" name="delivery[house]" required value="<?= (!empty($_SESSION['USER'])) ? $_SESSION['USER']['house'] : '';?>">
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="flat" class="form-label">Квартира</label>
                                        <input type="number" class="form-control" id="flat" name="delivery[flat]" value="<?= (!empty($_SESSION['USER'])) ? $_SESSION['USER']['flat'] : '';?>">
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="entrance" class="form-label">Подъезд</label>
                                        <input type="number" class="form-control" id="entrance" name="delivery[entrance]" value="<?= (!empty($_SESSION['USER'])) ? $_SESSION['USER']['entrance'] : '';?>">
                                    </div>
                                    <div class="col-12 ">
                                        <div class="mb-3">Способ оплаты</div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="delivery[payment]" id="payment" value="card" required>
                                            <label class="form-check-label" for="payment">Картой</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="delivery[payment]" id="payment" value="cash">
                                            <label class="form-check-label" for="payment">Наличными</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="comment">Комментарий:</label>
                                        <textarea class="form-control" rows="3" id="comment" name="delivery[comment]"></textarea>
                                    </div>
                                    <div class="col-8">
                                        <?php
                                        $totalSum = 0;
                                        foreach ($_SESSION['basket'] as $product) {
                                            $totalSum += $product['price'] * $product['count'];
                                        }?>
                                        <span class="basket-price fs-5">Итого: <?=$totalSum;?> ₽</span>
                                    </div>
                                    <?php if ($totalSum < 699):?>
                                        <div class="col-12">
                                            <span>Добавьте в корзину что-нибудь ещё на <?=699 - $totalSum?> ₽</span>
                                        </div>
                                    <?php else:?>
                                        <div class="col-4" >
                                            <button type="submit" class="btn basket-order ms-auto" name="delivery[order]">Заказать</button>
                                        </div>
                                    <?php endif?>

                                    <div class="col">
                                        <input type="hidden" name="delivery[user_id]" value="<?= (!empty($_SESSION['USER'])) ? $_SESSION['USER']['id'] : ''?>">
                                        <input type="hidden" name="delivery[total_amount]" value="<?=$totalSum?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>

            <div class="col h-100 overflow-auto">
                <div class="row row-cols-1 justify-content-center">
                    <div class="col-6 ms-auto">
                        <form action="<?=PATH . '/forms/deleteFromBasket.php'?>" method="post">
                            <input type="hidden" name="delete_flag" value="<?='ALL';?>">
                            <button type="submit" class="btn basket-order " name="basket[delete]">Очистить корзину</button>
                        </form>
                    </div>

                    <?php foreach ($_SESSION['basket'] as $product):?>
                        <div class="basket-item col-12  p-4">
                            <div class="row">
                                <!-- Кнопка удаления -->
                                <div class="col-3 ms-auto">
                                    <form action="<?=PATH . '/forms/deleteFromBasket.php'?>" method="post">
                                        <input type="hidden" name="delete_id" value="<?=$product['id'];?>">
                                        <input type="hidden" name="delete_flag" value="<?='FULL';?>">
                                        <button type="submit" class="btn" style="float: right" name="basket[delete]">❌</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row row-cols-2 food-item">
                                <div class="col-5 col-xl-3">
                                    <img src="<?=$product['img_path'];?>">
                                </div>
                                <div class="col-7 col-xl-9">
                                    <span class="row food-name fs-4"><?=$product['title'];?></span>
                                    <p class="row food-description fs-6 text-secondary fw-light"><?=$product['description'];?></p>
                                    <div class="row row-cols-2 align-items-center justify-content-between food-bottom">
                                        <div class="col food-price fs-4 p-0"><?=$product['price'];?> ₽</div>
                                        <div class="col-6 col-md-4 col-xl-3 text-end">
                                            <div class="row row-cols-3 align-items-center basket-count">
                                                <form action="<?=PATH . '/forms/deleteFromBasket.php'?>" method="post">
                                                    <input type="hidden" name="delete_id" value="<?=$product['id']?>">
                                                    <input type="hidden" name="delete_flag" value="<?='ONE';?>">
                                                    <button class="col btn fs-5 px-2" style="float: right; color:white" type="submit" name="basket[delete]">-</button>
                                                </form>
                                                <span class="col text-center" style="color: white"><?=$product['count'];?></span>
                                                <form action="<?=PATH . '/forms/addToBasket.php'?>" method="post">
                                                    <input type="hidden" name="product" value="<?=http_build_query($product)?>">
                                                    <input type="hidden" name="page" value="<?=basename($_SERVER['REQUEST_URI'])?>">
                                                    <button class="col btn fs-5 px-2" style="float: right;color:white;" type="submit" name="basket[add]">+</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach?>
                </div>
            </div>
        </div>
    </section>
<?php endif;?>
</main>

<?php include_once 'footer.php';?>