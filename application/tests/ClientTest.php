<?php

namespace Tests;

use App\Clients\CachedClient;
use App\Clients\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    public function testRequestCanBeSentSuccessfully()
    {
        $publicKey = "099736801919555940ca6d07b6bb444c";
        $privateKey = "993e6f1936115d09ee54c906f9648702c9c5ca7a";
        $client = new Client($publicKey, $privateKey);
        $cachedClient = new CachedClient($client);
        $cachedClient->send();

       // $this->assertSame($collection->count(), $iterations);
    }
}
