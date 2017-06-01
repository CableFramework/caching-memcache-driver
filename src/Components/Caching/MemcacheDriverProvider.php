<?php

namespace Cable\Caching\Memcache;


use Cable\Container\ServiceProvider;

class MemcacheDriverProvider extends ServiceProvider
{

    /**
     * register new providers or something
     *
     * @return mixed
     */
    public function boot()
    {
    }

    /**
     * register the content
     *
     * @return mixed
     */
    public function register()
    {
        $caching = $this->getContainer()
            ->resolve('caching');

        $caching->addDriver('memcache', MemcacheDriver::class);
    }
}