<?php

use WPLake\Typed\Typed;

it('works with mixed structures when passed as string', function (): void {
    $object = new stdClass();
    $object->property = new stdClass();
    $object->property->values = [
        'arrayKey' => [
            'innerObject' => new stdClass()
        ]
    ];
    $object->property->values['arrayKey']['innerObject']->property = 'value';

    $result = Typed::any($object, 'property.values.arrayKey.innerObject.property', 'default');

    expect($result)->toBe('value');
});

it('works with mixed structures when passed as array', function (): void {
    $object = new stdClass();
    $object->property = new stdClass();
    $object->property->values = [
        'arrayKey' => [
            'innerObject' => new stdClass()
        ]
    ];
    $object->property->values['arrayKey']['innerObject']->property = 'value';

    $result = Typed::any($object, ['property','values','arrayKey','innerObject','property'], 'default');

    expect($result)->toBe('value');
});

it('returns default for missing key in mixed structures when passed as string', function (): void {
    $object = new stdClass();
    $object->property = new stdClass();
    $object->property->values = [
        'arrayKey' => [
            'innerObject' => new stdClass()
        ]
    ];

    $result = Typed::any($object, 'property.values.arrayKey.innerObject.missing', 'default');

    expect($result)->toBe('default');
});

it('returns default for missing key in mixed structures when passed as array', function (): void {
    $object = new stdClass();
    $object->property = new stdClass();
    $object->property->values = [
        'arrayKey' => [
            'innerObject' => new stdClass()
        ]
    ];

    $result = Typed::any($object, ['property','values','arrayKey','innerObject','missing'], 'default');

    expect($result)->toBe('default');
});
