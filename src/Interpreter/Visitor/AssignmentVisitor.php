<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Parser\AST\{Assignment, Node, Variable};
use Exception;

class AssignmentVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (!($node instanceof Assignment)) {
            throw new Exception();
        }

        $var = $node->left;

        if (!($var instanceof Variable)) {
            throw new Exception('Cannot assign to non-variable');
        }

        return $this->interpreter->set((string) $var->value, $this->interpreter->visit($node->right));
    }
}
