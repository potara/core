<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */


namespace Potara\Core\Provider\Doctrine;

use Potara\Core\Crud\AbstractEntity;

class DoctrineEntity extends AbstractEntity
{
    public $conn;

    /**
     * @var type=string
     */
    public $url;

    /**
     * @var type=string
     */
    public $driver;

    /**
     * @var type=string
     */
    public $host;

    /**
     * @var type=integer
     */
    public $port;

    /**
     * @var type=string
     */
    public $user;

    /**
     * @var type=string
     */
    public $password;

    /**
     * @var type=string
     */
    public $dbname;

    /**
     * @var type=string
     */
    public $default_dbname;

    /**
     * @var type=string
     */
    public $charset;

    /**
     * @var type=array
     */
    public $options;

    /**
     * @var type=string
     */
    public $path;

    /**
     * @var type=bolean
     */
    public $memory;

    /**
     * @var type=string
     */
    public $unix_socket;

    /**
     * @var type=string
     */
    public $ssl_key;

    /**
     * @var type=string
     */
    public $ssl_cert;

    /**
     * @var type=string
     */
    public $ssl_ca;

    /**
     * @var type=string
     */
    public $ssl_capath;

    /**
     * @var type=string
     */
    public $ssl_capher;

    /**
     * @var type=string
     */
    public $ssl_mode;

    /**
     * @var type=string
     */
    public $sslrootcert;

    /**
     * @var type=string
     */
    public $sslcert;

    /**
     * @var type=string
     */
    public $sslkey;

    /**
     * @var type=string
     */
    public $sslcrl;

    /**
     * @var type=string
     */
    public $application_name;

    /**
     * @var type=string
     */
    public $servicename;

    /**
     * @var type=bolean
     */
    public $service;

    /**
     * @var type=bolean
     */
    public $pooled;

    /**
     * @var type=string
     */
    public $instancename;

    /**
     * @var type=string
     */
    public $connectstring;

    /**
     * @var type=bolean
     */
    public $persistent;

    /**
     * @var type=string
     */
    public $cache;

    /**
     * @var type=array
     */
    public $cache_options;


    public function __construct($conf = [])
    {
        $conf['url']     = !empty($conf['url']) ? $conf['url'] : null;
        $conf['driver']  = !empty($conf['driver']) ? $conf['driver'] : 'pdo_mysql';
        $conf['host']    = !empty($conf['host']) ? $conf['host'] : 'localhost';
        $conf['port']    = !empty($conf['port']) ? $conf['port'] : 3306;
        $conf['user']    = !empty($conf['user']) ? $conf['user'] : 'root';
        $conf['charset'] = !empty($conf['charset']) ? $conf['charset'] : 'utf8';
        $conf['options'] = !empty($conf['options']) ? $conf['options'] : null;

        $conf['cache']         = !empty($conf['cache']) ? $conf['cache'] : null;
        $conf['cache_options'] = !empty($conf['cache_options']) ? $conf['cache_options'] : null;

        $driverEnable = [
            "pdo_mysql", "drizzle_pdo_mysql", "mysqli", "pdo_sqlite", "pdo_pgsql", "pdo_oci",
            "pdo_sqlsrv", "sqlsrv", "oci8", "sqlanywhere"
        ];

        if (!in_array($conf['driver'], $driverEnable)) {
            throw new \InvalidArgumentException("Doctrine drive invalid");
        }

        parent::__construct($conf);
        $this->options = !empty($this->options) ? $this->options : null;

        $this->conn = \Doctrine\DBAL\DriverManager::getConnection($this->toArray(), $this->options);
        $this->addCache();
    }


    public function noToArray() : array
    {
        return ['options', 'cache', 'cache_options'];
    }

    protected function clearParamsConectionPerDrive()
    {

    }

    protected function addCache()
    {
        if (!empty($this->cache)) {
            if (class_exists($this->cache)) {
                $configCache = empty($this->cache_options) ? new $this->cache() : new $this->cache($this->cache_options);
                $configConn  = $this->conn->getConfiguration();
                $configConn->setResultCacheImpl($configCache);
            }
        }
    }
}