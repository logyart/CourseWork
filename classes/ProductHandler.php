<?php
class ProductHandler
{
    private static self $instance;
    private Core $core;
    // названия таблиц в БД
    private string $products = 'products';
    private string $categories = 'categories';
    private string $subcategories = 'subcategories';
    // Условия к sql-запросам, где fields - это поля таблицы, а values - их значения
    private array $conditions = [
        'fields' => [],
        'values' => []
    ];

    private function __construct(Core $core) {
        $this->core = $core;
    }
    // чтобы не приходилось создавать каждый раз новые экземпляры класса ProductHandler и не занимать память
    public static function getInstance(): self {
        if (empty(self::$instance)) {
            $core = Core::getInstance();
            self::$instance = new self($core);
        }
        return self::$instance;
    }

    public function getProducts(int $category_id, ?int $subcategory_id = null): array
    {
        $this->conditions['fields'] = [
            'category_id'
        ];
        $this->conditions['values'] = [
            $category_id
        ];

        if (!is_null($subcategory_id)) {
            $this->conditions['fields'][] = 'subcategory_id';
            $this->conditions['values'][] = $subcategory_id;
        }

        return $this->core->select($this->products, $this->conditions);
    }

    public function getCategories(): array
    {
        return $this->core->select($this->categories);
    }

    public function getSubcategories(int $category_id): array
    {
        $this->conditions['fields'] = [
            'category_id'
        ];
        $this->conditions['values'] = [
            $category_id
        ];
        return $this->core->select($this->subcategories, $this->conditions);
    }
    public function addToBasket(array $product): void
    {

        $id = $product['id'];
        // поместить в core
        if (is_null($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        else if (array_key_exists($id, $_SESSION['basket'])) {
            $_SESSION['basket'][$id]['count']++;
            return;
        }
        //unset($product['id']);
        $_SESSION['basket'][$id] = $product;
        $_SESSION['basket'][$id]['count'] = 1;
    }

    public function deleteFromBasket(int $id, ?bool $full = false): void {
        if ($_SESSION['basket'][$id]['count'] == 1 || $full) {
            unset($_SESSION['basket'][$id]);
            return;
        }
        $_SESSION['basket'][$id]['count']--;
    }

    public function deleteBasket():void {
        unset($_SESSION['basket']);
    }

}
