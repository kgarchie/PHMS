<?php
class DB
{
    private $db;

    function __construct()
    {
        $this->db = new SQLite3('./database/sqlite.db');
    }

    function seed($location)
    {
        $sql = readfile($location);

        try {
            $this->db->exec($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function query($sql)
    {
        return $this->db->query($sql);
    }

    function close()
    {
        $this->db->close();
    }

    function __destruct()
    {
        $this->close();
    }

    function getDB()
    {
        return $this->db;
    }

    function getError()
    {
        return $this->db->lastErrorMsg();
    }
}

$db = new DB();
?>