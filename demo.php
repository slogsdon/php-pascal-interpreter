<?php

declare(strict_types=1);

require 'vendor/autoload.php';

print (new Pascal\Interpreter('1+2'))->expression() . PHP_EOL;
