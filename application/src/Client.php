<?php

namespace App;

class Client implements IClient
{
    const BASE_URL = 'http://gateway.marvel.com/v1/public/';
    private string $publicKey;
    private string $privateKey;

    private array $headers = [
        'Accept: application/json',
        'Content-Type: application/json',
    ];


    function __construct(string $publicKey, string $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    public function send()
    {
        $ts = time();
        $hash = md5("{$ts}{$this->privateKey}{$this->publicKey}");
        $key = "comics?ts={$ts}&apikey={$this->publicKey}&hash={$hash}";
        $url = self::BASE_URL . $key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $results = curl_exec($ch);
    }
}
