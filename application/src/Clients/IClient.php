<?php

namespace App\Clients;

use stdClass;

interface IClient
{
    public function send(): array;
}
