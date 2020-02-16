<?php

declare(strict_types=1);

namespace Pascal\Visitor;

use Pascal\Parser\AST\{Compound, Node};
use Exception;

class CompoundVisitor extends Visitor
{
    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        if (!($node instanceof Compound)) {
            throw new Exception();
        }

        foreach ($node->children as $child) {
            $this->interpreter->visit($child);
        }

        return;
    }
}
