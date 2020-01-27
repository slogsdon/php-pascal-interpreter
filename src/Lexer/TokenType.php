<?php

declare(strict_types=1);

namespace Pascal\Lexer;

abstract class TokenType
{
    public const EOF = 'EOF';
    public const INTEGER = 'INTEGER';
    public const OPERATOR = 'OPERATOR';
    public const OPEN_PAREN = 'OPEN_PAREN';
    public const CLOSE_PAREN = 'CLOSE_PAREN';
}
