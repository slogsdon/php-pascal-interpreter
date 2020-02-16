<?php

declare(strict_types=1);

namespace Pascal\Visitor;

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

        $varName = (string) $node->value;

        if (null === $this->symbolTable) {
            return $this->interpreter->get($varName);
        }

        $varSymbol = $this->symbolTable->lookup($varName);

        if (null === $varSymbol) {
            throw new Exception(sprintf('Variable %s is not defined', $varName));
        }
    }
}
