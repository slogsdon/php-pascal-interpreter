<?php

declare(strict_types=1);

namespace Pascal\SemanticAnalyzer;

class BuiltinTypeSymbol extends Symbol
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function __toString()
    {
        return $this->name;
    }
}
