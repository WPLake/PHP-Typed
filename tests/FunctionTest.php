<?php

use function WPLake\Typed\string;

// Note: Since all the methods are decorators for the 'any()' method, so we can skip their testing,
// and just make sure functions are loaded.

it('functions are available', function () {
    $array = ['key' => 'value'];
    $result = string($array, 'key');

    expect($result)->toBe('value');
});
