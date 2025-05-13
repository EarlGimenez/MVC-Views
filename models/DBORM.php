<?php

declare(strict_types=1);

namespace Models;

use PDO;
use PDOException;
use Exception;

class DBORM implements iDBFuncs
{

    private object $db;
    private string $sql = '';

    private int $whereInstanceCounter = 0;
    private array $valueBag = [];
    private string $table = '';

    // new implementation of query handling
    private string $lastQuery = '';
    // --------------------------------------

    public function __construct($driver, $user, $password, $options = null)
    {
        try {
            $this->db = new PDO($driver, $user, $password);
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public function select(?array $fieldList = null): object
    {
        $this->sql .= 'SELECT ';

        if ($fieldList === null) {
            $fieldList = '*';
            $this->sql .= $fieldList;
        } else {
            $contents = count($fieldList) - 1;
            $count = 0;
            foreach ($fieldList as $field) {
                $this->sql .= $field;
                if ($count < $contents)
                    $this->sql .= ', ';

                $count++;
            }
        }

        $this->sql .= ' ';

        return $this;
    }

    public function table($table): object
    {
        $this->table = $table;
        // error_log('Table set to: ' . $this->table);
        return $this;
    }
    

    //--------------------------------------- FROM function changed
    public function from($table): object
    {
        $this->table = $table;                      
        $this->sql .= 'FROM ' . $table . ' ';
        return $this;
    }
    //---------------------------------------
    

    public function get(): array
    {
        $recordset = $this->_runGetQuery(__FUNCTION__);
        return $recordset;
    }

    public function getAll(): array
    {
        $recordset = $this->_runGetQuery(__FUNCTION__);
        return $recordset;
    }

    private function _runGetQuery(string $getMethod): array
    {
        if (empty($this->table)) {
            throw new Exception('No table specified for the query.');
        }
    
        // **capture the query for debugging and for showQuery()**
        $this->lastQuery = $this->sql . ';';
    
        $dbStatement = $this->db->prepare($this->lastQuery);
        $dbStatement->execute($this->valueBag);
    
        if ($getMethod === 'get') {
            $recordset = $dbStatement->fetch(PDO::FETCH_ASSOC) ?: [];
        } elseif ($getMethod === 'getAll') {
            $recordset = $dbStatement->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } else {
            // catch any typo or mismatch
            throw new Exception("Invalid get method: {$getMethod}");
        }
    
        // reset state
        $this->sql = '';
        $this->whereInstanceCounter = 0;
        $this->valueBag = [];
    
        return $recordset;
    }
    
    

    public function where(): object
    {
        if (func_num_args() <= 1) {
            throw new Exception('Expecting 2 to 3 parameters. Less than 2 parameters encountered.');
        }

        if (func_num_args() == 2) {
            $field = func_get_arg(0);
            $operator = '=';
            $value = func_get_arg(1);
        } elseif (func_num_args() == 3) {
            $field = func_get_arg(0);
            $operator = func_get_arg(1);
            $value = func_get_arg(2);
        }

        $this->_runWhere($field, $operator, $value, __METHOD__);

        return $this;
    }

    public function whereOr(): object
    {
        if (func_num_args() <= 1) {
            throw new Exception('Expecting 2 to 3 parameters. Less than 2 parameters encountered.');
        }

        if (func_num_args() == 2) {
            $field = func_get_arg(0);
            $operator = '=';
            $value = func_get_arg(1);
        } elseif (func_num_args() == 3) {
            $field = func_get_arg(0);
            $operator = func_get_arg(1);
            $value = func_get_arg(2);
        }

        $this->_runWhere($field, $operator, $value, __METHOD__);

        return $this;
    }

    private function _runWhere($field, $operator, $value, $whereMethod): void
    {

        if ($this->whereInstanceCounter > 0) {
            if ($whereMethod === 'DBORM::where')
                $this->sql .= ' and ';
            elseif ($whereMethod === 'DBORM::whereOr')
                $this->sql .= ' or ';

            $this->sql .= $field . ' ' . $operator . ' ?';
        } else {
            $this->sql .= ' where ' . $field . ' ' . $operator . ' ?';
        }

        $this->valueBag[] = $value;
        $this->whereInstanceCounter++;
    }

    public function showQuery(): string
    {
        return $this->lastQuery;
    }

    public function showValueBag(): array
    {
        return $this->valueBag;
    }

    public function insert(array $values): int
    {
        $insertSQL = ' VALUES (';

        $numberArrayElements = count($values);

        foreach ($values as $value) {
            $this->valueBag[] = $value;
        }

        for ($counter = 0; $counter < $numberArrayElements; $counter++) {
            $insertSQL .= '?';

            if ($counter < ($numberArrayElements - 1))
                $insertSQL .= ',';
        }

        $insertSQL .= ');';

        $this->sql .= 'INSERT INTO ';
        $this->sql .= $this->table;
        $this->sql .= $insertSQL;

        $result = $this->_executeQuery();

        return $result;
    }

    private function _executeQuery(): int
    {
        try {
            //print_r($this->valueBag);
            $valueCounter = 0;

            $dbStatement = $this->db->prepare($this->sql);

            //-------------------------------------------------
            $this->lastQuery = $this->sql;
            //-------------------------------------------------
            
            //binding values as parameters
            $numberOfValuesInValueBag = count($this->valueBag);

            while ($valueCounter < $numberOfValuesInValueBag) {
                $valueType = gettype($this->valueBag[$valueCounter]);
                switch ($valueType) {
                    case 'string': {
                            $pdoType = PDO::PARAM_STR;
                            break;
                        }
                    case 'integer': {
                            $pdoType = PDO::PARAM_INT;
                            break;
                        }
                    case 'double': {
                            $pdoType = PDO::PARAM_STR;
                            break;
                        }
                }

                $dbStatement->bindParam($valueCounter + 1, $this->valueBag[$valueCounter], $pdoType);
                $valueCounter++;
            }

            
            //Executing the prepared statement
            $dbStatement->execute();
            $this->valueBag = []; //reset the value bag to an empty state

            $this->sql = ''; // Reset SQL
            $this->whereInstanceCounter = 0; // Reset where counter

            return $queryResult = $dbStatement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return 0;
    }

    public function update(array $values): int
    {
        // Capture existing WHERE clause and parameters
        $whereClause = $this->sql;
        $whereParams = $this->valueBag;

        // Resetting for good measure
        $this->sql = '';
        $this->valueBag = [];
        $this->whereInstanceCounter = 0;

        $updateSQL = 'UPDATE ' . $this->table . ' SET ';

        $numberArrayElements = count($values);
        $counter = 0;
        foreach ($values as $key => $value) {
            $updateSQL .= $key . ' = ?';
            $this->valueBag[] = $value;

            if ($counter < ($numberArrayElements - 1)) {
                $updateSQL .= ', ';
            }
            $counter++;
        }

        $updateSQL .= ' ' . $whereClause;

        $this->valueBag = array_merge($this->valueBag, $whereParams);

        $this->sql = $updateSQL;

        $result = $this->_executeQuery();

        return $result;
    }


    public function delete(): int
    {
        $deleteSQL = 'DELETE FROM ' . $this->table . ' ' . $this->sql . ';';

        $this->sql = $deleteSQL;

        $result = $this->_executeQuery();

        return $result;
    }
}
