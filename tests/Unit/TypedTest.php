<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use stdClass;
use WPLake\Typed\Typed;

class TypedTest extends TestCase
{
    // Note: All the class methods use the 'any()' method, so we can focus solely on it.

    // border cases

    public function testAnyReturnsSourceWhenKeyIsNotSet(): void
    {
        $result = Typed::any('origin');

        $this->assertSame('origin', $result);
    }

    public function testAnyReturnsNullWhenSourceIsNotIterable(): void
    {
        $result = Typed::any('origin', 'key');

        $this->assertNull($result);
    }

    public function testAnyReturnsDefaultWhenSourceIsNotIterable(): void
    {
        $result = Typed::any('origin', 'key', 'default');

        $this->assertSame('default', $result);
    }

    public function testAnyWorksWithMixedKeys(): void
    {
        $result = Typed::any([
            0 => [
                'key' => [
                    '0' => 'value'
                ]
            ],
        ], '0.key.0');

        $this->assertSame('value', $result);
    }

    // arrays

    public function testAnyMethodWorksWithArray(): void
    {
        $result = Typed::any(['key' => 'value'], 'key', 'default');

        $this->assertSame('value', $result);
    }

    public function testAnyMethodReturnsDefaultForMissingKeyInArray(): void
    {
        $data = ['key' => 'value'];

        $result = Typed::any($data, 'missing', 'default');

        $this->assertSame('default', $result);
    }

    public function testAnyMethodWorksWithArrayAndInnerKeys(): void
    {
        $data = ['level1' => ['level2' => ['key' => 'value']]];

        $result = Typed::any($data, 'level1.level2.key', 'default');

        $this->assertSame('value', $result);
    }

    public function testAnyMethodReturnsDefaultForMissingInnerKeyInArray(): void
    {
        $data = ['level1' => ['level2' => []]];

        $result = Typed::any($data, 'level1.level2.missing', 'default');

        $this->assertSame('default', $result);
    }

    // objects with typed properties

    public function testAnyMethodWorksWithObjectWithTypedProperties(): void
    {
        $object = new class {
            public string $key = 'value';
        };

        $result = Typed::any($object, 'key', 'default');

        $this->assertSame('value', $result);
    }

    public function testAnyMethodReturnsDefaultForMissingKeyInObjectWithTypedProperties(): void
    {
        $object = new class {
            public ?string $key = null;
        };

        $result = Typed::any($object, 'key', 'default');

        $this->assertSame('default', $result);
    }

    public function testAnyMethodWorksWithObjectWithTypedInnerProperties(): void
    {
        $object = new class {
            public object $level1;

            public function __construct()
            {
                $this->level1 = new class {
                    public object $level2;

                    public function __construct()
                    {
                        $this->level2 = new class {
                            public string $key = 'value';
                        };
                    }
                };
            }
        };

        $result = Typed::any($object, 'level1.level2.key', 'default');

        $this->assertSame('value', $result);
    }

    public function testAnyMethodReturnsDefaultForMissingTypedInnerPropertiesInObject(): void
    {
        $object = new class {
            public object $level1;

            public function __construct()
            {
                $this->level1 = new class {
                    public object $level2;

                    public function __construct()
                    {
                        $this->level2 = new class {
                            public ?string $key = null;
                        };
                    }
                };
            }
        };

        $result = Typed::any($object, 'level1.level2.key', 'default');

        $this->assertSame('default', $result);
    }

    // objects with dynamic properties

    public function testAnyMethodWorksWithObjectWithDynamicProperties(): void
    {
        $object = new stdClass();
        $object->key = 'value';

        $result = Typed::any($object, 'key', 'default');

        $this->assertSame('value', $result);
    }

    public function testAnyMethodReturnsDefaultForMissingKeyInObjectWithDynamicProperties(): void
    {
        $object = new stdClass();

        $result = Typed::any($object, 'missing', 'default');

        $this->assertSame('default', $result);
    }

    public function testAnyMethodWorksWithObjectWithDynamicInnerProperties(): void
    {
        $object = new stdClass();
        $object->level1 = new stdClass();
        $object->level1->level2 = new stdClass();
        $object->level1->level2->key = 'value';

        $result = Typed::any($object, 'level1.level2.key', 'default');

        $this->assertSame('value', $result);
    }

    public function testAnyMethodReturnsDefaultForMissingDynamicInnerPropertiesInObject(): void
    {
        $object = new stdClass();
        $object->level1 = new stdClass();
        $object->level1->level2 = new stdClass();

        $result = Typed::any($object, 'level1.level2.missing', 'default');

        $this->assertSame('default', $result);
    }

    // mixed cases

    public function testAnyMethodWorksWithMixedStructures(): void
    {
        $object = new stdClass();
        $object->property = new stdClass();
        $object->property->values = [
            'arrayKey' => [
                'innerObject' => new stdClass()
            ]
        ];
        $object->property->values['arrayKey']['innerObject']->property = 'value';

        $result = Typed::any($object, 'property.values.arrayKey.innerObject.property', 'default');

        $this->assertSame('value', $result);
    }

    public function testAnyMethodReturnsDefaultForMissingKeyInMixedStructures(): void
    {
        $object = new stdClass();
        $object->property = new stdClass();
        $object->property->values = [
            'arrayKey' => [
                'innerObject' => new stdClass()
            ]
        ];

        $result = Typed::any($object, 'property.values.arrayKey.innerObject.missing', 'default');

        $this->assertSame('default', $result);
    }
}
