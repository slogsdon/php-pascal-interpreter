<?php

declare(strict_types=1);

namespace Pascal\Parser\AST;

class VariableDeclaration extends Node
{
    public Node $type;
    public Node $var;

    public function __construct(Node $var, Node $type)
    {
        $this->var = $var;
        $this->type = $type;
    }
}
