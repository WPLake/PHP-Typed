# PHP Typed

> `Typed` is a lightweight PHP utility for seamless type-casting and data retrieval from dynamic variables, arrays, and
> objects.

This package provides a single `Typed` class with static methods and offers compatibility with PHP versions `7.4+` and
`8.0+`.

## 1. Why Use Typed?

Handling type casting in PHP often leads to verbose and repetitive constructions. `Typed` streamlines this process,
allowing you to fetch and cast values with concise, readable code.

**Example: Plain PHP**

```php
function getTypedStringFromMixedVariable($mixed): string
{
    return true === is_string($mixed) || true === is_numeric($mixed)
        ? (string)$mixed
        : '';
}

function getTypedIntFromArray(array $array): int
{
    return true === isset($array['meta']['number']) &&
             true === is_numeric($array['meta']['number'])
             ? (int)$array['meta']['number']
             : 0;
}
```

**The same with `Typed` utility**

```php
use WPLake\Typed\Typed;

function getTypedStringFromMixedVariable($mixedData): string
{
    return Typed::string($mixedData);
}

// Array item type casting:
function getTypedIntFromArray(array $data): int
{
    return Typed::int($data, 'meta.number');
}

```

Want to provide a default value when the key is missing? Here you go:

```php
Typed::string($data, 'some.key', 'Default Value');
```

## 2. Installation and usage

Typed class is distributed as a Composer package, making installation straightforward:

`composer require wplake/typed`

After installation, ensure that your application includes the Composer autoloader (if it hasn’t been included already):

`require __DIR__ . '/vendor/autoload.php';`

Usage:

```php
use WPLake\Typed\Typed;

$string = Typed::string($array, 'first.second','default value');
```

## 3. Supported types

Static methods for the following types are present:

* `string`
* `int`
* `float`
* `bool`
* `array`
* `object`
* `dateTime`
* `any` (allows to use short dot-keys usage for unknowns)

Additionally:

* `boolExtended` (`true`,`1`,`"1"`, `"on"` are treated as true, `false`,`0`,`"0"`, `"off"` as false)
* `stringExtended` (supports objects with `__toString`)

> Plus, for optional cases, each item has an `OrNull` method option (e.g. `stringOrNull`, `intOrNull`, and so on), which returns `null` if the key
doesn’t exist.

## 4. How It Works

The logic of all casting methods follows this simple principle:

> “Provide me a value of the requested type from the given source by the given path, or return the default value.”

For example, let's review the `string` method declaration:

```php
namespace WPLake\Typed;

class Typed {
public static function string($source, $key = null, string $default = ''): string;
// ...
}
```

Usage Scenarios:

1. Extract a string from a mixed variable (returning the default if absent or of an incompatible type)

```php
$userName = Typed::string($unknownVar);
```

2. Retrieve a string from an array, including nested structures using dot notation (e.g., `some.key.subkey`).

```php
$userName = Typed::string($array, 'user.name');
```

3. Access a string from an object, supporting nested properties with dot notation (e.g., `some.key.subkey`).

```php
$userName = Typed::string($companyObject, 'user.name');
```

4. Work with mixed structures (e.g., `object->arrayProperty['key']->anotherProperty or ['key' => $object]`).

```php
$userName = Typed::string($companyObject,'users.john.name');
```

In all the cases, you can pass a default value as the third argument, e.g.:

```php
$userName = Typed::string($companyObject,'users.john.name', 'Guest');
```

## 5. FAQ

### 5.1) Why not just Null Coalescing Operator?

While the Null Coalescing Operator (`??`) is useful, it doesn’t address type checking or casting requirements.

```php
// Plain PHP:
$number = $data['meta']['number']?? 10;
$number = true === is_numeric($number)?
(int)$number:
10;

// Typed:
$number = Typed::int($data, 'meta.number', 10);
```

Additionally, with Null Coalescing Operator and a custom default value, you have to repeat yourself.

### 5.2) Shouldn't we use typed objects instead?

OOP is indeed powerful, and you should always prioritize using objects whenever possible. However, the reality is that
our code often interacts with external dependencies beyond our control.

This package simplifies handling such scenarios.
Any seasoned PHP developer knows the pain of type-casting when working with environments outside of frameworks like
WordPress.

### 5.3) Is the dot syntax in keys inspired by Laravel Collections?

Yes, the dot syntax is inspired by [Laravel Collections](https://laravel.com/docs/11.x/collections) and similar
solutions. It provides an intuitive way to access
nested data structures.

### 5.4) Why not just use Laravel Collections?

Laravel Collections and similar libraries don’t offer type-specific methods like this package does.

While extending
[Laravel Collections package](https://github.com/illuminate/collections) could be a theoretical solution, we opted for a
standalone package because:

1. **PHP Version Requirements:** Laravel Collections require PHP 8.2+, while Typed supports PHP 7.4+.
2. **Dependencies:** Laravel Collections bring several external Laravel-specific dependencies.
3. **Global Functions:** Laravel Collections rely on global helper functions, which are difficult to scope when needed.

In addition, when we only need to extract a single variable, requiring the entire array to be wrapped in a collection
would be excessive.

## 6. Contribution

We would be excited if you decide to contribute 🤝

Please open Pull Requests against the `main` branch.

### Code Style Agreements:

#### 6.1) PSR-12 Compliance

Use the [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) tool in your IDE with the provided `phpcs.xml`,
or run `composer phpcbf` to format your code.

#### 6.2) Static Analysis with PHPStan

Set up [PHPStan](https://phpstan.org/) in your IDE with the provided `phpstan.neon`, or run `composer phpstan` to
validate your code.

#### 6.3) Unit Tests

[Pest](https://pestphp.com/) is setup for Unit tests. Run them using `composer pest`.