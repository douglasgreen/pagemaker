<?php

namespace PageMaker;

class Registry
{
    protected $registry = array();

    public function set($key, $value)
    {
        if (!isset($this->registry[$key])) {
            $this->registry[$key] = $value;
        } else {
            throw new Exception("There is already an entry for key $key");
        }
    }

    public function get($key)
    {
        if (isset($this->registry[$key])) {
            return $this->registry[$key];
        } else {
            throw new Exception("No entry for key $key");
        }
    }

    public function delete($key)
    {
        if (isset($this->registry[$key])) {
            unset($this->registry[$key]);
        } else {
            throw new Exception("No entry for key $key");
        }
    }

    public function has($key)
    {
        return isset($this->registry[$key]);
    }
}
