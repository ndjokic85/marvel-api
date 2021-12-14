<?php

namespace App\Repositories;

use App\Clients\IClient;
use App\Models\Comic;

class ComicRepository implements IComicRepository
{
    private array $comics;

    public function __construct(IClient $client)
    {
        $this->comics = $client->send();
    }

    public function search(string $title, int $limit, int $offset = 0, string $sort = 'focDate'): array
    {
        $filteredItems = ($title) ?
            array_filter($this->comics, fn ($item) => stripos($item->title, $title) !== false)
            : $this->comics;
        usort($filteredItems, fn ($a, $b) => $a->{$sort} < $b->{$sort});
        return array_slice($filteredItems, $offset, $limit);
    }
}
