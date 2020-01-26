<?php

declare(strict_types=1);

namespace Pascal;

class Interpreter
{
    public function evaluate(string $text): float
    {
        $tokens = (new Lexer($text))->getTokens();
        return (new Parser($tokens))->expr();
    }
}
