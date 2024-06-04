<?php include_once 'header.php';?>
    <main>
        <section class="container">
            <?php if (empty($_SESSION['USER'])):?>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="row message align-items-center text-center">
                            <span class="fs-2">Авторизуйтесь, чтобы увидеть свои заказы</span>
                        </div>
                    </div>
                </div>
            <?php else:?>
                <?php
                $orderHandler = OrderHandler::getInstance();

                $user_id = (strtolower($_SESSION['USER']['login']) === 'admin') ? 0 : $_SESSION['USER']['id'];
                $orders = $orderHandler->getOrders($user_id);

                if (empty($orders)):?>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="row message align-items-center text-center">
                                <span class="fs-2 text-nowrap">У вас пока нет заказов</span>
                            </div>
                        </div>
                    </div>
                <?php else:
                    $order_id = $orders[0]['id'];
                    if (isset($_GET['id']))
                        $order_id = $_GET['id'];

                    $orderItems = $orderHandler->getOrderItems($order_id);

                    $order = $orderHandler->getOrderById($order_id);
                    ?>
                    <div class="row row-cols-2 justify-content-lg-center">
                        <div class="col-4 col-sm-3 col-lg-3" style="position: relative;">
                            <div class="d-flex flex-column mb-3" style="height: 100%">
                                <div class="navbar-nav p-2">
                                    <?php foreach ($orders as $order):?>
                                        <a class="nav-link fs-5" href="?id=<?=$order['id']?>">Заказ <?=DateTime::createFromFormat ( "Y-m-d H:i:s", $order['created'])->format('d.m.Y, H:i')?></a>
                                    <?php endforeach?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-lg-6">
                            <?php $order = $orderHandler->getOrderById($order_id);?>
                            <div class="row row-cols-3 justify-content-between">
                                <?php if (strtolower($_SESSION['USER']['login']) === 'admin'):?>
                                    <div class="col">ID клиента:  <?=$order['user_id']?></div>
                                <?php endif?>
                                <div class="col .text-secondary">№ <?=$order_id?></div>
                                <div class="col text-end text-nowrap"><?=DateTime::createFromFormat ( "Y-m-d H:i:s", $order['created'])->format('d.m.Y, H:i')?></div>
                            </div>
                            <hr class="hr" />
                            <div class="row row-cols-2 justify-content-between">
                                <div class="col-auto text-secondary">Доставка </div>
                                <div class="col-auto"><?=$order['address']?></div>
                            </div>
                            <hr class="hr" />
                            <div class="row row-cols-2 justify-content-between">
                                <div class="col text-secondary">Сумма </div>
                                <div class="col text-end food-price"><?=$order['total_amount']?> ₽</div>
                            </div>
                            <hr class="hr" />
                            <?php foreach ($orderItems as $product):?>
                                <div class="basket-item col-12  p-4">
                                    <div class="row row-cols-2 food-item">
                                        <div class="col-5 col-xl-3">
                                            <img src="<?=$product['img_path'];?>">
                                        </div>
                                        <div class="col-7 col-xl-9">
                                            <span class="row food-name fs-4"><?=$product['title'];?></span>
                                            <div class="row row-cols-2 align-items-center justify-content-between food-bottom">
                                                <div class="col-8 food-price fs-4 p-0"><?=$product['price'];?> ₽</div>
                                                <div class="col-4 basket-count text-center">
                                                    <span class="" style="color: white"><?=$product['count'];?> шт.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach?>
                        </div>
                    </div>
                <?php endif?>
            <?php endif?>
        </section>
    </main>
<?php include_once 'footer.php';?>