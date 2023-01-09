<?php 

abstract class Database
{

    private static ?PDO $pdo = null;

    public static function getDatabase()
    {
        if (!self::$pdo) {
            $config = [
                "host" => "localhost",
                "port" => 3306,
                "username" => "root",
                "password" => "root",
                "engine" => "mysql"
            ];

            self::$pdo = new PDO(sprintf(
                "%s:host=%s:%s",
                $config["engine"],
                $config["host"],
                $config["port"]
            ), $config["username"], $config["password"], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ]);
        }
        return self::$pdo;
    }

    public static function createDatabaseIfNotExists(string $database)
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("CREATE DATABASE IF NOT EXISTS %s", $database));
        $stmt->execute();

        self::use($database);
    }

    public static function dropDatabase(string $database)
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("DROP DATABASE %s", $database));
        $stmt->execute();
    }

    public static function doesDatabaseExist(string $database): bool
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare("SHOW DATABASES");
        $stmt->execute();
        $databases = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($databases as $row) {
            if ($row["Database"] == $database) {
                return true;
            }
        }
        return false;
    }

    public static function use(string $database)
    {
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare(sprintf("USE %s", $database));
        $stmt->execute();
    }

    public static function createTable(Table $table)
    {
        $pdo = self::getDatabase();
        $sql = sprintf("CREATE TABLE %s (", $table->name);
        foreach ($table->columns as $column) {
            $sql .= sprintf("%s %s %s, ", $column->name, $column->type, $column->extras);
        }
        $sql .= sprintf(" PRIMARY KEY(%s)", $table->primaryKey);
        $sql .= ")";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function createTables(array $tables)
    {
        foreach ($tables as $table) {
            self::createTable($table);
        }
    }

    public static function migrate(string $database, array $tables)
    {
        self::createDatabaseIfNotExists($database);
        self::createTables($tables);
    }

    public static function bulkInsert(string $table, array $columns, array $data)
    {
        $pdo = self::getDatabase();
        $sql = sprintf("INSERT INTO %s ", $table);
        $sql .= "(" . implode(', ', $columns) . ") VALUES ";
        foreach($data as $row)
        {
            $sql .= "(" . implode(', ', array_fill(0, count($row), "?")) . "), ";
        }
        $sql = rtrim($sql, ", ");
        $pdo = self::getDatabase();
        $stmt = $pdo->prepare($sql);

        $i = 1;
        foreach($data as $row)
        {
            foreach($row as $value) {
                $stmt->bindValue($i++, $value);
            }
        }
        $stmt->execute();
        return true;
    }

    public static function createSqlsProcedures()
    {
        try{

        }catch(Exception $e){
            $e->getMessage();

        }

        $pdo = self::getDatabase();
        $stmt = $pdo->prepare("CREATE PROCEDURE CREATE_USER(IN name VARCHAR(255))
        BEGIN
            INSERT INTO users (username) VALUES (name);
        END");
        $stmt->execute();
        $date = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("CREATE PROCEDURE CREATE_TAMAGOCHI(IN name VARCHAR(255),IN id VARCHAR(255))
        BEGIN
            INSERT INTO tamagotchi (name,faim,soif,ennui,sommeil,living,level,user_id,created_at,last_update) 
            VALUES (name,70,70,70,70,1,1,id,'$date','$date');
        END");
        $stmt->execute();
        $stmt = $pdo->prepare("CREATE PROCEDURE EAT(IN id INT(2))
        BEGIN
            INSERT INTO actions (tamagotchi_id,action_id) VALUES (id);
        END");
        $stmt->execute();
        $stmt = $pdo->prepare("CREATE PROCEDURE DRINK(IN id INT(2))
        BEGIN
            INSERT INTO actions (username) VALUES (name);
        END");
        $stmt->execute();
        $stmt = $pdo->prepare("CREATE PROCEDURE BEDTIME(IN id INT(2))
        BEGIN
            INSERT INTO actions (username) VALUES (name);
        END");
        $stmt->execute();
        $stmt = $pdo->prepare("CREATE PROCEDURE ENJOY(IN id INT(2))
        BEGIN
            INSERT INTO actions (username) VALUES (name);
        END");
        $stmt->execute();
    }
}

class Table
{
    public string $name;
    public string $primaryKey;
    public array $columns;

    public function __construct(string $name, string $primaryKey, array $columns)
    {
        $this->name = $name;
        $this->primaryKey = $primaryKey;
        $this->columns = $columns;
    }
}
class Column
{
    public string $name;
    public string $type;
    public string $extras;

    public function __construct(string $name, string $type, string $extras = "")
    {
        $this->name = $name;
        $this->type = $type;
        $this->extras = $extras;
    }
}
