<?php

declare(strict_types=1);

namespace Pascal\Visitor;

use Pascal\Interpreter\Interpreter;
use Pascal\Parser\AST\Node;
use Pascal\SymbolTable\SymbolTable;

abstract class Visitor
{
    public const CLASS_PATTERN = 'Pascal\\Visitor\\%sVisitor';

    protected Interpreter $interpreter;
    protected ?SymbolTable $symbolTable;

    public function __construct(Interpreter $interpreter, SymbolTable $symbolTable = null)
    {
        $this->interpreter = $interpreter;
        $this->symbolTable = $symbolTable;
    }

    /**
     * @return mixed
     */
    abstract public function visit(Node $node);

    protected function visitAsFloat(Node $node): float
    {
        return floatval($this->interpreter->visit($node));
    }

    protected function visitAsInteger(Node $node): int
    {
        return intval($this->interpreter->visit($node));
    }
}
