<?php

use function WPLake\Typed\setItem;

it('sets to array when array keys are valid', function () {
    $target = ['first' => [
        'second' => [],
    ]];

    $isSet = setItem($target, ['first', 'second', 'third'], 'value');

    expect($isSet)->toBeTrue();
    expect($target)->toBe([
        'first' => [
            'second' => [
                'third' => 'value'
            ]
        ]
    ]);
});

it('sets to array when string keys are valid', function () {
    $target = ['first' => [
        'second' => [],
    ]];

    $isSet = setItem($target, 'first.second.third', 'value');

    expect($isSet)->toBeTrue();
    expect($target)->toBe([
        'first' => [
            'second' => [
                'third' => 'value'
            ]
        ]
    ]);
});

it('skips set to array when target is not an array', function () {
    $target = 'string';

    $isSet = setItem($target, 'first.second.third', 'value');

    expect($isSet)->toBeFalse();
    expect($target)->toBe('string');
});

it('skips set to array when array keys are invalid', function () {
    $target = ['first' => [
        'second' => [],
    ]];

    $isSet = setItem($target, ['first', 'another', 'third'], 'value');

    expect($isSet)->toBeFalse();
    expect($target)->toBe([
        'first' => [
            'second' => [],
            ]
    ]);
});

it('skips set to array when string keys are invalid', function () {
    $target = ['first' => [
        'second' => [],
    ]];

    $isSet = setItem($target, 'first.another.third', 'value');

    expect($isSet)->toBeFalse();
    expect($target)->toBe([
        'first' => [
            'second' => []
        ]
    ]);
});
