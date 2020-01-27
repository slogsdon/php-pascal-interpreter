<?php

declare(strict_types=1);

namespace Pascal;

use Pascal\LexicalAnalysis\Lexer;
use Pascal\Parsing\Parser;

class Interpreter
{
    public function evaluate(string $text): float
    {
        $tokens = (new Lexer($text))->getTokens();
        return (new Parser($tokens))->expr();
    }
}
