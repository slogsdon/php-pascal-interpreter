<?php

declare(strict_types=1);

namespace Pascal\Parser;

use Pascal\Lexer\Token;

class Number extends Node
{
    public Token $token;
    /** @var mixed */
    public $value;

    public function __construct(Token $token)
    {
        $this->token = $token;
        $this->value = $token->value;
    }
}
