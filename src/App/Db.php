<?php


namespace App;


use PDO;
use PDOException;
use RuntimeException;

class Db
{

    public static Db $instance;
    public PDO       $connection;

    /**
     * Db constructor.
     */
    public function __construct()
    {

        try {
            $this->connection = new PDO(
                'mysql:host='.DB_HOST.';dbname='.DB_NAME,
                DB_USER,
                DB_PASSWORD,
            );

        } catch (PDOException $e) {
            throw new RuntimeException(__CLASS__.$e->getMessage());
        }
    }

    /**
     * @return Db
     */
    public static function get(): Db
    {
        return self::$instance ?? self::$instance = new self();
    }

}