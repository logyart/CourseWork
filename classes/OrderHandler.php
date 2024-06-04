<?php
class OrderHandler
{
    private static self $instance;
    private Core $core;

    // названия таблиц в БД
    private string $products = 'products';
    private string $orders = 'orders';
    private string $order_items = 'order_items';

    // Условия к sql-запросам, где fields - это поля таблицы, а values - их значения
    private array $conditions = [
        'fields' => [],
        'values' => []
    ];

    private function __construct(Core $core) {
        $this->core = $core;
    }
    // чтобы не приходилось создавать каждый раз новые экземпляры класса OrderHandler и не занимать память
    public static function getInstance():self {
        if (empty(self::$instance)) {
            $core = Core::getInstance();
            self::$instance = new self($core);
        }
        return self::$instance;
    }

    public function getOrder(int $id):array {
        // в массиве select ключ - название таблицы, а значение - массив полей, которые нужны из этой таблицы
        $select = [
            $this->orders => ['id', 'user_id', 'payment', 'total_amount', 'created'],
            $this->order_items => ['count'],
            $this->products => ['id', 'title', 'price', 'img_path']
        ];

        // название основной таблицы, откуда будет select, join будет к этой же таблице
        $fromTable = $this->order_items;

        // ключ название таблицы, а занчение массив, в котором ключ поле таблицы, а значение поле исходной таблицы
        $join = [
            $this->orders  => [
                'id' => 'order_id'
            ],
            $this->products => [
                'id' => 'product_id'
            ]
        ];

        // в массиве conditions['fields'] ключ - название таблицы, а значение - поле таблицы
        $this->conditions['fields'] = [
            $this->orders => 'id'
        ];
        // значения для указанных выше полей таблицы
        $this->conditions['values'] = [
            $id
        ];
        return $this->core->join($select, $fromTable, $join, $this->conditions);
    }

    public function getOrders(int $user_id):array {
        if ($user_id == 0)
            return $this->core->select($this->orders);

        $this->conditions['fields'] = [
            'user_id'
        ];
        $this->conditions['values'] = [
            $user_id
        ];

        return $this->core->select($this->orders, $this->conditions);
    }

    public function getOrderById(int $order_id): array {
        $this->conditions['fields'] = [
            'id'
        ];
        $this->conditions['values'] = [
            $order_id
        ];
        // селект возвращает массив нескольких строк (массивов) из таблицы,
        // а в данном случае у нас всегда будет массив из одной строки
        return $this->core->select($this->orders, $this->conditions)[0];
    }

    public function getOrderItems(int $order_id):array {
        // в массиве select ключ - название таблицы, а значение - массив полей, которые нужны из этой таблицы
        $select = [
            $this->order_items => ['count'],
            $this->products => ['id', 'title', 'price', 'img_path']
        ];

        // название основной таблицы, откуда будет select, join будет к этой же таблице
        $fromTable = $this->order_items;

        // ключ название таблицы, а занчение массив, в котором ключ поле таблицы, а значение поле исходной таблицы
        $join = [
            $this->products => [
                'id' => 'product_id'
            ]
        ];

        // в массиве conditions['fields'] ключ - название таблицы, а значение - поле таблицы
        $this->conditions['fields'] = [
            $this->order_items => 'order_id'
        ];
        // значения для указанных выше полей таблицы
        $this->conditions['values'] = [
            $order_id
        ];
        return $this->core->join($select, $fromTable, $join, $this->conditions);
    }
    public function getOrdersByUserId(int $user_id):array
    {
        // в массиве select ключ - название таблицы, а значение - массив полей, которые нужны из этой таблицы
        $select = [
            $this->orders => ['id', 'user_id', 'payment', 'total_amount', 'created'],
            $this->order_items => ['count'],
            $this->products => ['id', 'title', 'price', 'img_path']
        ];

        // название основной таблицы, откуда будет select, join будет к этой же таблице
        $fromTable = $this->order_items;

        // ключ название таблицы, а занчение массив, в котором ключ поле таблицы, а значение поле исходной таблицы
        $join = [
            $this->orders => [
                'id' => 'order_id'
            ],
            $this->products => [
                'id' => 'product_id'
            ]
        ];

        // в массиве conditions['fields'] ключ - название таблицы, а значение - поле таблицы
        $this->conditions['fields'] = [
            $this->orders => 'user_id'
        ];
        // значения для указанных выше полей таблицы
        $this->conditions['values'] = [
            $user_id
        ];
        return $this->core->join($select, $fromTable, $join, $this->conditions);
    }


    private function makeFullAddress(array $addressData):string {
        $address = "ул. " . $addressData['street']
            . ", д. " . $addressData['house'];

        if (!empty($addressData['entrance']))
            $address .= ", под. " . $addressData['entrance'];

        if (!empty($addressData['flat']))
            $address .= ", кв. " . $addressData['flat'];
        return $address;
    }

    public function makeOrder(int $user_id, int $total_amount, string $payment, string $comment, array $addressData, array $basket):void {
        $address = $this->makeFullAddress($addressData);

        $this->conditions['fields'] = [
            'user_id',
            'total_amount',
            'payment',
            'comment',
            'address'
        ];
        $this->conditions['values'] = [
            $user_id,
            $total_amount,
            $payment,
            $comment,
            $address
        ];
        $order_id = $this->core->insert($this->orders, $this->conditions);

        $this->fillOrder($basket, $order_id);
    }

    private function fillOrder(array $products, int $order_id):void {
        $this->conditions['fields'] = [
            'order_id',
            'product_id',
            'count',
        ];

        foreach ($products as $product) {
            $this->conditions['values'] = [
                $order_id,
                $product['id'],
                $product['count'],
            ];
            $this->core->insert($this->order_items, $this->conditions);
        }
    }

}
