<?php

use function WPLake\Typed\setItem;

it('sets to dynamic object property when array keys are valid', function () {
    $target = new stdClass();
    $target->first = new stdClass();
    $target->first->second = new stdClass();

    $isSet = setItem($target, ['first', 'second', 'third'], 'value');

    expect($isSet)->toBeTrue();
    expect($target)->toHaveProperties([
        'first'
    ]);
    expect($target->first)->toHaveProperties([
        'second'
    ]);
    expect($target->first->second)->toHaveProperties([
        'third'
    ]);
    expect($target->first->second->third)->toBe(
        'value'
    );
});

it('sets to dynamic object property when string keys are valid', function () {
    $target = new stdClass();
    $target->first = new stdClass();
    $target->first->second = new stdClass();

    $isSet = setItem($target, 'first.second.third', 'value');

    expect($isSet)->toBeTrue();
    expect($target)->toHaveProperties([
        'first'
    ]);
    expect($target->first)->toHaveProperties([
        'second'
    ]);
    expect($target->first->second)->toHaveProperties([
        'third'
    ]);
    expect($target->first->second->third)->toBe(
        'value'
    );
});

it('skips set to dynamic object property when target is not an object', function () {
    $target = 'string';

    $isSet = setItem($target, 'first.second.third', 'value');

    expect($isSet)->toBeFalse();
    expect($target)->toBe('string');
});

it('skips set to dynamic object property when array keys are invalid', function () {
    $target = new stdClass();
    $target->first = new stdClass();
    $target->first->second = new stdClass();

    $isSet = setItem($target, ['first', 'another', 'third'], 'value');

    expect($isSet)->toBeFalse();
    expect($target)->toHaveProperties([
        'first'
    ]);
    expect($target->first)->toHaveProperties([
        'second'
    ]);
    expect($target->first->second)->toHaveProperties([]);
});

it('skips set to dynamic object property when string keys are invalid', function () {
    $target = new stdClass();
    $target->first = new stdClass();
    $target->first->second = new stdClass();

    $isSet = setItem($target, 'first.another.third', 'value');

    expect($isSet)->toBeFalse();
    expect($target)->toHaveProperties([
        'first'
    ]);
    expect($target->first)->toHaveProperties([
        'second'
    ]);
    expect($target->first->second)->toHaveProperties([]);
});
