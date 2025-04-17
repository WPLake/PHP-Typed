<?php

use WPLake\Typed\Typed;

it('returns source when key is not set', function () {
    $result = Typed::any('origin');

    expect($result)->toBe('origin');
});

it('returns null when source is not iterable', function () {
    $result = Typed::any('origin', 'key');

    expect($result)->toBeNull();
});

it('returns default when source is not iterable', function () {
    $result = Typed::any('origin', 'key', 'default');

    expect($result)->toBe('default');
});

it('works with mixed keys passed as string', function () {
    $result = Typed::any([
        0 => [
            'key' => [
                '0' => 'value',
            ],
        ],
    ], '0.key.0');

    expect($result)->toBe('value');
});

it('works with mixed keys passed as array', function () {
    $result = Typed::any([
        0 => [
            'key' => [
                '0' => 'value',
            ],
        ],
    ], [0, 'key', '0']);

    expect($result)->toBe('value');
});
