<?php

namespace App\Clients;

use App\Models\Comic;

class DataWrapper
{
    public static function fromJson(string $response): array
    {
        $decodedResponse = json_decode($response);
        $comics = [];
        foreach ($decodedResponse->data->results as $result) {
            $focDate = reset(array_filter($result->dates, fn ($date) => $date->type === 'focDate'));
            $comics[$result->id] = new Comic([
                'id' => $result->id,
                'title' => $result->title,
                'focDate' => $focDate->date
            ]);
        }
        return $comics;
    }
}
