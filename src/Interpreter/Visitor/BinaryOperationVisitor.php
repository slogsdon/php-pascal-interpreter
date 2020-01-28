<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Parser\AST\{BinaryOperation, Node};
use Exception;
use Pascal\Lexer\TokenType;

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
                return $this->visitAsNodeType($node->left) + $this->visitAsNodeType($node->right);
            case '-':
                return $this->visitAsNodeType($node->left) - $this->visitAsNodeType($node->right);
            case '*':
                return $this->visitAsNodeType($node->left) * $this->visitAsNodeType($node->right);
            case '/':
                return $this->visitAsNodeType($node->left) / $this->visitAsNodeType($node->right);
        }

        switch ($node->op->type) {
            case TokenType::INTEGER_DIV:
                return intval($this->visitAsNodeType($node->left) / $this->visitAsNodeType($node->right));
        }
    }
}
