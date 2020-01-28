<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Lexer\TokenType;
use Pascal\Parser\AST\{Node, Number};
use Exception;

class NumberVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (!($node instanceof Number)) {
            throw new Exception();
        }

        return TokenType::INTEGER === $node->token->type
            ? intval($node->value)
            : floatval($node->value);
    }
}
