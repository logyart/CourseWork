<div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="signUpModalLabel">Регистрация</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>

            <div class="modal-body">
                <form action="<?=PATH . '/forms/signUp.php';?>" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя:</label>
                        <input type="text" class="form-control" id="name" placeholder="Введите имя" name="name" required>
                        <input type="hidden" name="page" value="<?=basename($_SERVER['REQUEST_URI'])?>">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Телефон:</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="+7 (999)-999-99-99" required>
                    </div>
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин:</label>
                        <input type="text" class="form-control" id="login" placeholder="Введите логин" name="login" required>
                    </div>
                    <div class="mb-3">
                        <label for="pwd" class="form-label">Пароль:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="Введите пароль" name="password" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label for="repeat_pwd" class="form-label">Повторите пароль:</label>
                        <input type="password" class="form-control" id="repeat_pwd" placeholder="Повторите пароль" name="password_repeat" required>
                    </div>
                    <div class="form-check mb-3">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" required>
                            Согласен с
                            <a href="<?=PATH . '/politic.php'?>" target="_blank" style="color: black">
                                политикой конфиденциальности
                            </a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary" name="signUp">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
</div>
