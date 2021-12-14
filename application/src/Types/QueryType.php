<?php

namespace App\Types;

use App\Repositories\IComicRepository;
use App\Types;
use Exception;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    private IComicRepository $comicRepository;

    public function __construct(IComicRepository $comicRepository)
    {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'comics' => [
                    'type' => Types::listOf(Types::comic()),
                    'description' => 'Return comics',
                    'args' => [
                        'limit' => [
                            'type' => Types::id(),
                            'description' => 'Number of comics to be returned',
                            'defaultValue' => 50,
                        ],
                        'offset' => [
                            'type' => Types::id(),
                            'description' => 'Number of comics to be skipped',
                            'defaultValue' => 0,
                        ],
                        'title' => [
                            'type' => Types::string(),
                            'description' => 'Search by title',
                            'defaultValue' => ''

                        ],
                        'sort' => [
                            'type' => Types::string(),
                            'description' => 'Sort comics',
                            'defaultValue' => 'focDate'
                        ]
                    ],
                ],
                'deprecatedField' => [
                    'type' => Types::string(),
                    'deprecationReason' => 'This field is deprecated!',
                ],
                'fieldWithException' => [
                    'type' => Types::string(),
                    'resolve' => static function (): void {
                        throw new Exception('Exception message thrown in field resolver');
                    },
                ],
            ],
            'resolveField' => function ($rootValue, $args, $context, ResolveInfo $info) {
                return $this->{$info->fieldName}($rootValue, $args, $context, $info);
            },
        ]);
        $this->comicRepository = $comicRepository;
    }

    public function comics($rootValue, array $args): array
    {
        return $this->comicRepository->search($args['title'], $args['limit'], $args['offset'], $args['sort']);
    }
}
