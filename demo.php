<?php

declare(strict_types=1);

use Pascal\Interpreter;

require 'vendor/autoload.php';

$interpreter = new Interpreter();
print $interpreter->evaluate('12 + 2') . PHP_EOL;
print $interpreter->evaluate('12 - 2') . PHP_EOL;
print $interpreter->evaluate('12 + 2 + 2') . PHP_EOL;
print $interpreter->evaluate('12 - 2 - 2') . PHP_EOL;
print $interpreter->evaluate('12 + 2 - 2') . PHP_EOL;
print $interpreter->evaluate('12 - 2 + 2') . PHP_EOL;
print $interpreter->evaluate('12 - 2 * 2') . PHP_EOL;
