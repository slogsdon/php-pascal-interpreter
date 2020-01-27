<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

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

        return false === strpos((string) $node->value, '.')
            ? $this->visitAsInt($node)
            : $this->visitAsFloat($node);
    }

    protected function visitAsFloat(Number $node): float
    {
        return floatval((string) $node->value);
    }

    protected function visitAsInt(Number $node): int
    {
        return intval((string) $node->value);
    }
}
