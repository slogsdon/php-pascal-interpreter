<?php

declare(strict_types=1);

namespace Pascal\Interpreter\Visitor;

use Pascal\Interpreter\Interpreter;
use Pascal\Parser\Node;

abstract class Visitor
{
    public const CLASS_PATTERN = 'Pascal\\Interpreter\\Visitor\\%sVisitor';

    protected Interpreter $interpreter;

    public function __construct(Interpreter $interpreter)
    {
        $this->interpreter = $interpreter;
    }

    /**
     * @return mixed
     */
    abstract public function visit(Node $node);
}
