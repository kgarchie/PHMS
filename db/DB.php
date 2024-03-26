<?php

class Row
{
    private $row = null;

    public function __construct($row)
    {
        $this->row = $row;
    }

    function get($key)
    {
        if (!$this->row) return null;
        if (!isset($this->row[$key])) return null;
        return $this->row[$key];
    }

    public function __toString()
    {
        return json_encode($this->row);
    }

    public function row()
    {
        return $this->row;
    }

    public function has($key): bool
    {
        return isset($this->row[$key]);
    }

    public function toJson()
    {
        return json_encode($this->row);
    }
}

class Result
{
    private $result = null;

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    function at($index): ?Row
    {
        if (!$this->result) return null;
        if (!isset($this->result[$index])) return null;
        return new Row($this->result[$index]);
    }

    function first(): ?Row
    {
        return $this->at(0);
    }

    function last(): ?Row
    {
        return $this->at(count($this->result) - 1);
    }

    public function __toString()
    {
        return json_encode($this->result);
    }

    /**
     * @return array{Row[]}
     */
    public function all(): array
    {
        return $this->result;
    }

    public function count(): int
    {
        return count($this->result);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function pop(): Row
    {
        return new Row(array_pop($this->result));
    }

    public function toJson()
    {
        return json_encode($this->result);
    }

    public function groupBy($key): array
    {
        $grouped = [];
        foreach ($this->result as $rowArray) {
            $row = new Row($rowArray);
            if ($row->has($key)) {
                $groupedValue = $row->get($key);
                if (!isset($grouped[$groupedValue])) {
                    $grouped[$groupedValue] = [];
                }
                $grouped[$groupedValue][] = $rowArray;
            }
        }
        return $grouped;
    }
}

class DB
{
    private $db;

    /**
     * @throws Exception
     */
    function __construct($location)
    {
        try {
            $this->db = new PDO("sqlite:$location");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    function __destruct()
    {
        $this->db = null;
    }

    /**
     * @return array{?Result, ?string}
     *
     * @example
     * [$result, $error] = $db->query("INSERT INTO tname VALUES ?, ?, ?", $value1, $value2, $value3)
     */
    function query(string $sql, ...$params): array
    {
        try {
            if (count($params) > 0) {
                $stmt = $this->db->prepare($sql);
                $placeholderCount = substr_count($sql, '?');

                if ($placeholderCount !== count($params))
                    return [null, "Parameter count mismatch: Expected $placeholderCount, got " . count($params)];

                $stmt->execute($params);
                return [new Result($stmt->fetchAll()), null];
            } else {
                $result = $this->db->query($sql);
                if (!$result) return [null, "Failed to execute the query: " . $sql];

                return [new Result($result->fetchAll()), null];
            }
        } catch (Exception $e) {
            return [null, $e->getMessage()];
        }
    }
}


$db = new DB("./db/db.sqlite");

