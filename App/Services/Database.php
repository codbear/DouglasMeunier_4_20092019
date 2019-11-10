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

    public static function query(string $statement, $fetcher, $className = null)
    {
        $req = self::getPDO()->query($statement);
        return self::fetchRequest($req, $fetcher, $className);
    }

    public static function prepare(string $statement, array $datas, $fetcher, string $className = null)
    {
        $req = self::getPDO()->prepare($statement);
        $req->execute($datas);
        return self::fetchRequest($req, $fetcher, $className);
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
