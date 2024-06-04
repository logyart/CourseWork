<?php include_once 'header.php';?>
<main>
    <section class="container">
        <?php if (empty($_SESSION['USER'])):?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="row message align-items-center text-center">
                        <span class="fs-2">Войдите в аккаунт, чтобы увидеть свой профиль</span>
                    </div>
                </div>
            </div>

        <?php else:?>
            <div class="row row-cols-2 justify-content-lg-center">
                <div class="col-4 col-sm-3 col-lg-2" style="position: relative;">
                    <div class="d-flex flex-column mb-3" style="height: 100%">
                        <div class="navbar-nav p-2 mb-auto">
                            <a class="nav-link fs-5" href="?aboutme">Обо мне</a>
                            <a class="nav-link fs-5" href="?address">Адрес</a>
                            <a class="nav-link fs-5" href="?password">Пароль</a>
                        </div>
                        <div class="navbar-nav p-2">
                            <form action="<?=PATH . '/forms/logout.php'?>" method="post">
                                <input type="hidden" name="logout[page]" value="<?=basename($_SERVER['REQUEST_URI'])?>">
                                <button type="submit" class="nav-link" name="logout[button]" style="color: red">Выйти</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8 col-sm-9 col-lg-5">
                    <?php switch(basename($_SERVER['REQUEST_URI'])):
                        case 'profile.php?address':?>
                            <form action="<?=PATH . '/forms/user/changeAddress.php'?>" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="userName" class="form-label">Улица</label>
                                    <input type="text" class="form-control" id="userName" name="street" value="<?=$_SESSION['USER']['street']?>">
                                </div>

                                <div class="mb-3">
                                    <label for="house" class="form-label">Дом:</label>
                                    <input type="text" class="form-control" id="house" name="house" value="<?=$_SESSION['USER']['house']?>" maxlength="10">
                                </div>

                                <div class="mb-3">
                                    <label for="flat" class="form-label">Квартира:</label>
                                    <input type="number" class="form-control" id="flat" name="flat" value="<?=$_SESSION['USER']['flat']?>">
                                </div>

                                <div class="mb-3">
                                    <label for="entrance" class="form-label">Подъезд:</label>
                                    <input type="number" class="form-control" id="entrance" name="entrance" value="<?=$_SESSION['USER']['entrance']?>">
                                    <input type="hidden"  name="page" value="<?=basename($_SERVER['REQUEST_URI'])?>">
                                </div>

                                <button type="submit" class="btn btn-success col-12" name="changeAddress">Сохранить</button>
                            </form>
                            <?php break;

                        case 'profile.php?password':?>
                            <form action="<?=PATH . '/forms/user/changePassword.php'?>" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="old_pwd" class="form-label">Старый пароль:</label>
                                    <input type="password" class="form-control" id="old_pwd" placeholder="Введите пароль" name="old_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_pwd" class="form-label">Новый пароль:</label>
                                    <input type="password" class="form-control" id="new_pwd" placeholder="Введите пароль" name="password" required minlength="6">
                                </div>
                                <div class="mb-3">
                                    <label for="repeat_pwd" class="form-label">Повторите пароль:</label>
                                    <input type="password" class="form-control" id="repeat_pwd" placeholder="Повторите пароль" name="password_repeat" required>
                                    <input type="hidden"  name="page" value="<?=basename($_SERVER['REQUEST_URI'])?>">
                                </div>
                                <button type="submit" class="btn btn-success col-12" name="changePassword">Сохранить</button>
                            </form>
                            <?php break;

                        default:?>
                            <form action="<?=PATH . '/forms/user/changeAboutMe.php'?>" method="post" enctype="multipart/form-data">
                                <div class="mb-3 row row-cols-2">
                                    <div class="col">
                                        <label for="userName" class="form-label">Имя</label>
                                        <input type="text" class="form-control" id="userName" name="name" value="<?=$_SESSION['USER']['name'];?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Телефон:</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="+7 (999)-999-99-99" value="<?=$_SESSION['USER']['phone'];?>">
                                    <input type="hidden"  name="page" value="<?=basename($_SERVER['REQUEST_URI'])?>">
                                </div>

                                <button type="submit" class="btn btn-success col-12" name="changeAboutMe">Сохранить</button>
                            </form>
                            <?php break;

                    endswitch;?>
                </div>
            </div>

            <?php
            echo 'текущий пользователь<br>';
            if (!empty($_SESSION['USER'])) {
                echo "<pre>";
                print_r($_SESSION['USER']);
                echo "</pre>";
            }

            echo '<br>все пользователи<br>';
            $core = Core::getInstance();
            echo "<pre>";
            print_r($core->select('users'));
            echo "</pre>";

            ?>
        <?php endif?>
    </section>

</main>
<?php include_once 'footer.php';?>
