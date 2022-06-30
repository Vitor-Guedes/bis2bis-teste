<?php

namespace App\Database;

use App\Http\{Response, ResponseCode};
use PDO;
use PDOException;

class Connection
{
    protected $_capsule;

    public function __construct(array $settings = [])
    {
        if (!$this->_capsule) {
            $this->createConnection($settings);
        }
    }

    protected function createConnection(array $settings = [])
    {
        try {
            $host = $settings['host'] ?? 'localhost';
            $port = $settings['port'] ?? '3306';
            $dbName = $settings['db_name'] ?? '';
            $user = $settings['user'] ?? '';
            $pass = $settings['pass'] ?? '';
            $charset = $settings['charset'] ?? 'utf8';

            $dsn = "mysql:host=$host;dbname=$dbName;port=$port;charset=$charset";
            $con = new PDO($dsn, $user, $pass);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_capsule = $con;
        } catch (PDOException $e) {
            $response = new Response();
            $response->setBody($e->getMessage(), ResponseCode::INTERNAL_ERROR);
            $response->send();
            exit;
        }
    }

    public function getConnection()
    {
        return $this->_capsule;
    }

    public function __destruct()
    {
        $this->_capsule = null;
    }
}