<?php

namespace TikTok\Scanner;

class Server
{
	/**
	 * @var Scanner
	 */
	private $_scanner;

	/**
	 * @var string
	 */
	private $_httpIp;

	/**
	 * @var int
	 */
	private $_httpPort;

	/**
	 * @param Scanner $scanner
	 * @param string $httpIp
	 * @param int $httpPort
	 */
	public function __construct(
		Scanner $scanner,
		string $httpIp = '127.0.0.1',
		int $httpPort = 80
	)
	{
		$this->_scanner = $scanner;
		$this->_httpIp = $httpIp;
		$this->_httpPort = $httpPort;
	}

	/**
	 * @return void
	 */
	public function start()
	{
		$socket = \socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
		if (! $socket) {
			echo "$errstr ($errno)<br />\n";
		} else {
			socket_bind($socket, $this->_httpIp, $this->_httpPort);
			echo 'Start listening to incoming connections on ' . $this->_httpIp . ':' . $this->_httpPort . "...\n";
			while (socket_listen($socket, 1)) {
				$conn = socket_accept($socket);
				if ($conn === false) {
					usleep(500);
					continue;
				}
				echo "==========\nNew request has been received:\n";
				$request = socket_read($conn, 4096);
				echo $request . "\n";

				$response = $this->requestHandler($request);
				socket_write($conn, 'HTTP/1.1 200 OK' . "\n");
				socket_write($conn, 'Date: ' . date('D, d M Y H:i:s T', time()) . "\n");
				socket_write($conn, 'Server: self-written stuff (even don\'t try to hack)' . "\n");
				socket_write($conn, 'Content-type: application/json; charset=utf-8' . "\n");
				socket_write($conn, 'Connection: Closed');
				socket_write($conn, "\r\n\r\n");
				socket_write($conn, is_array($response) ? json_encode($response) : $response);
				echo "Response has been sent.\n";
				socket_close($conn);
			}
			socket_close($socket);
		}
	}

	/**
	 * @param string $request
	 * @return array
	 */
	protected function requestHandler(string $request)
	{
		$matches = $tokens = [];
		if (preg_match('/GET (.*) HTTP\/1\.1/', $request, $matches)) {
			if (preg_match('/^\/profile\/(.*)$/', $matches[1], $tokens)) { //profile request
				$json = $this->_scanner->getUserInfo($tokens[1]);
				return empty($json) ? [] : $json;
			}
			if (preg_match('/^\/postslist\/(.*)\/(.*)$/', $matches[1], $tokens)) { //fetch posts request
				$json = $this->_scanner->getAllPosts($tokens[1], $tokens[2]);
				return empty($json) ? [] : $json;
			}
		}
		return [];
	}
}