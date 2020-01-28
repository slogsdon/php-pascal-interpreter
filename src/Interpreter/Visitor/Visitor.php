<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Exception;
use Pascal\Interpreter\Interpreter;
use Pascal\Lexer\TokenType;
use Pascal\Parser\AST\{Node, Number};

abstract class Visitor
{
    public const CLASS_PATTERN = 'Pascal\\Interpreter\\Visitor\\%sVisitor';

    protected Interpreter $interpreter;

    public function __construct(Interpreter $interpreter)
    {
        $this->interpreter = $interpreter;
    }

    /**
     * @return mixed
     */
    abstract public function visit(Node $node);

    /** @return mixed */
    protected function visitAsNodeType(Node $node)
    {
        if (!($node instanceof Number)) {
            return $this->interpreter->visit($node);
        }

        if (in_array($node->token->type, [TokenType::INTEGER, TokenType::INTEGER_CONST])) {
            return $this->visitAsInteger($node);
        }

        return $this->visitAsFloat($node);
    }

    protected function visitAsFloat(Node $node): float
    {
        return floatval($this->interpreter->visit($node));
    }

    protected function visitAsInteger(Node $node): int
    {
        return intval($this->interpreter->visit($node));
    }
}
