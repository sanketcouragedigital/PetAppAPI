<?php
class CacheMemcache {
    var $timeToLive = 0; // Time To Live
    var $memcacheEnabled = false; // Memcache enabled?
    var $cache = null;
    
    public function CacheMemcache() {
        if (class_exists('Memcache')) {
            $this->cache = new Memcache();
            $this->memcacheEnabled = true;
            if (! $this->cache->connect('localhost', 11211))  { // Instead 'localhost' here can be IP
                $this->cache = null;
                $this->memcacheEnabled = false;
            }
        }
    }
    
    public function getData($key) {
        $data = $this->cache->get($key);
        return false === $data ? null : $data;
    }
    
    public function setData($key, $data) {
        return $this->cache->set($key, $data, 0, $this->timeToLive);
    }
    
    public function delData($key) {
        return $this->cache->delete($key);
    }
}
?>