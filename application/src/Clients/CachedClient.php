<?php

namespace App\Clients;

use Predis\Client;

class CachedClient implements IClient
{
  private IClient $client;
  private Client $redisClient;

  public function __construct(IClient $client)
  {
    $this->client = $client;
    $this->redisClient = new Client(['host' => $_ENV['REDIS_HOST_NAME']]);
  }

  public function send(): array
  {
    $cachedComics = $this->redisClient->get('comics');
    if (!$cachedComics) {
      $cachedComics = serialize($this->client->send());
      $this->redisClient->set('comics', $cachedComics);
    }
    return unserialize($cachedComics);
  }
}
