<?php
class DB
{
    private $db;
    private $errors = array();

    function __construct($location)
    {
        $this->db = new SQLite3($location);
        if (!$this->db) {
            array_push($this->errors, "SQLiteDatabase Error: " . $this->lastErrorMsg());
            throw new Exception("SQLiteDatabase Error: " . $this->lastErrorMsg());
        }
    }

    function __destruct()
    {
        $this->db->close();
    }

    function lastErrorMsg()
    {
        return $this->db->lastErrorMsg();
    }

    function query($sql, ...$params)
    {
        if (count($params) > 0) {
            $placeholderCount = substr_count($sql, '?');
            if ($placeholderCount !== count($params)) {
                throw new Exception("Parameter count mismatch.");
            }

            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare the statement.");
            }

            for ($i = 0; $i < $placeholderCount; $i++) {
                $stmt->bindValue($i + 1, $params[$i]);
            }

            $result = $stmt->execute();
            if (!$result) {
                throw new Exception("Failed to execute the statement.");
            }

            return $result;
        } else {
            $result = $this->db->query($sql);
            if (!$result) {
                throw new Exception("Failed to execute the query.");
            }

            return $result;
        }
    }

    function getErrors()
    {
        return $this->errors;
    }

    function getDB()
    {
        return $this->db;
    }

    function close()
    {
        $this->db->close();
    }
}
