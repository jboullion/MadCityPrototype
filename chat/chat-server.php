<?php 
/**
 * Ratchet Websocket Server
 * 
 * @link http://socketo.me/
 */

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/Chat.php';
require __DIR__ . '/../includes/database.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MadChat\Chat;

$server = IoServer::factory(
	new HttpServer(
		new WsServer(
			new Chat($PDO)
		)
	),
	8080
);

$server->run();