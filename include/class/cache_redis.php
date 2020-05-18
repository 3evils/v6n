<?php
class CacheRedis
{

private $cache;
	/**
	 * Redis Settings
	 */
	private static $host = '127.0.0.1',
		$port = 6379,
		$auth = null;

	/**
	 * Set the details of the redis server.
	 * @param $host the host of the server (default 127.0.0.1)
	 * @param $port the port to use (default 6379)
	 * @param $auth the password to use (default no auth)
	 */
	public static function setRedisServer($host, $port = 6379, $auth = null){
		self::$host = $host;
		self::$port = $port;
		self::$auth = $auth;
	}

	private $redis, $prefix;

	/**
	 * Generate a storage
	 * @param $group The storage group, a prefix for the key.
	 */
	public function __construct(){
		$this->redis = new Redis();
		$this->redis->pconnect(self::$host, self::$port);
		if( !empty(self::$auth) ){
			$this->redis->auth(self::$auth);
		}

		if( !$this->redis->ping() ){
			throw new Exception('Unable to connect to Redis Server!');
		}
	}

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->client->exists($key) == 1;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->client->get($key) : $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int|null $time
     * @return $this
     */
    public function put($key, $value, $time = null)
    {
        if ($time === null) {
            return $this->forever($key, $value);
        }
        $this->client->setex($key, $time, $value);
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function forever($key, $value)
    {
        $this->client->set($key, $value);
        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function forget($key)
    {
        $this->client->del([$key]);
        return $this;
    }
    
    /**
     * @param string $key
     * @param callable $callback
     * @param int|null $time
     * @return mixed
     */
    public function remember($key, callable $callback, $time = null)
    {
        if ($this->has($key)) {
            return $this->get($key);
        }
        $value = $callback();
        $this->put($key, $value, $time);
        return $value;
    }
    public function testPutHasGet($key, $value)
    {
        //$this->cache->put($key, $value, 2);
        $this->assertTrue($this->cache->has($key));
        $this->assertEquals($this->cache->get($key), $value);
        sleep(4);
        $this->assertFalse($this->cache->has($key));
        $this->assertNull($this->cache->get($key));
        $this->assertEquals($this->cache->get($key, "default"), "default");
    }

    public function testForeverForget($key, $value)
    {
        $this->cache->forever($key, $value);
        $this->assertTrue($this->cache->has($key));
        $this->assertEquals($this->cache->get($key), $value);
        $this->cache->forget($key);
        $this->assertFalse($this->cache->has($value));

    }

    public function testRemember()
    {
        $this->assertEquals($key, $this->cache->remember("unittest_key_3", function () {
            return "test_3";
        }));
        $this->assertEquals("test_3", $this->cache->remember("unittest_key_3", function () {
            return "this will never be set";
        }));
    }

}
?>