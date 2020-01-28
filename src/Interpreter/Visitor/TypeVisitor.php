<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Parser\AST\{Node, Type};
use Exception;

class TypeVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (!($node instanceof Type)) {
            throw new Exception();
        }

        return;
    }
}
