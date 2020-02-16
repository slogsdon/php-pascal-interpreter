<?php

declare(strict_types=1);

namespace Pascal\Visitor;

use Pascal\Parser\AST\{Node, NoOperation};
use Exception;

class NoOperationVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (!($node instanceof NoOperation)) {
            throw new Exception();
        }

        return;
    }
}
