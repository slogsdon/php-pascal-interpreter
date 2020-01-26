<?php

declare(strict_types=1);

require 'vendor/autoload.php';

print (new Pascal\Interpreter('12 + 2'))->expr() . PHP_EOL;
print (new Pascal\Interpreter('12 - 2'))->expr() . PHP_EOL;
