<?php

namespace Adaojunior\PostgreSqlBroadcastDriver;

use Illuminate\Contracts\Broadcasting\Broadcaster;
use Illuminate\Database\PostgresConnection;

class PostgresBroadcaster implements  Broadcaster
{

    /**
     * @var \Illuminate\Database\PostgresConnection
     */
    private $connection;

    public function __construct(PostgresConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $channel
     * @param string $payload
     */
    private function publish($channel,$payload)
    {
        $this->connection->select('SELECT pg_notify(:channel,:payload)',compact('channel','payload'));
    }

    /**
     * {@inheritdoc}
     */
    public function broadcast(array $channels, $event, array $payload = array())
    {
        $payload = json_encode(['event' => $event, 'data' => $payload]);

        foreach ($channels as $channel) {
            $this->publish($channel,$payload);
        }
    }
}
