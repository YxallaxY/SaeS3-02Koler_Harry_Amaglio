<?php

namespace touiteur\bd;

class ConnectionFactory{
    public static array $config;
    public static \PDO $connexion;

    public static function setConfig($file): void
    {
        if(isset(self::$config)===false){
            self::$config=parse_ini_file($file);
        }
    }

    public static function makeConnection(): \PDO
    {
        if(isset(self::$connexion)===false){
            self::$connexion=new \PDO(self::$config["driver"].":host=".self::$config["hostname"].";dbname=".self::$config["dbname"], "root", "");
        }

        return self::$connexion;
    }
}