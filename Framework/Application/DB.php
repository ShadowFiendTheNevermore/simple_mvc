<?php
namespace ShadowFiend\Framework\Application;

use ShadowFiend\Framework\Application\QueryBuilder;
use ShadowFiend\Framework\Config\Config;
use ShadowFiend\Framework\Model\Model;

/**
* Class DB. Wrapper for PDO extension
* Release a Singleton pattern
*/
class DB
{

    /**
     * Singleton for PDO
     * 
     * @var PDO instance or null if not initialized
     */
    protected static $db_instance = null;

    /**
     * Block __construct and __clone methods
     */
    final private function __construct() {}
    final private function __clone() {}


    /**
     * Create new \PDO instance if not exists or return PDO if exists
     * 
     * @return \PDO instance | singleton for wrapping a PDO extension
     */
    public static function getConnection()
    {
        if (self::$db_instance === null)
        {
            $db_host     = Config::getValue('db.host');
            $db_name     = Config::getValue('db.db_name');
            $db_username = Config::getValue('db.db_user');
            $db_password = Config::getValue('db.db_password');

            $dsn = 'mysql:host='.$db_host.';dbname='.$db_name.';';
            
            self::$db_instance = new \PDO($dsn, $db_username, $db_password);
            self::$db_instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$db_instance->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }

        return self::$db_instance;
    }
    

}

