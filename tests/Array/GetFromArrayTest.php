<?php

use WPLake\Typed\Typed;

it('works with an array', function () {
    $result = Typed::any(['key' => 'value'], 'key', 'default');

    expect($result)->toBe('value');
});

it('returns the default value for a missing key in an array', function () {
    $data = ['key' => 'value'];

    $result = Typed::any($data, 'missing', 'default');

    expect($result)->toBe('default');
});

it('works with an array and inner keys when passed as a string', function () {
    $data = ['level1' => ['level2' => ['key' => 'value']]];

    $result = Typed::any($data, 'level1.level2.key', 'default');

    expect($result)->toBe('value');
});

it('works with an array and inner keys when passed as an array', function () {
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
