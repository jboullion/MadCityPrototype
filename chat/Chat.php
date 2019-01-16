<?php 
//http://socketo.me/docs/
namespace MadChat;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
	protected $clients;
	private $subscriptions;
	private $users;
	public $PDO;

	public function __construct($PDO)
	{
		$this->clients = new \SplObjectStorage;
		$this->subscriptions = [];
		$this->users = [];
		$this->PDO = $PDO;
	}

	public function onOpen(ConnectionInterface $conn)
	{
		$this->clients->attach($conn);
		$this->users[$conn->resourceId] = $conn;
	}

	public function onMessage(ConnectionInterface $conn, $msg)
	{
		$data = json_decode($msg);
		switch ($data->command) {
			case "subscribe":
				$this->subscriptions[$conn->resourceId] = $data->channel;
				break;
			case "message":
				try{
					$message = json_decode($data->message);
					$insert = 
					"INSERT INTO `chat` ( `party_id`, `send_id`, `receive_id`, `send_name`, `receive_name`, `content` ) 
					VALUES ( :party_id, :send_id, :receive_id, :send_name, :receive_name, :content )";
		
					$stmt = $this->PDO->prepare($insert);
					$result = $stmt->execute(
						array(
							'party_id' => $message->party_id,
							'send_id' => $message->send_id,
							'receive_id' => $message->receive_id,
							'send_name' => $message->send_name,
							'receive_name' => $message->receive_name,
							'content' => $message->player_chat
						)
					);
					
				}catch(PDOException $e){
					error_log($e->getMessage(), 0);
				}
				
				if (isset($this->subscriptions[$conn->resourceId])) {

					$numRecv = count($this->subscriptions[$conn->resourceId]) - 1;
					echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
						, $conn->resourceId, $data->message, $numRecv, $numRecv == 1 ? '' : 's');

					$target = $this->subscriptions[$conn->resourceId];
					foreach ($this->subscriptions as $id => $channel) {
						if ($channel == $target && $id != $conn->resourceId) {
							$this->users[$id]->send($data->message);
						}
					}
				}
		}
	}

	public function onClose(ConnectionInterface $conn)
	{
		$this->clients->detach($conn);
		unset($this->users[$conn->resourceId]);
		unset($this->subscriptions[$conn->resourceId]);
	}

	public function onError(ConnectionInterface $conn, \Exception $e)
	{
		echo "An error has occurred: {$e->getMessage()}\n";
		$conn->close();
	}
}