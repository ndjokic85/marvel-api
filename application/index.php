<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\AppContext;
use App\Clients\CachedClient;
use App\Clients\Client;
use App\Repositories\ComicRepository;
use App\Types;
use App\Types\QueryType;
use GraphQL\Server\StandardServer;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;


try {
    $client = new Client('099736801919555940ca6d07b6bb444c', '993e6f1936115d09ee54c906f9648702c9c5ca7a');
    $comicRepository = new ComicRepository(new CachedClient($client));
    $schema = new Schema([
        'query' => new QueryType($comicRepository),
        'typeLoader' => static fn (string $name): Type => Types::byTypeName($name),
    ]);
    $appContext = new AppContext();
    $appContext->rootUrl = 'http://localhost:8080';
    $appContext->request = $_REQUEST;
    $server = new StandardServer([
        'schema' => $schema,
        'context' => $appContext,
    ]);
    $server->handleRequest();
} catch (Throwable $error) {
    StandardServer::send500Error($error);
}
