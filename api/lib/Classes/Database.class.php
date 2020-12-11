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
                PDO::ATTR_PERSISTENT => true,
            );
            $dbname = getenv(_DB_HOST_);
            $socket_dir = getenv('DB_SOCKET_DIR') ?: '/cloudsql';
            $dsn = sprintf(
                'mysql:dbname=%s;unix_socket=%s/%s',
                $dbname,
                $socket_dir,
                _DB_HOST_
            );
            $this->conn = new PDO($dsn, _DB_USER_, _DB_PASSWORD_, $pdoOptions);
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
