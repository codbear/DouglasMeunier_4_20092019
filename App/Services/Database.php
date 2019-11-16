<?php

namespace Codbear\Alaska\Services;

use PDO;

class Database
{
    const FETCH_SINGLE = 1;
    const FETCH_ALL = 2;

    private static $_db_name;
    private static $_db_user;
    private static $_db_pass;
    private static $_db_host;

    private static $_pdo = null;

    public static function init(string $configFile)
    {
        $config = file_get_contents($configFile);
        $config = json_decode($config, true);
        self::$_db_name = $config['dbname'];
        self::$_db_user = $config['dblogin'];
        self::$_db_pass = $config['dbpassword'];
        self::$_db_host = $config['dbhost'];
    }

    public static function query(string $statement, $fetcher = false, $className = null)
    {
        $req = self::getPDO()->query($statement);
        return self::fetchRequest($req, $fetcher, $className);
    }

    public static function prepare(string $statement, array $datas, $fetcher = false, string $className = null)
    {
        $req = self::getPDO()->prepare($statement);
        $req->execute($datas);
        return self::fetchRequest($req, $fetcher, $className);
    }

    private static function getPDO()
    {
        if (is_null(self::$_pdo)) {
            self::$_pdo = new PDO('mysql:host=' . self::$_db_host . ';dbname=' . self::$_db_name . '', self::$_db_user, self::$_db_pass);
            self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        return self::$_pdo;
    }

    private static function fetchRequest($request, $fetcher, $className)
    {
        if (!is_null($className)) {
            $request->setFetchMode(PDO::FETCH_CLASS, $className);
        }
        switch ($fetcher) {
            case self::FETCH_ALL:
                return $request->fetchAll();
                break;

            case self::FETCH_SINGLE:
                return $request->fetch();
                break;

            default:
                return $request;
                break;
        }
    }
}
