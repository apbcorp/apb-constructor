<?php

namespace CoreBundle\Container;

use Symfony\Component\HttpFoundation\Cookie;

class CookieContainer
{
    /**
     * @var Cookie[]
     */
    private $cookies = [];
    /**
     * @param string $name
     * @param mixed  $value
     * @param int    $expire
     */
    public function add(string $name, $value, int $expire = 0) : void
    {
        $this->cookies[$name] = new Cookie($name, $value, $expire);
    }

    /**
     * @param string $key
     * @return null|Cookie
     */
    public function get(string $key)
    {
        if (isset($this->cookies[$key])) {
            return $this->cookies[$key];
        }
        return null;
    }

    /**
     * @return Cookie[]
     */
    public function getAll() : array
    {
        return $this->cookies;
    }

    /**
     *
     */
    public function clear() : void
    {
        $this->cookies = [];
    }
}