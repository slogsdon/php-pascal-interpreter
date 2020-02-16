<?php

declare(strict_types=1);

namespace Pascal\Visitor;

use Pascal\Parser\AST\{Node, VariableDeclaration};
use Exception;
use Pascal\SymbolTable\VariableSymbol;

class VariableDeclarationVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (null === $this->symbolTable) {
            return;
        }

        if (!($node instanceof VariableDeclaration)) {
            throw new Exception();
        }

        $typeName = (string) $node->type->value;
        $typeSymbol = $this->symbolTable->lookup($typeName);

        if (null === $typeSymbol) {
            throw new Exception(sprintf('Unknown type: %s', $typeName));
        }

        $varName = (string) $node->var->value;
        $this->symbolTable->define(new VariableSymbol($varName, $typeSymbol));

        return;
    }
}
