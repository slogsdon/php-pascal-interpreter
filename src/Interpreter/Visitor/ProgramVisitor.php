<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Parser\AST\{Program, Node, Variable};
use Exception;

class ProgramVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (!($node instanceof Program)) {
            throw new Exception();
        }

        $this->interpreter->visit($node->block);

        return;
    }
}
