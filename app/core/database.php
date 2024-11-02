<?php

/**
 * DATABASE CONNECTION AND SERVICES INSTANCE
 * 
 * This class handles the database connection and provides methods for 
 * CRUD (Create, Read, Update, Delete) operations.
 */
class Database
{
    // Database connection settings
    public $DB_HOST = "localhost";
    public $DB_USER = "root";
    public $DB_PASSWORD = "";
    public $DB_NAME = "hotel_crm";
    private $DB;

    /**
     * Constructor to establish database connection.
     */
    public function __construct()
    {
        $this->DB_CONNECTION();
    }

    /**
     * Establishes a database connection.
     * 
     * @return void
     */
    private function DB_CONNECTION()
    {
        $this->DB = new mysqli($this->DB_HOST, $this->DB_USER, $this->DB_PASSWORD, $this->DB_NAME);
        if ($this->DB->connect_error) {
            die("Connection failed: " . $this->DB->connect_error);
        }
    }

    /**
     * Closes the database connection.
     * 
     * @return void
     */
    public function CLOSE()
    {
        $this->DB->close();
    }

    /**
     * Escapes special characters to prevent SQL injection.
     * 
     * @param string $data Data to escape.
     * @return string Escaped data.
     */
    public function ESCAPE($data)
    {
        return $this->DB->real_escape_string($data);
    }

    /**
     * Executes a custom SQL query.
     * 
     * @param string $query SQL query to execute.
     * @return mixed Query result.
     */
    public function SQL($query)
    {
        return $this->DB->query($query);
    }

    /**
     * Selects data from a table.
     * 
     * @param string $table Table name.
     * @param string $fields Fields to select.
     * @param string $options Additional SQL options.
     * @param array $params Parameters for prepared statements.
     * @return array Fetched data as an associative array.
     */
    public function SELECT($table, $fields, $options = '', $params = [])
    {
        $query = "SELECT {$fields} FROM {$table} {$options}";
        $stmt = $this->DB->prepare($query);

        if ($params) {
            $types = str_repeat('s', count($params)); // Adjust types as needed
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Selects a single row from a table.
     * 
     * @param string $table Table name.
     * @param string $fields Fields to select.
     * @param string $options Additional SQL options.
     * @param array $params Parameters for prepared statements.
     * @return array|null Single row as an associative array or null if no row found.
     */
    public function SELECT_ONE($table, $fields, $options = '', $params = [])
    {
        $query = "SELECT {$fields} FROM {$table} {$options} LIMIT 1";
        $stmt = $this->DB->prepare($query);

        if ($params) {
            $types = str_repeat('s', count($params)); // Adjust types as needed
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Selects multiple rows from a table based on a condition.
     * 
     * @param string $table Table name.
     * @param string $fields Fields to select.
     * @param array $where Conditions as associative array.
     * @param string $options Additional SQL options.
     * @return array Fetched data as an associative array.
     */
    public function SELECT_WHERE($table, $fields, $where, $options = '')
    {
        $condition = implode(" = ? AND ", array_keys($where)) . " = ?";
        $query = "SELECT {$fields} FROM {$table} WHERE {$condition} {$options}";
        $stmt = $this->DB->prepare($query);

        if ($where) {
            $types = str_repeat('s', count($where)); // Adjust types as needed
            $stmt->bind_param($types, ...array_values($where));
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Inserts data into a table.
     * 
     * @param string $table Table name.
     * @param array $fields Data to insert as associative array.
     * @return string|array Success message or error message with details.
     */
    public function INSERT($table, $fields = [])
    {
        $field_key = implode(",", array_keys($fields));
        $placeholders = implode(",", array_fill(0, count($fields), '?'));
        $query = "INSERT INTO {$table} ({$field_key}) VALUES ({$placeholders})";

        $stmt = $this->DB->prepare($query);
        $types = str_repeat('s', count($fields));
        $stmt->bind_param($types, ...array_values($fields));

        if ($stmt->execute()) {
            return "success";
        } else {
            return ["message" => 'failed INSERT', "error" => $stmt->error];
        }
    }

    /**
     * Updates data in a table.
     * 
     * @param string $table Table name.
     * @param array $fields Data to update as associative array.
     * @param array $where Conditions as associative array.
     * @return string|array Success message or error message with details.
     */
    public function UPDATE($table, $fields, $where)
    {
        $set_clause = implode(" = ?, ", array_keys($fields)) . " = ?";
        $condition = implode(" = ? AND ", array_keys($where)) . " = ?";

        $query = "UPDATE {$table} SET {$set_clause} WHERE {$condition}";
        $stmt = $this->DB->prepare($query);

        $types = str_repeat('s', count($fields) + count($where));
        $stmt->bind_param($types, ...array_merge(array_values($fields), array_values($where)));

        if ($stmt->execute()) {
            return "success";
        } else {
            return ["message" => 'failed UPDATE', "error" => $stmt->error];
        }
    }

    /**
     * Deletes data from a table.
     * 
     * @param string $table Table name.
     * @param array $where Conditions as associative array.
     * @return string|array Success message or error message with details.
     */
    public function DELETE($table, $where)
    {
        $condition = implode(" = ? AND ", array_keys($where)) . " = ?";
        $query = "DELETE FROM {$table} WHERE {$condition}";
        $stmt = $this->DB->prepare($query);

        $types = str_repeat('s', count($where));
        $stmt->bind_param($types, ...array_values($where));

        if ($stmt->execute()) {
            return 'success';
        } else {
            return ["message" => 'failed DELETE', "error" => $stmt->error];
        }
    }
}
