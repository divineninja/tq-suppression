<?php

class Model extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function toJson($array, $callback = '')
    {
        if ($callback) {
            return $callback.'('. json_encode($array). ')';
        } else {
            return json_encode($array);
        }
    }
    /*
    * System default functions
    *
    * ADD, EDIT, DELETE, SELECT
    *
    */

    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_OBJ)
    {
        $sth = $this->prepare($sql);
        
        foreach ($array as $key => $value):
            $sth->bindValue("$key", $value);
        endforeach;

        $sth->execute();
        
        return $sth->fetchAll($fetchMode);
    }

    public function selectSingle($sql, $array = array(), $fetchMode = PDO::FETCH_OBJ)
    {
        $sth = $this->prepare($sql);

        foreach ($array as $key => $value):
            $sth->bindValue("$key", $value);
        endforeach;

        $sth->execute();

        return $sth->fetch($fetchMode);
    }

    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value):
            $sth->bindValue(":$key", $value);
        endforeach;

        $sth->execute();
        /* return $sth->errorInfo(); */
        return parent::lastInsertId();
    }

    public function update($table, $data, $where)
    {
        ksort($data);

        $fieldDetails = null;

        foreach ($data as $key => $value):
            $fieldDetails .= "`$key` = :$key, ";
        endforeach;

        $fieldDetails = rtrim($fieldDetails, ", ");

        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

        foreach ($data as $key => $value):
            $sth->bindValue(":$key", $value);
        endforeach;

        $sth->execute();
        return $sth->errorInfo();
    }

    public function delete($table, $where, $limit = 0)
    {
        if ($limit == 0):
            return $this->exec("DELETE FROM $table WHERE $where"); else:
            return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
        endif;
    }
    
    public function login_user($params)
    {
        $username = $params['username'];
        $password =$params['password'];
        $sql = "SELECT * FROM users WHERE phone = '$username' AND password = '$password'";
        return $this->selectSingle($sql);
    }
}
