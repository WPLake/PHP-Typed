<?php

use WPLake\Typed\Typed;

it('works with object with typed properties', function () {
    $object = new class {
        public string $key = 'value';
    };

    $result = Typed::any($object, 'key', 'default');

    expect($result)->toBe('value');
});

it('returns default for missing key in object with typed properties', function () {
    $object = new class {
        public ?string $key = null;
    };

    $result = Typed::any($object, 'key', 'default');

    expect($result)->toBe('default');
});

it('works with object with typed inner properties when passed as string', function () {
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

    expect($result)->toBe('value');
});

it('works with object with typed inner properties when passed as array', function () {
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

    $result = Typed::any($object, ['level1', 'level2', 'key'], 'default');

    expect($result)->toBe('value');
});

it('returns default for missing typed inner properties in object when passed as string', function () {
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

    expect($result)->toBe('default');
});

it('returns default for missing typed inner properties in object when passed as array', function () {
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

    $result = Typed::any($object, ['level1', 'level2', 'key'], 'default');

    expect($result)->toBe('default');
});
