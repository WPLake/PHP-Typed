# PHP Typed

> `Typed` is a lightweight PHP utility for seamless type-casting and item manipulations, perfect for dynamic variables,
> arrays, and objects.

This package provides a single `Typed` class with static methods and offers compatibility with PHP versions `7.4+` and
`8.0+`.

## 1. Why Use Typed?

Handling type casting in PHP often leads to verbose and repetitive constructions, especially in array-related cases.

`Typed` streamlines this process,
allowing you to fetch and cast values with concise, readable code.

**Example: Plain PHP**

```php
function getUserAge(array $userData): int
{
    return isset($userData['meta']['age']) &&
           is_numeric($userData['meta']['age'])
           ? (int) $userData['meta']['age']
           : 0;
}

function upgradeUserById($mixedUserId): void
{
    $userId = is_string($mixedUserId) || 
    is_numeric($mixedUserId)
        ? (string) $mixedUserId
        : '';
}

function setUserEducation(array $user, string $education): array
{
  // such long chain is the only safe way passing PHPStan checks.
  if(key_exists('data', $userData) && 
  is_array($userData['data']) &&
  key_exists('bio', $userData['data']) && 
  is_array($userData['data']['bio'])) {
    $userData['data']['bio']['education'] = $education;
  }
  
  return $userData;
}
```

**The same with the `Typed` utility**

```php
use function WPLake\Typed\int;
use function WPLake\Typed\string;

function getUserAge(array $userData): int
{
    return int($userData, 'meta.age');
}

function upgradeUserById($mixedUserId): void
{
    $userId = string($mixedUserId);
}

function setUserEducation(array $userData, string $education): array
{
  // will set only if 'data' and 'bio' keys are present.
  $isSet = setItem($userData, 'data.bio.education', $education);
  
  return $userData;
}
```

The code like `string($array, 'key')` resembles `(string)$array['key']` while being
safe and smart — it even handles nested keys and default values.

> In case now you're thinking: "Hold on guys, but this code won't work! Are your using type names as function names?"
>
> Our answer is: "Yes! And actually it isn't prohibited."
>
> See the explanation in the special section - [5. Note about the function names](#5-note-about-the-function-names)

Backing to the package. Want to provide a default value when the key is missing? Here you go:

```php
string($data, 'some.key', 'Default Value');
```

Can't stand functions? The same functions set is available as static methods of the `Typed` class:

```php
use WPLake\Typed\Typed;

Typed::int($data,'key');
```

## 2. Installation and usage

Typed class is distributed as a Composer package, making installation straightforward:

`composer require wplake/typed`

After installation, ensure that your application includes the Composer autoloader (if it hasn’t been included already):

`require __DIR__ . '/vendor/autoload.php';`

### 2.1) Retrieval usage:

```php
use function WPLake\Typed\string;
use WPLake\Typed\Typed;

$string = string($array, 'first.second');
// alternatively, array of keys:
$string = string($array, ['first', 'second',]);
// alternatively, static method:
$string = Typed::string($array, 'first.second');
// custom fallback:
$string = string($array, 'first.second', 'custom default');
```

### 2.2) Setting item usage:

```php
use function WPLake\Typed\setItem;
use WPLake\Typed\Typed;

function myFunction(array $unknownKeys): void {
    // will set only if 'first' and 'second' keys exist.
    $isSet = setItem($unknownKeys, 'first.second.third', 'value');
    // alternatively, array of keys
    $isSet = Typed::setItem($unknownKeys, ['first', 'second', 'third',], 'value');
    // alternatively, static method
    $isSet = Typed::setItem($unknownKeys, 'first.second.third', 'value');
    
    return $array;
}

$array = [
 'first' => [
      // ...
    'second' => [
        
    ],
 ],
];

myFunction($array);

```

## 3. How Retrieval Functions Work

The logic of all casting methods follows this simple principle:

> “Provide me a value of the requested type from the given source by the given path, or return the default value.”

For example, let's review the `string` method declaration:

```php
namespace WPLake\Typed;

/**
 * @param mixed $source
 * @param int|string|array<int,int|string>|null $keys
 */
function string($source, $keys = null, string $default = ''): string;
```

Usage Scenarios:

**1. Extract a string from a mixed variable**

By default, returning an empty string if the variable can't be converted to a string:

```php
$userName = string($unknownVar);
// you can customize the fallback:
$userName = string($unknownVar, null, 'custom fallback value');
```

**2. Retrieve a string from an array**

Including nested structures (with dot notation or as an array):

```php
$userName = string($array, 'user.name');
// alternatively:
$userName = string($array, ['user','name',]);
// custom fallback:
$userName = string($array, 'user.name', 'Guest');
```

**3. Access a string from an object**

Including nested properties:

```php
$userName = string($companyObject, 'user.name');
// alternatively:
$userName = string($companyObject, ['user', 'name',]);
// custom fallback:
$userName = string($companyObject, 'user.name', 'Guest');
```

**4. Work with mixed structures**

(e.g., `object->arrayProperty['key']->anotherProperty` or `['key' => $object]`)

```php
$userName = string($companyObject,'users.john.name');
// alternatively:
$userName = string($companyObject,['users','john','name',]);
// custom fallback:
$userName = string($companyObject, 'users.john.name', 'Guest');
```

In all the cases, the fallback value is the 'empty' value for the specific type (e.g. `0`, `false`, `""`, and so on),
but you
can pass a custom default value as the third argument:

```php
$userName = string($companyObject,'users.john.name', 'Guest');
```

## 4. Supported types

Functions for the following types are present:

* `string`
* `int`
* `float`
* `bool`
* `object`
* `dateTime`
* `arr` (stands for `array`, because it's a keyword)
* `any` (allows to use short dot-keys usage for unknowns)

Additionally:

* `boolExtended` (`true`,`1`,`"1"`, `"on"` are treated as true, `false`,`0`,`"0"`, `"off"` as false)
* `stringExtended` (supports objects with `__toString`)

For optional cases, when you need to apply the logic only when the item is present, each function has an `OrNull`
variation (e.g. `stringOrNull`, `intOrNull`, and so on), which returns `null` if the key doesn’t exist.

## 5. Note about the function names

Surprisingly, PHP allows functions to use the same names as variable types.

Think it’s prohibited? Not quite! While certain names are restricted for classes, interfaces, and traits, function names
are not:

> “These names cannot be used to name a **class, interface, or
> trait
**” - [PHP Manual: Reserved Other Reserved Words](https://www.php.net/manual/en/reserved.other-reserved-words.php)

This means you we can have things like `string($array, 'key')`, which resembles `(string)$array['key']` while being
safer
and smarter — it even handles nested keys.

By the way, importing these functions does not interfere with native type casting in PHP. So, while practically
unnecessary, the following construction will still work:

```php
use function WPLake\Typed\string;

echo (string)string('hello');
```

Note: Unlike all the other types, the `array` keyword falls under
a [different category](https://www.php.net/manual/en/reserved.keywords.php), which also prohibits its usage for function
names. That's why in this case we used the `arr` name instead.

## 6. FAQ

### 6.1) Why not just straight type casting?

Straight type casting in PHP can be unsafe and unpredictable in certain scenarios.

For example, the following code will throw an error if the `$mixed` variable is an object of a class that doesn’t
explicitly implement `__toString`:

```php
class Example {
// ...
}
$mixed = new Example();
// ...
function getName($mixed):void{
 return (string)$mixed;
}
```

Additionally, attempting to cast an array to a string, like `(string)$myArray` will:

1. Produce a PHP Notice: Array to string conversion.
2. Return the string "Array", which is rarely the intended behavior.

This unpredictability can lead to unexpected bugs and unreliable code.

### 6.2) Why not just Null Coalescing Operator?

While the Null Coalescing Operator (`??`) is useful, it doesn’t address type checking or casting requirements.

```php
// Plain PHP:
$number = $data['meta']['number']?? 10;
$number = is_numeric($number)?
(int) $number:
10;

// Typed:
$number = int($data, 'meta.number', 10);
```

Additionally, with Null Coalescing Operator and a custom default value, you have to repeat yourself.

### 6.3) Shouldn't we use typed objects instead?

OOP is indeed powerful, and you should always prioritize using objects whenever possible. However, the reality is that
our code often interacts with external dependencies beyond our control.

This package simplifies handling such scenarios.
Any seasoned PHP developer knows the pain of type-casting when working with environments outside of frameworks, e.g. in
WordPress.

### 6.4) Is the dot syntax in keys inspired by Laravel Helpers?

Yes, the dot syntax is inspired by [Laravel’s Arr::get](https://laravel.com/docs/11.x/helpers) and similar
solutions. It provides an intuitive way to access nested data structures.

### 6.5) Why not just use Laravel Collections?

Laravel Collections and similar libraries don’t offer type-specific methods like this package does.

While extending
[Laravel Collections package](https://github.com/illuminate/collections) could be a theoretical solution, we opted for a
standalone package because:

1. **PHP Version Requirements:** Laravel Collections require PHP 8.2+, while Typed supports PHP 7.4+.
2. **Dependencies:** Laravel Collections bring several external Laravel-specific dependencies.
3. **Global Functions:** Laravel Collections rely on global helper functions, which are difficult to scope when needed.

In addition, when we only need to extract a single variable, requiring the entire array to be wrapped in a collection
would be excessive.

## 7. Contribution

We would be excited if you decide to contribute 🤝

Please open Pull Requests against the `main` branch.

### Code Style Agreements:

#### 7.1) PSR-12 Compliance

Use the [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) tool in your IDE with the provided `phpcs.xml`,
or run `composer phpcbf` to format your code.

#### 7.2) Static Analysis with PHPStan

Set up [PHPStan](https://phpstan.org/) in your IDE with the provided `phpstan.neon`, or run `composer phpstan` to
validate your code.

#### 7.3) Unit Tests

[Pest](https://pestphp.com/) is setup for Unit tests. Run them using `composer pest`.