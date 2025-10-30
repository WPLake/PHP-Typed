<?php

use WPLake\Typed\Typed;

it('works with a string array key', function () {
    $result = Typed::any(['key' => 'value'], 'key', 'default');

    expect($result)->toBe('value');
});

it('works with a numeric array key', function () {
    $result = Typed::any([1 => 'value'], 1, 'default');

    expect($result)->toBe('value');
});

it('returns the default value for a missing key in an array', function () {
    $data = ['key' => 'value'];

    $result = Typed::any($data, 'missing', 'default');

    expect($result)->toBe('default');
});

it('works with inner keys when passed as a string', function () {
    $data = ['level1' => ['level2' => ['key' => 'value']]];

    $result = Typed::any($data, 'level1.level2.key', 'default');

    expect($result)->toBe('value');
});

it('works with inner keys when passed as a mixed string-numeric path', function () {
    $data = ['level1' => [ ['key' => 'value']]];

    $result = Typed::any($data, 'level1.0.key', 'default');

    expect($result)->toBe('value');
});

it('works with inner keys when passed as an array', function () {
    $data = ['level1' => ['level2' => ['key' => 'value']]];

    $result = Typed::any($data, ['level1', 'level2', 'key'], 'default');

    expect($result)->toBe('value');
});

it('returns the default value for a missing inner key in an array when passed as a string', function () {
    $data = ['level1' => ['level2' => []]];

    $result = Typed::any($data, 'level1.level2.missing', 'default');

    expect($result)->toBe('default');
});

it('returns the default value for a missing inner key in an array when passed as an array', function () {
    $data = ['level1' => ['level2' => []]];

    $result = Typed::any($data, ['level1', 'level2', 'missing'], 'default');

    expect($result)->toBe('default');
});
