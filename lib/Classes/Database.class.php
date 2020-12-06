<?php

class Database extends \PDO
{

    protected $conn;
    private $connected = false;
    private $query = null;

    public function __construct()
    {
        try
        {
            $pdoOptions = array(
                PDO::ATTR_TIMEOUT => 10,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_PERSISTENT => false
            );
            $this->conn = new PDO("mysql: host="._DB_HOST_.";dbname="._DB_NAME_.";charset=utf8", _DB_USER_, _DB_PASSWORD_);
            $this->connected = true;
        }
        catch(PDOException $err)
        {
            echo 'Error Msg: '. $err->getMessage() . '<br> Error Code: '. $err->getCode();
            exit;
        }
    }
    public function query($query, $params = false)
    {
        $this->query = $this->conn->prepare($query);
        if($params)
        {
            $this->query->execute($params);
        }
        else
        {
            $this->query->execute();
        }
        return $this->query;
    }
    public function checkConnection()
    {
        return $this->connected;
    }
    public function close()
    {
        unset($this->conn, $this->query);
    }
    public function __deconstruct()
    {
        unset($this->conn, $this->query);
    }
}
