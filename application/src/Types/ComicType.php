<?php

namespace App\Types;

use App\Types;
use Exception;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class ComicType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Comic',
            'fields' => static fn (): array => [
                'id' => Types::id(),
                'title' => Types::string(),
                'focDate' => Types::string(),
                'fieldWithError' => [
                    'type' => Types::string(),
                    'resolve' => static function (): void {
                        throw new Exception('This is error field');
                    },
                ],
            ],
            'resolveField' => function ($comic, $args, $context, ResolveInfo $info) {
                $fieldName = $info->fieldName;
                return $comic->{$fieldName};
            },
        ]);
    }
}
