<?php

namespace App\Repositories;

use App\Clients\IClient;
use App\Models\Comic;

class ComicRepository implements IComicRepository
{
    private IClient $client;
    private array $comics;

    public function __construct(IClient $client)
    {
        $this->client = $client;
        $this->init();
    }
    public function init(): void
    {
        $resource = $this->client->send();
        foreach ($resource->data->results as $result) {
            $this->comics[$result->id] = new Comic([
                'id' => $result->id,
                'title' => $result->title
            ]);
        }
    }
    public function search(string $title, int $limit, int $offset = 0): array
    {
        $filteredItems = ($title) ?
            array_filter($this->comics, fn ($item) => stripos($item->title, $title) !== false)
            : $this->comics;

        return array_slice($filteredItems, $offset, $limit);
    }
}
