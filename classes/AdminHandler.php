<?php

class AdminHandler
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

    public function addProduct(int $category_id, string $title, int $subcategory_id, string $description, string $img_path, int $price): void
    {
        $this->conditions['fields'] = [
            'category_id',
            'title',
            'subcategory_id',
            'description',
            'img_path',
            'price',
        ];
        $this->conditions['values'] = [
            $category_id,
            $title,
            $subcategory_id,
            $description,
            $img_path,
            $price
        ];

        $this->core->insert($this->products, $this->conditions);
    }

    public function deleteProduct(int $product_id):void
    {
        $this->core->delete($this->products, $product_id);
    }

    public function editProduct(int $product_id, int $category_id, string $title, int $subcategory_id, string $description, string $img_path, int $price): void
    {
        $this->conditions['fields'] = [
            'category_id',
            'title',
            'subcategory_id',
            'description',
            'img_path',
            'price'
        ];
        $this->conditions['values'] = [
            $category_id,
            $title,
            $subcategory_id,
            $description,
            $img_path,
            $price
        ];

        $this->core->update($this->products, $this->conditions, $product_id);
    }

    public function addCategories(string $title_ru, string $title_en, array $subcategories):void {
        $this->conditions['fields'] = [
            'title_ru',
            'title_en',
        ];
        $this->conditions['values'] = [
            $title_ru,
            $title_en
        ];

        $category_id = $this->core->insert($this->categories, $this->conditions);

        foreach ($subcategories as $subcategory)
            $this->addSubcategories($category_id, $subcategory);
    }

    private function addSubcategories(int $category_id, $title):void {
        $this->conditions['fields'] = [
            'category_id',
            'title',
        ];
        $this->conditions['values'] = [
            $category_id,
            $title
        ];
        $this->core->insert($this->subcategories, $this->conditions);

    }

    public function editCategory(int $category_id, string $title_ru, string $title_en, array $subcategories):void {
        $this->conditions['fields'] = [
            'title_ru',
            'title_en',
        ];
        $this->conditions['values'] = [
            $title_ru,
            $title_en
        ];

        $this->core->update($this->categories, $this->conditions, $category_id);

        foreach ($subcategories as $subcategory_id => $subcategory)
            $this->editSubcategory($subcategory_id, $subcategory);
    }

    private function editSubcategory(int $subcategory_id, string $title):void {
        $this->conditions['fields'] = [
            'title',
        ];
        $this->conditions['values'] = [
            $title
        ];
        $this->core->update($this->subcategories, $this->conditions, $subcategory_id);
    }

    public function deleteCategory($category_id):void {
        $this->core->delete($this->categories, $category_id);
    }
}