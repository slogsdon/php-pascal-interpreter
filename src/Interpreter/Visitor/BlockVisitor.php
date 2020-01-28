<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Parser\AST\{Block, Node};
use Exception;

class BlockVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (!($node instanceof Block)) {
            throw new Exception();
        }

        foreach ($node->declarations as $declaration) {
            $this->interpreter->visit($declaration);
        }

        $this->interpreter->visit($node->compoundStatement);

        return;
    }
}
