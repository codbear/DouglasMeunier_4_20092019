<?php

namespace Codbear\Alaska\Services;

use PDO;

class Database
{
    const FETCH_SINGLE = 1;
    const FETCH_ALL = 2;

    private static $db_name;
    private static $db_user;
    private static $db_pass;
    private static $db_host;

    private static $pdo = null;

    public static function init(string $configFile)
    {
        $config = file_get_contents($configFile);
        $config = json_decode($config, true);
        self::$db_name = $config['dbname'];
        self::$db_user = $config['dblogin'];
        self::$db_pass = $config['dbpassword'];
        self::$db_host = $config['dbhost'];
    }

    public static function query(string $statement, $fetchOption)
    {
        $req = self::getPDO()->query($statement);
        switch ($fetchOption) {
            case self::FETCH_SINGLE:
                $datas = $req->fetch();
                break;

            case self::FETCH_ALL:
                $datas = $req->fetchAll();
                break;
        }
        return $datas;
    }

    public static function prepare(string $statement, array $datas, bool $mustFetch = true)
    {
        $req = self::getPDO()->prepare($statement);
        $req->execute($datas);
        if ($mustFetch) {
            return $req->fetch();
        }
        return $req;
    }

    private static function getPDO()
    {
        if (is_null(self::$pdo)) {
            self::$pdo = new PDO('mysql:host=' . self::$db_host . ';dbname=' . self::$db_name . '', self::$db_user, self::$db_pass);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        return self::$pdo;
    }
}
