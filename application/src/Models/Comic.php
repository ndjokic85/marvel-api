<?php

namespace App\Models;

use GraphQL\Utils\Utils;

class Comic
{
    public int $id;
    public string $title;

    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
