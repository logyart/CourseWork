<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="authModalLabel">Войти</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>

            <div class="modal-body">
                <form action="<?=PATH . '/forms/auth.php'?>" method="post">
                    <div class="mb-3 mt-3">
                        <label for="auth_login" class="form-label">Логин:</label>
                        <input type="text" class="form-control" id="auth_login" placeholder="Введите логин" name="login">
                        <input type="hidden" name="page" value="<?=basename($_SERVER['REQUEST_URI'])?>">
                    </div>
                    <div class="mb-3">
                        <label for="auth_pwd" class="form-label">Пароль:</label>
                        <input type="password" class="form-control" id="auth_pwd" placeholder="Введите пароль" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary" name="auth">Войти</button>
                </form>
            </div>
        </div>
    </div>
</div>
