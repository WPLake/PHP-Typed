<?php

use WPLake\Typed\Typed;

it('works with an object with dynamic properties', function (): void {
    $object = new stdClass();
    $object->key = 'value';

    $result = Typed::any($object, 'key', 'default');

    expect($result)->toBe('value');
});

it('returns default for missing key in object with dynamic properties', function (): void {
    $object = new stdClass();

    $result = Typed::any($object, 'missing', 'default');

    expect($result)->toBe('default');
});

it('works with object with dynamic inner properties when passed as string', function (): void {
    $object = new stdClass();
    $object->level1 = new stdClass();
    $object->level1->level2 = new stdClass();
    $object->level1->level2->key = 'value';

    $result = Typed::any($object, 'level1.level2.key', 'default');

    expect($result)->toBe('value');
});

it('works with object with dynamic inner properties when passed as array', function (): void {
    $object = new stdClass();
    $object->level1 = new stdClass();
    $object->level1->level2 = new stdClass();
    $object->level1->level2->key = 'value';

    $result = Typed::any($object, ['level1', 'level2', 'key'], 'default');

    expect($result)->toBe('value');
});

it('returns default for missing dynamic inner properties in object when passed as string', function (): void {
    $object = new stdClass();
    $object->level1 = new stdClass();
    $object->level1->level2 = new stdClass();

    $result = Typed::any($object, 'level1.level2.missing', 'default');

    expect($result)->toBe('default');
});

it('returns default for missing dynamic inner properties in object when passed as array', function (): void {
    $object = new stdClass();
    $object->level1 = new stdClass();
    $object->level1->level2 = new stdClass();

    $result = Typed::any($object, ['level1', 'level2', 'missing'], 'default');

    expect($result)->toBe('default');
});
