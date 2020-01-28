<?php

declare(strict_types=1);

use Pascal\Interpreter\Interpreter;

require 'vendor/autoload.php';

(new Interpreter())->interpret(file_get_contents('demo.pas'));
