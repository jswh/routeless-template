<?php


namespace Services;

use Routeless\Services\Redis;
class Cache
{
    protected $key, $ttl;

    public function __construct($key, $ttl = 0)
    {
        $this->key = $key;
        $this->ttl = $ttl;
    }

    public function put($val)
    {
        Redis::get()->set($this->key, $val, $this->ttl);
    }

    public function del()
    {
        Redis::get()->delete($this->key);
    }

    public function get()
    {
        return Redis::get()->get($this->key);
    }
}