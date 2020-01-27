<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Parser\AST\{Node, Variable};
use Exception;

class VariableVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (!($node instanceof Variable)) {
            throw new Exception();
        }

        return $this->interpreter->get((string) $node->value);
    }
}
