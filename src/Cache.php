<?php

namespace PageMaker;

/**
 * @class Cache utility class
 *
 * This class uses the file system to store and retrieve cached data. Keep in mind that, depending on your needs, you
 * might prefer to use a dedicated caching system like Memcached or Redis, or a PHP extension like APCu.
 *
 * Please be aware that there's no mechanism for clearing old cache files. In a production environment, you'd want to
 * periodically clean up expired cache files. Also, file permissions might need to be adjusted based on your server
 * configuration.
 */
class Cache
{
    private $cachePath;

    public function __construct(string $cachePath = '/tmp/cache/')
    {
        $this->cachePath = $cachePath;

        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }

    public function get(string $key)
    {
        $filePath = $this->getFilePath($key);

        if (!file_exists($filePath)) {
            return null;
        }

        $data = file_get_contents($filePath);
        $data = unserialize($data);

        if ($data['expiry'] < time()) {
            unlink($filePath);
            return null;
        }

        return $data['data'];
    }

    public function set(string $key, $value, int $expiry = 3600)
    {
        $filePath = $this->getFilePath($key);

        $data = [
            'data' => $value,
            'expiry' => time() + $expiry
        ];

        file_put_contents($filePath, serialize($data));
    }

    private function getFilePath(string $key)
    {
        return $this->cachePath . md5($key);
    }
}
