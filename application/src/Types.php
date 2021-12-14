<?php

namespace App;

use App\Types\ComicType;
use Closure;
use Exception;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;

final class Types
{
    private static array $types = [];

    public static function comic(): callable
    {
        return self::get(ComicType::class);
    }

    public static function get(string $className): Closure
    {
        return static fn () => self::byClassName($className);
    }

    private static function byClassName(string $className): Type
    {
        $parts = explode('\\', $className);

        $cacheName = strtolower(preg_replace('~Type$~', '', $parts[count($parts) - 1]));
        $type = null;

        if (!isset(self::$types[$cacheName])) {
            if (class_exists($className)) {
                $type = new $className();
            }
            self::$types[$cacheName] = $type;
        }
        $type = self::$types[$cacheName];

        if (!$type) {
            throw new Exception('Unknown graphql type: ' . $className);
        }

        return $type;
    }

    public static function byTypeName(string $shortName): Type
    {
        $cacheName = strtolower($shortName);
        $type = null;

        if (isset(self::$types[$cacheName])) {
            return self::$types[$cacheName];
        }

        $method = lcfirst($shortName);
        if (method_exists(self::class, $method)) {
            $type = self::{$method}();
        }

        if (!$type) {
            throw new Exception('Unknown graphql type: ' . $shortName);
        }

        return $type;
    }

    public static function id(): ScalarType
    {
        return Type::id();
    }

    public static function int(): ScalarType
    {
        return Type::int();
    }

    public static function string(): ScalarType
    {
        return Type::string();
    }

    public static function listOf($type): ListOfType
    {
        return new ListOfType($type);
    }
}
