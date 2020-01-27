<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Parser\{Node, Number};
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

        return $node->value;
    }

    protected function visitAsFloat(Node $node): float
    {
        return floatval($this->interpreter->visit($node));
    }
}
