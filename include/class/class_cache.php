<?php
/**
 |--------------------------------------------------------------------------|
 |   https://github.com/Bigjoos/                                            |
 |--------------------------------------------------------------------------|
 |   Licence Info: WTFPL                                                    |
 |--------------------------------------------------------------------------|
 |   Copyright (C) 2010 U-232 V5                                            |
 |--------------------------------------------------------------------------|
 |   A bittorrent tracker source based on TBDev.net/tbsource/bytemonsoon.   |
 |--------------------------------------------------------------------------|
 |   Project Leaders: Mindless, Autotron, whocares, Swizzles.               |
 |--------------------------------------------------------------------------|
  _   _   _   _   _     _   _   _   _   _   _     _   _   _   _
 / \ / \ / \ / \ / \   / \ / \ / \ / \ / \ / \   / \ / \ / \ / \
( U | - | 2 | 3 | 2 )-( S | o | u | r | c | e )-( C | o | d | e )
 \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/ \_/ \_/   \_/ \_/ \_/ \_/
 */
/*
define('FALLBACK_CACHE_DIR', '/var/www/cache/fallback/');
$md5 = md5($key);
$file = FALLBACK_CACHE_DIR . substr($md5, 0, 1) . '/' . substr($md5, 0, 2) . '/' . substr($md5, 0, 3) . '/' . $file;
//== Read the cache
if ($value === null) {
    if (file_exists($file)) {
        $result = unserialize(file_get_contents($file));
        if (!$expires || $result['time'] <= $time) {
            @unlink($file);
        } else {
            $value = $result['data'];
        }
    }
}
//== Writing the cache
else {
    if (!file_exists(dirname($file))) {
        mkdir(dirname($file), 0700, true);
    }
    file_put_contents($file, serialize(array('data' => $value, 'time' => $expires)));
}*/

if (!extension_loaded('memcached')) {
    die('Memcached Extension not loaded.');
}
class CACHE extends Memcached {
    public $CacheHits = array();
    public $MemcacheDBArray = array();
    public $MemcacheDBKey = '';
    protected $InTransaction = false;
    public $Time = 0;
    protected $Page = array();
    protected $Row = 1;
    protected $Part = 0;
    public static $connected = false;
    private static $link = NULL;
    public function __construct() {
        parent::__construct();
        $this->addserver('127.0.0.1', 11211);
    }
    //---------- Caching functions ----------//
    // Wrapper for Memcache::set, with the zlib option removed and default duration of 1 hour
    public function cache_value($Key, $Value, $Duration = 2592000) {
        $StartTime = microtime(true);
        if ($Duration != 0) {
            $Duration += time();
        }

        if (empty($Key)) {
            trigger_error("Cache insert failed for empty key");
        }
        if (!$this->set($Key, $Value, $Duration)) {
            trigger_error("Cache insert failed for key $Key -- " . $this->getResultCode(), E_USER_ERROR);
        }
        $this->Time += (microtime(true) - $StartTime) * 1000;
    }
    public function add_value($Key, $Value, $Duration = 2592000) {
        $StartTime = microtime(true);
        if ($Duration != 0) {
            $Duration += time();
        }
        if (empty($Key)) {
            trigger_error("Cache insert failed for empty key");
        }
        $add = $this->add($Key, $Value, $Duration);
        $this->Time += (microtime(true) - $StartTime) * 1000;
        return $add;
    }
    public function get_value($Key, $NoCache = false) {
        $StartTime = microtime(true);
        if (empty($Key)) {
            trigger_error("Cache retrieval failed for empty key");
        }
        $Return = $this->get($Key);
        $this->Time += (microtime(true) - $StartTime) * 1000;
        return $Return;
    }
    public function replace_value($Key, $Value, $Duration = 2592000) {
        $StartTime = microtime(true);
        if ($Duration != 0) {
            $Duration += time();
        }
        $this->replace($Key, $Value, false, $Duration);
        $this->Time += (microtime(true) - $StartTime) * 1000;
    }
    // Wrapper for Memcache::delete. For a reason, see above.
    public function delete_value($Key) {
        $StartTime = microtime(true);
        if (empty($Key)) {
            trigger_error("Cache retrieval failed for empty key");
        }
        if (!$this->delete($Key, 0)) {
        }
        $this->Time += (microtime(true) - $StartTime) * 1000;
    }
    //---------- memcachedb functions ----------//
    public function begin_transaction($Key) {
        $Value = $this->get($Key);
        if (!is_array($Value)) {
            $this->InTransaction = false;
            $this->MemcacheDBKey = array();
            $this->MemcacheDBKey = '';
            return false;
        }
        $this->MemcacheDBArray = $Value;
        $this->MemcacheDBKey = $Key;
        $this->InTransaction = true;
        return true;
    }
    public function cancel_transaction() {
        $this->InTransaction = false;
        $this->MemcacheDBKey = array();
        $this->MemcacheDBKey = '';
    }
    public function commit_transaction($Time = 2592000) {
        if (!$this->InTransaction) {
            return false;
        }
        if ($Time != 0) {
            $Time += time();
        }
        $this->cache_value($this->MemcacheDBKey, $this->MemcacheDBArray, $Time);
        $this->InTransaction = false;
    }
    // Updates multiple rows in an array
    public function update_transaction($Rows, $Values) {
        if (!$this->InTransaction) {
            return false;
        }
        $Array = $this->MemcacheDBArray;
        if (is_array($Rows)) {
            $i = 0;
            $Keys = $Rows[0];
            $Property = $Rows[1];
            foreach ($Keys as $Row) {
                $Array[$Row][$Property] = $Values[$i];
                $i++;
            }
        } else {
            $Array[$Rows] = $Values;
        }
        $this->MemcacheDBArray = $Array;
    }
    // Updates multiple values in a single row in an array
    // $Values must be an associative array with key:value pairs like in the array we're updating
    public function update_row($Row, $Values) {
        if (!$this->InTransaction) {
            return false;
        }
        if ($Row === false) {
            $UpdateArray = $this->MemcacheDBArray;
        } else {
            $UpdateArray = $this->MemcacheDBArray[$Row];
        }
        foreach ($Values as $Key => $Value) {
            if (!array_key_exists($Key, $UpdateArray)) {
                trigger_error('Bad transaction key (' . $Key . ') for cache ' . $this->MemcacheDBKey);
            }
            if ($Value === '+1') {
                if (!is_number($UpdateArray[$Key])) {
                    trigger_error('Tried to increment non-number (' . $Key . ') for cache ' . $this->MemcacheDBKey);
                }
                ++$UpdateArray[$Key]; // Increment value

            } elseif ($Value === '-1') {
                if (!is_number($UpdateArray[$Key])) {
                    trigger_error('Tried to decrement non-number (' . $Key . ') for cache ' . $this->MemcacheDBKey);
                }
                --$UpdateArray[$Key]; // Decrement value

            } else {
                $UpdateArray[$Key] = $Value; // Otherwise, just alter value

            }
        }
        if ($Row === false) {
            $this->MemcacheDBArray = $UpdateArray;
        } else {
            $this->MemcacheDBArray[$Row] = $UpdateArray;
        }
    }
    public static function clean() {
        if (!self::$this) {
            trigger_error('Not connected to Memcache server in ' . __METHOD__, E_USER_WARNING);
            return false;
        }
        self::$count++;
        $time = microtime(true);
        $clean = self::$link->flush();
        self::$time += (microtime(true) - $time);
        self::set_error(__METHOD__);
        return $clean;
    }
    public static function inc($key, $howmuch = 1) {
        if (!self::$this) {
            trigger_error('Not connected to Memcache server in ' . __METHOD__ . ' KEY = "' . $key . '"', E_USER_WARNING);
            return false;
        }

        self::$count++;
        $time = microtime(true);
        $inc = self::$link->increment($key, $howmuch);
        self::$time += (microtime(true) - $time);

        self::set_error(__METHOD__, $key);
        return $inc;
    }
    public static function dec($key, $howmuch = 1) {
        if (!self::$this) {
            trigger_error('Not connected to Memcache server in ' . __METHOD__ . ' KEY = "' . $key . '"', E_USER_WARNING);
            return false;
        }

        self::$count++;
        $time = microtime(true);
        $dec = self::$link->decrement($key, $howmuch);
        self::$time += (microtime(true) - $time);

        self::set_error(__METHOD__, $key);
        return $dec;
}
}//end class
?>