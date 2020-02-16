<?php

declare(strict_types=1);

namespace Pascal\Visitor;

use Exception;
use Pascal\Parser\AST\{BinaryOperation, Node, Number};
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

        if (null !== $this->symbolTable) {
            $this->visit($node->left);
            $this->visit($node->right);
            return;
        }

        $left = $this->visitAsNodeType($node->left);
        $right = $this->visitAsNodeType($node->right);

        switch ($node->op->value) {
            case '+':
                return $left + $right;
            case '-':
                return $left - $right;
            case '*':
                return $left * $right;
            case '/':
                return $left / $right;
        }

        switch ($node->op->type) {
            case TokenType::INTEGER_DIV:
                return intval($left / $right);
        }
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @return float|int
     */
    protected function visitAsNodeType(Node $node)
    {
        if (!($node instanceof Number)) {
            /** @psalm-suppress MixedReturnStatement */
            return $this->interpreter->visit($node);
        }

        if (in_array($node->token->type, [TokenType::INTEGER, TokenType::INTEGER_CONST])) {
            return $this->visitAsInteger($node);
        }

        return $this->visitAsFloat($node);
    }
}
