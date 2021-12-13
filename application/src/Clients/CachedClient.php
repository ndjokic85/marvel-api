<?php

namespace App\Clients;

use Predis\Client;

class CachedClient implements IClient
{
    private IClient $client;
    private array $cachedComics;
    private Client $redisClient;

    public function __construct(IClient $client)
    {
        $this->client = $client;
        $this->redisClient = new Client();
        $this->cachedComics = $this->redisClient->get('comics');
    }

    public function send()
    {
        if (!$this->cachedComics) {
            $this->cachedComics = $this->client->send();
            $this->redisClient->set('comics', $this->cachedComics);
        }

        return $this->cachedComics;
    }
}
