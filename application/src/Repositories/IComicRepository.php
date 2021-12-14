<?php

namespace App\Repositories;

interface IComicRepository
{
    public function search(string $title, int $limit, int $offset = 0, string $sort = 'focDate'): array;
}
