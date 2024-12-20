<?php

declare(strict_types=1);

use WPLake\Typed\Typed;

// Ready to break some rules? Here's the deal:
// In PHP, you can declare functions with names matching variable types.

// Did you think it's prohibited? Well, yes, but function names aren't in the list:
// “These names cannot be used to name a class, interface, or trait” –
// https://www.php.net/manual/en/reserved.other-reserved-words.php

// Since these functions must be declared in the global namespace (you can't go with 'use WPLake\\Typed\\string'),
// we've made their usage optional.

if (
    true === defined('WPLAKE_TYPED_FUNCTIONS') &&
    true === constant('WPLAKE_TYPED_FUNCTIONS')
) {
    // every function is wrapped with its own check to allow you override it.

    if (false === function_exists('any')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         * @param mixed $default
         *
         * @return mixed
         */
        function any($source, $keys = null, $default = null)
        {
            return Typed::any($source, $keys, $default);
        }
    }

    if (false === function_exists('string')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function string($source, $keys = null, string $default = ''): string
        {
            return Typed::string($source, $keys, $default);
        }
    }

    if (false === function_exists('stringExtended')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function stringExtended($source, $keys = null, string $default = ''): string
        {
            return Typed::stringExtended($source, $keys, $default);
        }
    }

    if (false === function_exists('stringOrNull')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function stringOrNull($source, $keys = null): ?string
        {
            return Typed::stringOrNull($source, $keys);
        }
    }

    if (false === function_exists('stringExtendedOrNull')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function stringExtendedOrNull($source, $keys = null): ?string
        {
            return Typed::stringExtendedOrNull($source, $keys);
        }
    }

    if (false === function_exists('int')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function int($source, $keys = null, int $default = 0): int
        {
            return Typed::int($source, $keys, $default);
        }
    }

    if (false === function_exists('intOrNull')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function intOrNull($source, $keys = null): ?int
        {
            return Typed::intOrNull($source, $keys);
        }
    }

    if (false === function_exists('float')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function float($source, $keys = null, float $default = 0.0): float
        {
            return Typed::float($source, $keys, $default);
        }
    }

    if (false === function_exists('floatOrNull')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function floatOrNull($source, $keys = null): ?float
        {
            return Typed::floatOrNull($source, $keys);
        }
    }

    if (false === function_exists('bool')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function bool($source, $keys = null, bool $default = false): bool
        {
            return Typed::bool($source, $keys, $default);
        }
    }

    if (false === function_exists('boolOrNull')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function boolOrNull($source, $keys = null): ?bool
        {
            return Typed::boolOrNull($source, $keys);
        }
    }

    if (false === function_exists('boolExtended')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         * @param array<int,mixed> $positive
         * @param array<int,mixed> $negative
         */
        function boolExtended(
            $source,
            $keys = null,
            bool $default = false,
            array $positive = [true, 1, '1', 'on',],
            array $negative = [false, 0, '0', 'off',]
        ): bool {
            return Typed::boolExtended($source, $keys, $default, $positive, $negative);
        }
    }

    if (false === function_exists('boolExtendedOrNull')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         * @param array<int,mixed> $positive
         * @param array<int,mixed> $negative
         */
        function boolExtendedOrNull(
            $source,
            $keys = null,
            array $positive = [true, 1, '1', 'on',],
            array $negative = [false, 0, '0', 'off',]
        ): ?bool {
            return Typed::boolExtendedOrNull($source, $keys, $positive, $negative);
        }
    }

    if (false === function_exists('arr')) {
        /**
         * Unlike other types, the 'array' keyword falls under a different category,
         * which also prohibits its usage for function names – https://www.php.net/manual/en/reserved.keywords.php
         * That's why we'll stick to using 'arr' instead.
         *
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         * @param array<int|string,mixed> $default
         *
         * @return array<int|string,mixed>
         */
        function arr($source, $keys = null, array $default = []): array
        {
            return Typed::array($source, $keys, $default);
        }
    }

    if (false === function_exists('arrayOrNull')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         *
         * @return array<int|string,mixed>|null
         */
        function arrayOrNull($source, $keys = null): ?array
        {
            return Typed::arrayOrNull($source, $keys);
        }
    }

    if (false === function_exists('object')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function object($source, $keys = null, ?object $default = null): object
        {
            return Typed::object($source, $keys, $default);
        }
    }

    if (false === function_exists('objectOrNull')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function objectOrNull($source, $keys = null): ?object
        {
            return Typed::objectOrNull($source, $keys);
        }
    }

    if (false === function_exists('dateTime')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function dateTime($source, $keys = null, ?DateTime $default = null): DateTime
        {
            return Typed::dateTime($source, $keys, $default);
        }
    }

    if (false === function_exists('dateTimeOrNull')) {
        /**
         * @param mixed $source
         * @param int|string|array<int,int|string>|null $keys
         */
        function dateTimeOrNull($source, $keys = null): ?DateTime
        {
            return Typed::dateTimeOrNull($source, $keys);
        }
    }
}
