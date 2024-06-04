<?php
session_start();
define('PATH', '/' . basename($_SERVER['DOCUMENT_ROOT']));
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/AdminHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/ProductHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/OrderHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/UserHandler.php';
mysqli_report(MYSQLI_REPORT_ERROR);

Class Core {
    private static self $instance;
    private DbConnection $connection;

    private function __construct(DbConnection $connection)
    {
        $this->connection = $connection;
    }

    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            $connection = require_once $_SERVER['DOCUMENT_ROOT'] . '/classes' . '/DbConnection.php';
            self::$instance = new self($connection);
        }
        return self::$instance;
    }
    private function executeQuery(string $query, ?array $values = null): bool|mysqli_result
    {
        $mysqliConnection = $this->connection->getConnection();
        if (is_null($values))
            return $mysqliConnection->execute_query($query);
        return $mysqliConnection->execute_query($query, $values);
    }

    public function select(string $tableName, ?array $conditions = null):array
    {
        $query = "SELECT * FROM $tableName";

        // если нет условий для select
        if (is_null($conditions)) {
            $result = $this->executeQuery($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // приводим к виду WHERE category_id = ? AND subcategory_id = ?
        foreach ($conditions['fields'] as &$field)
            $field .= " = ?"; // к каждому элементу приписываем = ?
        $where = implode(" AND ", $conditions['fields']); // преобразование в строку с разделителем AND

        $result = $this->executeQuery($query . " WHERE " . $where, $conditions['values']);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insert(string $tableName, array $conditions):int {
        $questions = array_fill(0, count($conditions['fields']), '?');
        $fields = implode(", ", $conditions['fields']);
        $values = implode(", ", $questions);

        $query = "INSERT INTO $tableName ($fields) VALUES ($values)";
        $this->executeQuery($query, $conditions['values']);
        return $this->connection->getConnection()->insert_id;
    }

    public function update(string $tableName, array $conditions, int $id):void {

        // приводим к виду UPDATE table SET title = ? WHERE id = ?
        foreach ($conditions['fields'] as &$field)
            $field .= " = ?"; // к каждому элементу приписываем = ?

        // преобразование в строку с разделителем ,
        $fields = implode(", ", $conditions['fields']);

        $conditions['values'][] = $id;

        $query = "UPDATE $tableName SET $fields WHERE id = ?";
        $this->executeQuery($query, $conditions['values']);
    }

    public function delete(string $tableName, int $id):void
    {
        $query = "DELETE FROM $tableName WHERE id = ?";
        $this->executeQuery($query, [$id]);
    }

    public function join(array $select, string $fromTable, array $join, ?array $conditions = null):array
    {
        // приводим к виду
        // SELECT table1.field1, table2.field1, table3.field2 FROM table1
        $selectFields = [];
        foreach ($select as $tableName => $fields)
            foreach ($fields as $field)
                $selectFields[] = "$tableName.$field";
        $selects = implode(', ', $selectFields);

        $query = "SELECT $selects FROM $fromTable ";


        foreach ($join as $tableName => $fields) {
            // приводим к виду
            // JOIN tableName ON tableName.field1 = fromTable.field2 AND tableName.field3 = fromTable.field4
            $on = [];
            foreach ($fields as $field1 => $field2)
                $on[] = "$tableName.$field1 = $fromTable.$field2";
            $joins = implode(" AND ", $on);
            $query .= "JOIN $tableName ON $joins ";
        }

        if (is_null($conditions)) {
            $result = $this->executeQuery($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // приводим к виду WHERE table.id = ? AND table.type_id = ?
        foreach ($conditions['fields'] as $tableName => &$field)
            $field = "$tableName.$field = ?"; // к каждому элементу приписываем = ?

        // преобразование в строку с разделителем AND
        $where = implode(" AND ", $conditions['fields']);

        $result = $this->executeQuery("$query WHERE $where", $conditions['values']);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getArrayByID(array $array):array {
        $ids = array_column($array, 'id');
        unset($array['id']);
        $values = array_values($array);
        return array_combine($ids, $array);
    }
    public function createDb():void {
        $query = `
            CREATE DATABASE IF NOT EXISTS chepizzadb;

            use chepizzadb;

            DROP TABLE IF EXISTS categories;

            CREATE TABLE IF NOT EXISTS categories
            (
                id INT PRIMARY KEY AUTO_INCREMENT,
                title_ru VARCHAR(20) NOT NULL UNIQUE,
                title_en VARCHAR(20) NOT NULL UNIQUE
            );

            DROP TABLE IF EXISTS subcategories;

            CREATE TABLE IF NOT EXISTS subcategories
            (
                id INT PRIMARY KEY AUTO_INCREMENT,
                category_id INT NOT NULL,
                title VARCHAR(30) NOT NULL
            );

            DROP TABLE IF EXISTS products;

            CREATE TABLE IF NOT EXISTS products
            (
                id INT PRIMARY KEY AUTO_INCREMENT,
                category_id INT NOT NULL,
                title VARCHAR(30) NOT NULL,
                subcategory_id INT,
                description TEXT,
                price SMALLINT UNSIGNED NOT NULL,
                img_path VARCHAR(150),
                CONSTRAINT product_category_id FOREIGN KEY (category_id) REFERENCES categories (id),
                CONSTRAINT product_subcategories_id FOREIGN KEY (subcategory_id) REFERENCES subcategories (id)
            );

            DROP TABLE IF EXISTS users;

            CREATE TABLE IF NOT EXISTS users
            (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(100) NOT NULL,
                phone varchar(30) UNIQUE NOT NULL,
                login varchar(30) UNIQUE NOT NULL,
                password VARCHAR(250) NOT NULL,
                address VARCHAR(250)
            );

            CREATE TABLE IF NOT EXISTS orders
            (
                id INT PRIMARY KEY AUTO_INCREMENT,
                user_id INT NOT NULL,
                total_amount MEDIUMINT UNSIGNED NOT NULL,
                payment ENUM("cash", "card"),
                comment TEXT,
                address VARCHAR(250),
                created TIMESTAMP DEFAULT now(),
                CONSTRAINT orders_user_id FOREIGN KEY (user_id) REFERENCES users (id)
            );

            CREATE TABLE IF NOT EXISTS order_items
            (
                order_id INT,
                product_id INT NOT NULL,
                count SMALLINT UNSIGNED NOT NULL,
                CONSTRAINT order_items_order_id FOREIGN KEY (order_id) REFERENCES orders (id),
                CONSTRAINT order_items_product_id FOREIGN KEY (product_id) REFERENCES products (id)
            );
        `;

        $this->executeQuery($query);
    }
    public function dropDb():void {
         $query = "DROP DATABASE IF EXISTS chepizzadb";
         $this->executeQuery($query);
    }



}