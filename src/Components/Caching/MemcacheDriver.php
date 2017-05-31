<?php

namespace Cable\Caching\Memcache;


use Cable\Caching\Driver\BootableDriverInterface;
use Cable\Caching\Driver\DriverInterface;
use Cable\Caching\Driver\FlushableDriverInterface;
use Cable\Caching\Driver\TimeableDriverInterface;

class MemcacheDriver implements BootableDriverInterface,DriverInterface, TimeableDriverInterface, FlushableDriverInterface
{

    private $memcache;

    public function __construct()
    {
        $this->memcache = new \Memcached();

    }

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if (false !== ($value = $this->memcache->get($name))) {
            return $value;
        }

        return $default;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function delete($name)
    {
        return $this->memcache->delete($name);
    }

    /**
     * @return $this
     */
    public function flush()
    {
         $this->memcache->flush();

         return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param int $time
     * @return mixed
     */
    public function set($name, $value, $time)
    {
        return $this->memcache->set($name, $value, $time);

    }

    /**
     * @param array $configs
     * @return mixed
     */
    public function boot($configs = array())
    {
        if (!isset($configs['memcache']['servers'])) {
            $configs['memcache']['servers'][] = [
                'host' => '127.0.0.1',
                'port' => 11211
            ];
        }

        $servers= $configs['memcache']['servers'];

        foreach ($servers as $server){
            $this->memcache->addServer(
                $server['host'],
                $server['port']
            );
        }

        return $this;
    }
}