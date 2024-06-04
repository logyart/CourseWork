<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
class DbConnection {
    private const DB_HOST = 'localhost';
    private const DB_LOGIN = 'root';
    private const DB_PASSWORD = 'b3zR_ab0t_zabot';
    private const DB_NAME = 'chepizzadb';
    private mysqli|false $connection;
    public function __construct() {
    }

    public function connect():void {
        $this->connection = mysqli_connect(
            self::DB_HOST,
            self::DB_LOGIN,
            self::DB_PASSWORD,
            self::DB_NAME
        );
    }

    public function getConnection():mysqli {
        return $this->connection;
    }
}

$connection = new DbConnection;
$connection->connect();
return $connection;