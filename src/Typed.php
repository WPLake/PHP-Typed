<?php

declare(strict_types=1);

namespace WPLake\Typed;

use DateTime;
use stdClass;

/**
 * This class is marked as final to prevent extension.
 * It allows us to add new public methods in the future.
 *
 * Note: If you need a generic type casting that’s missing, feel free to open a pull request.
 * For specific use cases, consider implementing your own function.
 */
final class Typed
{
    /**
     * @param mixed $source
     * @param int|string $key
     * @param mixed $value
     *
     * @return mixed
     */
    protected static function resolveKey($source, $key, &$value): bool
    {
        if (true === is_object($source) &&
            true === isset($source->{$key})) {
            $value = $source->{$key};
            return true;
        }

        if (true === is_array($source) &&
            true === isset($source[$key])) {
            $value = $source[$key];
            return true;
        }

        return false;
    }

    /**
     * @param mixed $source
     * @param array<int,int|string> $keys
     * @param mixed $default
     * @return mixed
     */
    protected static function resolveKeys($source, array $keys, $default)
    {
        foreach ($keys as $key) {
            $value = null;

            if (true === self::resolveKey($source, $key, $value)) {
                $source = $value;
                continue;
            }

            return $default;
        }

        return $source;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     * @param mixed $default
     *
     * @return mixed
     */
    public static function any($source, $key = null, $default = null)
    {
        if (null === $key) {
            return $source;
        }

        $stringKey = (string)$key;
        $isInnerKey = false !== strpos($stringKey, '.');

        if (false === $isInnerKey) {
            $value = null;
            return true === self::resolveKey($source, $key, $value) ?
                $value :
                $default;
        }

        $keys = explode('.', $stringKey);

        return self::resolveKeys($source, $keys, $default);
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function string($source, $key = null, string $default = ''): string
    {
        $value = self::any($source, $key, $default);

        return true === is_string($value) ||
        true === is_numeric($value) ?
            (string)$value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function stringOrNull($source, $key = null): ?string
    {
        $value = self::any($source, $key);

        return true === is_string($value) ||
        true === is_numeric($value) ?
            (string)$value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function int($source, $key = null, int $default = 0): int
    {
        $value = self::any($source, $key, $default);

        return true === is_numeric($value) ?
            (int)$value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function intOrNull($source, $key = null): ?int
    {
        $value = self::any($source, $key);

        return true === is_numeric($value) ?
            (int)$value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function float($source, $key = null, float $default = 0.0): float
    {
        $value = self::any($source, $key, $default);

        return true === is_numeric($value) ?
            (float)$value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function floatOrNull($source, $key = null): ?float
    {
        $value = self::any($source, $key);

        return true === is_numeric($value) ?
            (float)$value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     * @param array<int|string,mixed> $allowed
     */
    public static function bool($source, $key = null, bool $default = false, array $allowed = [true, 1, '1', 'on',]): bool
    {
        $value = self::any($source, $key, $default);

        return true === in_array($value, $allowed, true) ?
            $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     * @param array<int|string,mixed> $allowed
     */
    public static function boolOrNull($source, $key = null, array $allowed = [true, 1, '1', 'on',]): ?bool
    {
        $value = self::any($source, $key);

        return true === in_array($value, $allowed, true) ?
            $value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function strictBool($source, $key = null, bool $default = false): bool
    {
        $value = self::any($source, $key, $default);

        return true === is_bool($value) ?
            $source :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function strictBoolOrNull($source, $key = null): ?bool
    {
        $value = self::any($source, $key);

        return true === is_bool($value) ?
            $source :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function array($source, $key = null, array $default = []): array
    {
        $value = self::any($source, $key, $default);

        return true === is_array($value) ?
            $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function arrayOrNull($source, $key = null): ?array
    {
        $value = self::any($source, $key);

        return true === is_array($value) ?
            $value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function object($source, $key = null, ?object $default = null): object
    {
        $default = null === $default ?
            new stdClass() :
            $default;

        $value = self::any($source, $key, $default);

        return true === is_object($value) ?
            $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function objectOrNull($source, $key = null): ?object
    {
        $value = self::any($source, $key);

        return true === is_object($value) ?
            $value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function dateTime($source, $key = null, ?DateTime $default = null): DateTime
    {
        $default = null === $default ?
            new DateTime() :
            $default;

        $value = self::object($source, $key, $default);

        return true === ($value instanceof DateTime) ?
            $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|null $key
     */
    public static function dateTimeOrNull($source, $key = null): ?DateTime
    {
        $value = self::any($source, $key);

        return true === ($value instanceof DateTime) ?
            $value :
            null;
    }
}