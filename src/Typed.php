<?php

declare(strict_types=1);

namespace WPLake\Typed;

use DateTime;
use stdClass;
use Throwable;

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
     * @param int|string|array<int,int|string>|null $keys
     * @param mixed $default
     *
     * @return mixed
     */
    public static function any($source, $keys = null, $default = null)
    {
        return self::anyAsReference($source, $keys, $default);
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function string($source, $keys = null, string $default = ''): string
    {
        $value = self::any($source, $keys, $default);

        return is_string($value) ||
        is_numeric($value) ?
            (string) $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function stringExtended($source, $keys = null, string $default = ''): string
    {
        $value = self::any($source, $keys, $default);

        if (
             is_string($value) ||
             is_numeric($value)
        ) {
            return (string) $value;
        }

        if (
             is_object($value) &&
             method_exists($value, '__toString')
        ) {
            return (string) $value;
        }

        return $default;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function stringOrNull($source, $keys = null): ?string
    {
        $value = self::any($source, $keys);

        return  is_string($value) ||
         is_numeric($value) ?
            (string) $value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function stringExtendedOrNull($source, $keys = null): ?string
    {
        $value = self::any($source, $keys);

        if (
            is_string($value) ||
             is_numeric($value)
        ) {
            return (string) $value;
        }

        if (
             is_object($value) &&
             method_exists($value, '__toString')
        ) {
            return (string) $value;
        }

        return null;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function int($source, $keys = null, int $default = 0): int
    {
        $value = self::any($source, $keys, $default);

        return  is_numeric($value) ?
            (int) $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function intOrNull($source, $keys = null): ?int
    {
        $value = self::any($source, $keys);

        return  is_numeric($value) ?
            (int) $value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function float($source, $keys = null, float $default = 0.0): float
    {
        $value = self::any($source, $keys, $default);

        return is_numeric($value) ?
            (float) $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function floatOrNull($source, $keys = null): ?float
    {
        $value = self::any($source, $keys);

        return  is_numeric($value) ?
            (float) $value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function bool($source, $keys = null, bool $default = false): bool
    {
        $value = self::any($source, $keys, $default);

        return  is_bool($value) ?
            $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function boolOrNull($source, $keys = null): ?bool
    {
        $value = self::any($source, $keys);

        return  is_bool($value) ?
            $value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     * @param array<int,mixed> $positive
     * @param array<int,mixed> $negative
     */
    public static function boolExtended(
        $source,
        $keys = null,
        bool $default = false,
        array $positive = [true, 1, '1', 'on',],
        array $negative = [false, 0, '0', 'off',]
    ): bool {
        $value = self::any($source, $keys, $default);

        if (in_array($value, $positive, true)) {
            return true;
        }

        if (in_array($value, $negative, true)) {
            return false;
        }

        return $default;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     * @param array<int,mixed> $positive
     * @param array<int,mixed> $negative
     */
    public static function boolExtendedOrNull(
        $source,
        $keys = null,
        array $positive = [true, 1, '1', 'on',],
        array $negative = [false, 0, '0', 'off',]
    ): ?bool {
        $value = self::any($source, $keys);

        if (in_array($value, $positive, true)) {
            return true;
        }

        if (in_array($value, $negative, true)) {
            return false;
        }

        return null;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     * @param array<int|string,mixed> $default
     *
     * @return array<int|string,mixed>
     */
    public static function array($source, $keys = null, array $default = []): array
    {
        $value = self::any($source, $keys, $default);

        return  is_array($value) ?
            $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     *
     * @return array<int|string,mixed>|null
     */
    public static function arrayOrNull($source, $keys = null): ?array
    {
        $value = self::any($source, $keys);

        return is_array($value) ?
            $value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function object($source, $keys = null, ?object $default = null): object
    {
        $default = null === $default ?
            new stdClass() :
            $default;

        $value = self::any($source, $keys, $default);

        return  is_object($value) ?
            $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function objectOrNull($source, $keys = null): ?object
    {
        $value = self::any($source, $keys);

        return is_object($value) ?
            $value :
            null;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function dateTime($source, $keys = null, ?DateTime $default = null): DateTime
    {
        $default = null === $default ?
            new DateTime() :
            $default;

        $value = self::object($source, $keys, $default);

        return $value instanceof DateTime ?
            $value :
            $default;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     */
    public static function dateTimeOrNull($source, $keys = null): ?DateTime
    {
        $value = self::any($source, $keys);

        return $value instanceof DateTime ?
            $value :
            null;
    }

    /**
     * @param mixed $target
     * @param int|string|array<int,int|string> $keys
     * @param mixed $value
     */
    public static function setItem(&$target, $keys, $value): bool
    {
        $keys = is_numeric($keys) ||
            is_string($keys) ?
            explode('.', (string) $keys) :
            $keys;

        $itemKey = array_pop($keys);

        // at least one key must be defined.
        if (null === $itemKey) {
            return false;
        }

        $parentItemReference = &self::anyAsReference($target, $keys);

        if (is_array($parentItemReference)) {
            $parentItemReference[$itemKey] = $value;

            return true;
        }

        if (is_object($parentItemReference)) {
            try {
                // @phpstan-ignore-next-line
                $parentItemReference->{$itemKey} = $value;
            } catch (Throwable $e) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @param mixed $source
     * @param int|string|array<int,int|string>|null $keys
     * @param mixed $default
     *
     * @return mixed
     */
    protected static function &anyAsReference(&$source, $keys = null, $default = null)
    {
        if (null === $keys) {
            return $source;
        }

        if (
            is_string($keys) ||
            is_numeric($keys)
        ) {
            $keys = explode('.', (string) $keys);
        }

        return self::resolveKeys($source, $keys, $default);
    }

    /**
     * @param mixed $source
     * @param int|string $key
     *
     * @return mixed
     */
    protected static function &resolveKey(&$source, $key, bool &$isResolved = false)
    {
        $value = null;

        if (
            is_object($source) &&
            // @phpstan-ignore-next-line
            isset($source->{$key})
        ) {
            $isResolved = true;

            // @phpstan-ignore-next-line
            $value = &$source->{$key};
        }

        if (
            is_array($source) &&
            key_exists($key, $source)
        ) {
            $isResolved = true;

            // @phpstan-ignore-next-line
            $value = &$source[$key];
        }

        return $value;
    }

    /**
     * @param mixed $source
     * @param array<int,int|string> $keys
     * @param mixed $default
     *
     * @return mixed
     */
    protected static function &resolveKeys(&$source, array $keys, $default)
    {
        $origin = &$source;

        foreach ($keys as $key) {
            $isResolved = false;

            $value = &self::resolveKey($origin, $key, $isResolved);

            if ($isResolved) {
                $origin = &$value;
                continue;
            }

            return $default;
        }

        return $origin;
    }
}
