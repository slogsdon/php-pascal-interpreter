<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Parser\AST\{Node, VariableDeclaration};
use Exception;

class VariableDeclarationVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (!($node instanceof VariableDeclaration)) {
            throw new Exception();
        }

        return;
    }
}
