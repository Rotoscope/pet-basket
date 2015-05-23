<?php

namespace Core;

class Db {

    static $connection = null;

    /**
     * 
     * @throws Exception
     */
    public static function connect() {
        // TODO apply custom config
        //$databaseConfig = Core\Config::databaseConfig;
        //$datebaseConfig['hostname']; etc

        $conn = new \mysqli(/*"WEBSITE", "TABLE_NAME", "PASSWORD", "USER_ACCT"*/);
        if ($conn->connect_errno) {
            throw new Exception("MySQL connection failure: " . $conn->connect_error);
        } else {
            self::$connection = $conn;
        }
    }

    public static function execute($sql) {
        $conn = self::$connection;
        if ($conn !== null) {
            $res = $conn->query($sql);
            if ($res === true || $res === false)
                return $res;
            if ($res->num_rows > 0) {
                if (method_exists('mysqli_result', 'fetch_all'))
                    return $res->fetch_all();
                $rows = array();
                while ($row = $res->fetch_assoc())
                    $rows[] = $row;
                return $rows;
            }
            return $res->fetch_array();
        } else {
            throw new Exception("No database connection exists");
        }
    }

    public static function insertId() {
        $conn = self::$connection;
        return $conn->insert_id;
    }

    public static function escape($value) {
        if (is_numeric($value))
            return $value;
        return mysqli_real_escape_string(self::$connection, $value);
    }

    public static function getErrorMessage() {
        return mysqli_error(self::$connection);
    }

}
