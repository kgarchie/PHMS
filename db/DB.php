<?php
class DB
{
    private $db;

    /**
     * @throws Exception
     */
    function __construct($host, $username, $password, $database)
    {
        try{
            $this->db = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            die("Unable to connect to database");
        }
    }

    function __destruct()
    {
        $this->db = null;
    }


    /**
     * @throws Exception
     *
     * @example
     *
     * $db->query("INSERT INTO tname VALUES ?, ?, ?", $value1, $value2, $value3)
     */
    function query($sql, ...$params)
    {
        if(count($params) > 0){
            $stmt = $this->db->prepare($sql);

            $placeholderCount = substr_count($sql, '?');

            if ($placeholderCount !== count($params)) {
                throw new Exception("Parameter count mismatch: Expected $placeholderCount, got " . count($params));
            }

            $stmt->execute($params);
            return $stmt->fetchAll();
        } else {
            $result = $this->db->query($sql);
            if (!$result) {
                throw new Exception("Failed to execute the query: " . $sql);
            }

            return $result->fetchAll();
        }
    }

    /**
     * Returns the first result of an execution
     * @param $result
     * @return
     */
    static function first($result){
        if(!$result) return null;
        if(!isset($result[0])) return null;
        return $result[0];
    }

    static function getField($result, $field){
        if(!$result) return null;
        if(!isset($result[$field])) return null;
        return $result[$field];
    }
}

$db = new DB("localhost", "root", "", "myproject");