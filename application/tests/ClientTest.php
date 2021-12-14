<?php

namespace Tests;

use App\Clients\CachedClient;
use App\Clients\Client;
use PHPUnit\Framework\TestCase;
use Predis\Client as RedisClient;

class ClientTest extends TestCase
{
    private string $publicKey;
    private string $privateKey;
    private string $redisHostName;

    function setUp(): void
    {
        $this->publicKey = "099736801919555940ca6d07b6bb444c";
        $this->privateKey = "993e6f1936115d09ee54c906f9648702c9c5ca7a";
        $this->redisHostName = 'app_redis';
    }

    public function testClientCanSuccessfullySendHttpRequest()
    {
        $client = new Client($this->publicKey, $this->privateKey);
        $responseData = $client->send();
        $this->assertNotEmpty($responseData);
    }

    public function testCachedResponseCanBeRetrievedFromRedis()
    {
        $cachedClient = new CachedClient(new Client($this->publicKey, $this->privateKey));
        $cachedResponse = $cachedClient->send();
        $redisClient =  new RedisClient(['host' => $this->redisHostName]);
        $this->assertEquals($cachedResponse, unserialize($redisClient->get('comics')));
    }
}
