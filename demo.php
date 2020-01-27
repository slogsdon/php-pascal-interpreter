<?php

declare(strict_types=1);

use Pascal\Interpreter\Interpreter;

require 'vendor/autoload.php';

$text = <<<TEXT
BEGIN

    BEGIN
        number := 2;
        a := number;
        b := 10 * a + 10 * number / 4;
        c := a - - b
    END;

    x := 11;
END.
TEXT;
(new Interpreter())->interpret($text);
