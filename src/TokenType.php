<?php

declare(strict_types=1);

namespace Pascal;

abstract class TokenType
{
    public const EOF = 'EOF';
    public const INTEGER = 'INTEGER';
    public const OPERATOR = 'OPERATOR';
}
