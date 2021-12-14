<?php

namespace Tests;

use App\Clients\CachedClient;
use App\Clients\Client;
use Predis\Client as RedisClient;

class ClientTest extends BaseTest
{

    public function testClientCanSuccessfullySendHttpRequest()
    {
        $client = new Client($_ENV['MARVEL_PUBLIC_KEY'], $_ENV['MARVEL_PRIVATE_KEY']);
        $responseData = $client->send();
        $this->assertNotEmpty($responseData);
    }

    public function testCachedResponseCanBeRetrievedFromRedis()
    {
        $cachedClient = new CachedClient(new Client($_ENV['MARVEL_PUBLIC_KEY'], $_ENV['MARVEL_PRIVATE_KEY']));
        $cachedResponse = $cachedClient->send();
        $redisClient =  new RedisClient(['host' => $_ENV['REDIS_HOST_NAME']]);
        $this->assertEquals($cachedResponse, unserialize($redisClient->get('comics')));
    }
}
