<?php

namespace App;

use PDO, PDOException, Exception;

$conn = DB::connect();
class DB
{

    static function connect()
    {
        try {
            $conn = new PDO('mysql:host=localhost;dbname=webcalendar;charset=utf8mb4', 'root', '');
            // установка режима вывода ошибок
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo 'Помилка підключення до бази даних: ' . $e->getMessage();
            
        }
    }
    static function query($query)
    {
        $db = DB::connect();
        try {
            $result = $db->query($query);
            return $result;
        } catch (Exception $e) {
            Data::MySQLError($e, $query);
            
        }
    }
    static function select($table_name, $select = '*', $where = '', $order = '', $limit = '')
    {
        $db = DB::connect();
        $query = "SELECT $select FROM $table_name";
        if ($where) {
            $query .= " WHERE $where";
        }
        if ($order) {
            $query .= " ORDER BY $order";
        }
        if ($limit) {
            $query .= " LIMIT $limit";
        }
        try {
            $result = $db->query($query);
            if ($result === false) {
                return [];
            }
            $items = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $items[] = $row;
            }
            return $items;
        } catch (Exception $e) {
            Data::MySQLError($e, $query);
            
        }
    }

    static function selectOne($table_name, $select = '*', $where = '', $order = '')
    {
        $db = DB::connect();
        $query = "SELECT $select FROM $table_name";
        if ($where)
            $query .= " WHERE $where";
        if ($order)
            $query .= " ORDER BY $order";

        $query .= " LIMIT 1";
        try {
            $result = $db->query($query);
            if ($result === false) {
                return [];
            }
            $items = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $items[] = $row;
            }
            return !empty($items) ? $items[0] : null;
        } catch (Exception $e) {
            Data::MySQLError($e, $query);
            
        }
    }
    static function selectByQuery(string $query,bool $getQuery = false)
    {
        if($getQuery){
            return $query;
        }
        $db = DB::connect();
        try {
            $result = $db->query($query);
            if ($result === false) {
                return [];
            }
            $items = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $items[] = $row;
            }
            return $items;
        } catch (Exception $e) {
            Data::MySQLError($e, $query);
            
        }
    }

    static function insert($table_name, $data)
    {
        $db = DB::connect();
        $keys = array_keys($data);
        $values = array_values($data);
        $query = "INSERT INTO $table_name (" . implode(',', $keys) . ') VALUES (' . implode(',', array_fill(0, count($values), '?')) . ')';
        try {
            $stmt = $db->prepare($query);

            $result = $stmt->execute($values);
            return $result;
        } catch (PDOException $e) {
            Data::MySQLError($e, $query);
            // 
        }
    }

    static public function update($table_name, $condition, $data)
    {
        $db = DB::connect();
        $keys = array_keys($data);
        $values = array_values($data);
        $query = "UPDATE $table_name SET ";
        foreach ($keys as $key) {
            $query .= "$key=?,";
        }
        $query = rtrim($query, ',');
        $query .= " WHERE $condition";
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($values);
        } catch (PDOException $e) {
            Data::MySQLError($e, $query);
            
        }
        return $result;
    }

    static public function delete($table_name, $condition)
    {
        $db = DB::connect();
        $query = "DELETE FROM $table_name WHERE $condition;";
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            Data::MySQLError($e, $query);
            
        }
    }

    static function lastInsertId($table_name)
    {
        try {
            $res = DB::selectByQuery('SELECT MAX(id) AS id FROM ' . $table_name . ';')[0]['id'];
            return $res;
        } catch (PDOException $e) {
            Data::MySQLError($e);
            
        }
    }
}
