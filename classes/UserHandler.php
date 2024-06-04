<?php
//session_start();

class UserHandler {
    private static self $instance;
    private Core $core;
    private string $users = 'users';
    private string $orders = 'orders';
    // Условия к sql-запросам, где fields - это поля таблицы, а values - их значения
    private array $conditions = [
        'fields' => [],
        'values' => []
    ];

    private function __construct(Core $core) {
        $this->core = $core;
    }

    public static function getInstance():self {
        if (empty(self::$instance)) {
            $core = Core::getInstance();
            self::$instance = new self($core);
        }
        return self::$instance;
    }

    public function createUser(string $name, string $phone, string $login, string $password):bool {
        $this->conditions['fields'] = ['phone'];
        $this->conditions['values'] = [$phone];
        if (!empty($this->core->select($this->users, $this->conditions)))
            die("Пользователь с таким номером телефона уже существует.");

        $this->conditions['fields'] = ['login'];
        $this->conditions['values'] = [$login];
        if (!empty($this->core->select($this->users, $this->conditions)))
            die("Данный логин занят. Попробуйте ввести другой.");

        return $this->addUser($name, $phone, $login, $password);
    }
    private function addUser(string $name, string $phone, string $login, string $password):bool {
        $this->conditions['fields'] = [
            'name',
            'phone',
            'login',
            'password',
        ];
        $this->conditions['values'] = [
            $name,
            $phone,
            $login,
            $password,
        ];
        return $this->core->insert($this->users, $this->conditions);
    }

    public function editUser(int $id, array $fieldNames, array $values):void {
        $this->conditions['fields'] = $fieldNames;
        $this->conditions['values'] = $values;
        $this->core->update($this->users, $this->conditions, $id);

        foreach ($fieldNames as $key => $fieldName)
            $_SESSION['USER'][$fieldName] = $values[$key];
    }


    public function tryToAuth(string $login, string $password):void {
        $this->conditions['fields'] = [
            'login'
        ];
        $this->conditions['values'] = [
            $login
        ];
        $result = $this->core->select($this->users, $this->conditions);
        // select возвращает массив массивов, поэтому берем первый (и единственный) элемент
        $user = array_shift($result);

        if (empty($user)) {
            die("Пользователь с таким логином не найден.");
        }

        if (!password_verify($password, $user['password'])) {
            die("Неверно введён пароль.");
        }

        $this->authorize($user);
    }

    private function authorize(array $user):void {
        $_SESSION['USER'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'phone' => $user['phone'],
            'login' => $user['login'],
            'password' => $user['password'],
            'street' => empty($user['street']) ? '' : $user['street'],
            'house' => empty($user['house']) ? '' : $user['house'],
            'entrance' => empty($user['entrance']) ? '' : $user['entrance'],
            'flat' => empty($user['flat']) ? '' : $user['flat'],
        ];
        /*
        $_SESSION['USER']['street'] = empty($user['street']) ? '' : $user['street'];
        $_SESSION['USER']['house'] = empty($user['house']) ? '' : $user['house'];
        $_SESSION['USER']['entrance'] = empty($user['entrance']) ? '' : $user['entrance'];
        $_SESSION['USER']['flat'] = empty($user['flat']) ? '' : $user['flat'];*/
    }
}

$userRegisterHandler = UserHandler::getInstance();