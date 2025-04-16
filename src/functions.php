<?php

declare(strict_types=1);

namespace WPLake\Typed;

use DateTime;

// Ready to break some rules? Here's the deal:
// In PHP, you can declare functions with names matching variable types.

// Did you think it's prohibited? Well, yes, but function names aren't in the list:
// “These names cannot be used to name a class, interface, or trait” –
// https://www.php.net/manual/en/reserved.other-reserved-words.php

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

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function string($source, $keys = null, string $default = ''): string
{
    return Typed::string($source, $keys, $default);
}

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function stringExtended($source, $keys = null, string $default = ''): string
{
    return Typed::stringExtended($source, $keys, $default);
}

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function stringOrNull($source, $keys = null): ?string
{
    return Typed::stringOrNull($source, $keys);
}

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function stringExtendedOrNull($source, $keys = null): ?string
{
    return Typed::stringExtendedOrNull($source, $keys);
}

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function int($source, $keys = null, int $default = 0): int
{
    return Typed::int($source, $keys, $default);
}

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function intOrNull($source, $keys = null): ?int
{
    return Typed::intOrNull($source, $keys);
}

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function float($source, $keys = null, float $default = 0.0): float
{
    return Typed::float($source, $keys, $default);
}

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function floatOrNull($source, $keys = null): ?float
{
    return Typed::floatOrNull($source, $keys);
}

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function bool($source, $keys = null, bool $default = false): bool
{
    return Typed::bool($source, $keys, $default);
}

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function boolOrNull($source, $keys = null): ?bool
{
    return Typed::boolOrNull($source, $keys);
}

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

/**
* @param mixed $source
* @param int|string|array<int,int|string>|null $keys
*/
function object($source, $keys = null, ?object $default = null): object
{
    return Typed::object($source, $keys, $default);
}

/**
* @param mixed $source
* @param int|string|array<int,int|string>|null $keys
*/
function objectOrNull($source, $keys = null): ?object
{
    return Typed::objectOrNull($source, $keys);
}

/**
* @param mixed $source
* @param int|string|array<int,int|string>|null $keys
*/
function dateTime($source, $keys = null, ?DateTime $default = null): DateTime
{
    return Typed::dateTime($source, $keys, $default);
}

/**
* @param mixed $source
* @param int|string|array<int,int|string>|null $keys
 */
function dateTimeOrNull($source, $keys = null): ?DateTime
{
    return Typed::dateTimeOrNull($source, $keys);
}

/**
 * @param mixed $target
 * @param int|string|array<int,int|string> $keys
 * @param mixed $value
 */
function setItem(&$target, $keys, $value): bool
{
    return Typed::setItem($target, $keys, $value);
}
