<?php

namespace TikTok;

class CacheEngine
{
	/**
	 * @var \Memcached
	 */
	private $_memcached;
	
	/**
	 * @param array $servers
	 */
	public function __construct(array $servers)
	{
		$this->_memcached = new \Memcached();
		$this->_memcached->addServers($servers);
	}

	/**
	 * @param string $cacheKey
	 */
	public function get($cacheKey)
	{
		return $this->_memcached->get($cacheKey);
	}
	
	/**
	 * @param string $cacheKey
	 * @param mixed  $data
	 * @param int    $timeout
	 */
	public function set($cacheKey, $data, $timeout = 180)
	{
		return $this->_memcached->set($cacheKey, $data, $timeout);
	}
}