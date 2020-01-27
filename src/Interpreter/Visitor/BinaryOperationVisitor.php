<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Parser\AST\{BinaryOperation, Node};
use Exception;

class BinaryOperationVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (!($node instanceof BinaryOperation)) {
            throw new Exception();
        }

        switch ($node->op->value) {
            case '+':
                return $this->visitAsFloat($node->left) + $this->visitAsFloat($node->right);
            case '-':
                return $this->visitAsFloat($node->left) - $this->visitAsFloat($node->right);
            case '*':
                return $this->visitAsFloat($node->left) * $this->visitAsFloat($node->right);
            case '/':
                return $this->visitAsFloat($node->left) / $this->visitAsFloat($node->right);
        }
    }

    protected function visitAsFloat(Node $node): float
    {
        return floatval($this->interpreter->visit($node));
    }
}
