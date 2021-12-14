<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'dotenv.php';

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
    $client = new Client($_ENV['MARVEL_PUBLIC_KEY'], $_ENV['MARVEL_PRIVATE_KEY']);
    $comicRepository = new ComicRepository(new CachedClient($client));
    $schema = new Schema([
        'query' => new QueryType($comicRepository),
        'typeLoader' => static fn (string $name): Type => Types::byTypeName($name),
    ]);
    $appContext = new AppContext();
    $appContext->rootUrl = $_ENV['APP_URL'];
    $appContext->request = $_REQUEST;
    $server = new StandardServer([
        'schema' => $schema,
        'context' => $appContext,
    ]);
    $server->handleRequest();
} catch (Throwable $error) {
    StandardServer::send500Error($error);
}
