<?php
class DBcontroller
{
    /* --- Connect Information --- */
    public $host = 'localhost';
    public $user = 'root';
    public $password = '';
    public $database = 'todoproject';

    /* --- Class Construct --- */
    public function __construct()
    {
        $this->conn = $this->connect();
    }

    /* --- Database Connect --- */

    public function connect()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        if (mysqli_connect_errno()) {
            printf("Connection failed: %s\
                ", mysqli_connect_error());
            exit();
        }
        // Change character set to utf8
        mysqli_set_charset($this->conn, 'utf8');

        return true;
    }

    /* --- Database Query Select --- */
    public function querySelect($table, $customSelect = '', $id = null)
    {
        if ($id == null) {
            if ($customSelect == '') {
                $query = ' SELECT * FROM ' . $table . ' WHERE 1 ';
            } elseif ($customSelect != '') {
                $query = "SELECT {$customSelect} FROM {$table} WHERE 1 ";
            }
        } elseif ($id != null) {
            if ($customSelect == '') {
                $query = 'SELECT * FROM ' . $table . ' WHERE ' . $id;
            } elseif ($customSelect != '') {
                $query = "SELECT {$customSelect} FROM {$table} WHERE $id";
            }
        }

        return $query;
    }

    /* --- Database Query Insert --- */

    public function queryInsert($table, $Data, $insertData)
    {
        $query = "INSERT INTO {$table}({$Data}) VALUES ({$insertData})";

        return $query;
    }

    /* --- Database Query Update --- */
    public function queryUpdate($table, $updatedData, $id = null)
    {
        $query = "UPDATE {$table} SET {$updatedData} WHERE {$id}";

        return $query;
    }

    /* --- Database Query Delete --- */
    public function queryDelete($table, $id = null)
    {
        $query = "DELETE FROM {$table} WHERE {$id}";

        return $query;
    }

    /* --- Database Query Custom --- */
    public function queryCustom($sql)
    {
        $query = "$sql";

        return $query;
    }

    /* --- Database Check Data --- */
    public function insertQuery($query)
    {
        $stmt = $this->conn->query($query);
        if ($stmt > 0) {
            $status = '1';
        } else {
            $status = '0';
        }
        $e = array('query' => $stmt, 'status' => $status);

        return $e;
    }

    /* --- Database Check Data --- */
    public function getAll($query)
    {
        $stmt = $this->conn->query($query);
        if ($stmt) {
            $status = '1';
        } else {
            $status = '0';
        }
        $e = array('query' => $stmt, 'status' => $status);

        return $e;
    }

    /* --- Database Get Data --- */
    public function fetch($stmt, $status)
    {
        if ($status == '1') {
            $result = $stmt->fetch_assoc();
        } else {
            $result = '0';
        }

        return $result;
    }

    /* --- Database get All Data --- */
    public function fetchAll($stmt, $status)
    {
        if ($status == '1') {
            $result = []; //initialise empty array
            while ($row = $stmt->fetch_assoc()) {
                $result[] = $row;
            }
        } else {
            $result = '0';
        }

        return $result;
    }

    /* --- Database Last Insert Id --- */
    public function lastInsertId()
    {
        $id = $this->conn->insert_id;

        return $id;
    }
}
