<?php

/**
 * DATABASE CONNECTION AND SERVICES INSTANCE
 **/

class Database
{
    // Database connection settings
    public $DB_HOST = "localhost";
    public $DB_USER = "root";
    public $DB_PASSWORD = "";
    public $DB_NAME = "hotel_crm";
    public $DB;

    // Constructor to establish database connection
    function __construct()
    {
        $this->DB_CONNECTION();
    }

    // Establish database connection
    public function DB_CONNECTION()
    {
        $this->DB = new mysqli($this->DB_HOST, $this->DB_USER, $this->DB_PASSWORD, $this->DB_NAME);
        if ($this->DB->connect_error) {
            die("Connection failed: " . $this->DB->connect_error);
        }
    }

    // Close database connection
    public function CLOSE()
    {
        $this->DB->close();
    }

    // Escape special characters to prevent SQL injection
    public function ESCAPE($data)
    {
        return $this->DB->real_escape_string($data);
    }

    // Execute a custom SQL query
    public function SQL($query)
    {
        return $this->DB->query($query);
    }

    // Select data from a table
    public function SELECT($table, $fields, $options = '', $params = [])
    {
        $query = "SELECT {$fields} FROM {$table} {$options}";
        $stmt = $this->DB->prepare($query);

        if ($params) {
            $types = str_repeat('s', count($params)); // Assuming all parameters are strings; adjust as needed
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    // Select a single row from a table
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

    // Select multiple rows from a table based on a condition
    public function SELECT_WHERE($table, $fields, $where, $options = '')
    {
        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= $key . " = ? AND ";
        }
        $condition = substr($condition, 0, -5);

        $query = "SELECT {$fields} FROM {$table} WHERE {$condition} {$options}";
        $stmt = $this->DB->prepare($query);
        
        if ($where) {
            $types = str_repeat('s', count($where)); // Adjust types as needed
            $stmt->bind_param($types, ...array_values($where));
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    // Select a single row from a table based on a condition
    public function SELECT_ONE_WHERE($table, $fields, $where, $options = '')
    {
        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= $key . " = ? AND ";
        }
        $condition = substr($condition, 0, -5);

        $query = "SELECT {$fields} FROM {$table} WHERE {$condition} {$options} LIMIT 1";
        $stmt = $this->DB->prepare($query);
        
        if ($where) {
            $types = str_repeat('s', count($where)); // Adjust types as needed
            $stmt->bind_param($types, ...array_values($where));
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Insert data into a table
    public function INSERT($table, $fields = [])
    {
        $field_key = implode(",", array_keys($fields));
        $field_value = implode("','", array_values($fields));

        $query = "INSERT INTO {$table} ({$field_key}) VALUES('{$field_value}')";
        if ($this->DB->query($query)) {
            return "success";
        } else {
            return array("message" => 'failed INSERT', "error" => $this->DB->error);
        }
    }

    // Update data in a table
    public function UPDATE($table, $fields, $where)
    {
        $statement = "";
        $condition = "";
        foreach ($fields as $key => $value) {
            $statement .= $key . " = '" . $value . "', ";
        }
        $statement = substr($statement, 0, -2);
        foreach ($where as $key => $value) {
            $condition .= $key . " = '" . $value . "' AND ";
        }
        $condition = substr($condition, 0, -5);

        $query = "UPDATE {$table} SET {$statement} WHERE {$condition} ";
        if ($this->DB->query($query)) {
            return "success";
        } else {
            return array("message" => 'failed UPDATE', "error" => $this->DB->error);
        }
    }

    // Update data in a table with optional operation
    public function UPDATE_OPTION($table, $fields_option, $fields, $where)
    {
        $statement = "";
        $condition = "";
        foreach ($fields as $key => $value) {
            $statement .= $key . " = '" . $value . "', ";
        }
        $statement = substr($statement, 0, -2);
        foreach ($where as $key => $value) {
            $condition .= $key . " = '" . $value . "' AND ";
        }
        $condition = substr($condition, 0, -5);

        $query = "UPDATE {$table} SET {$fields_option}, {$statement} WHERE {$condition} ";
        if ($this->DB->query($query)) {
            return "success";
        } else {
            return array("message" => 'failed', "error" => $this->DB->error);
        }
    }

    // Delete data from a table
    public function DELETE($table, $where)
    {
        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= $key . " = '" . $value . "' AND ";
        }
        $condition = substr($condition, 0, -5);

        $query = "DELETE FROM {$table} WHERE {$condition} ";
        if ($this->DB->query($query)) {
            return 'success';
        } else {
            return array("message" => 'failed DELETE', "error" => $this->DB->error);
        }
    }
}
