<?php

namespace Codbear\Alaska\Services;

use PDO;

class Database
{

    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;

    private $pdo = null;

    public function __construct(string $configFile)
    {
        $config = file_get_contents($configFile);
        $config = json_decode($config, true);
        $this->db_name = $config['dbname'];
        $this->db_user = $config['dblogin'];
        $this->db_pass = $config['dbpassword'];
        $this->db_host = $config['dbhost'];
    }

    private function getPDO()
    {
        if (is_null($this->pdo)) {
            $this->pdo = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name . '', $this->db_user, $this->db_pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        return $this->pdo;
    }

    public function query(string $statement)
    {
        $req = $this->getPDO()->query($statement);
        $datas = $req->fetchAll(PDO::FETCH_OBJ);
        return $datas;
    }

    public function prepare(string $statement, array $datas, bool $mustFetch = true)
    {
        $req = $this->getPDO()->prepare($statement);
        $req->execute($datas);
        if ($mustFetch) {
            return $req->fetch();
        }
        return $req;
    }
}
