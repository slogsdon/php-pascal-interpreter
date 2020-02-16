<?php

declare(strict_types=1);

namespace Pascal\SemanticAnalyzer;

abstract class Symbol
{
    public string $name;
    public ?Symbol $type;

    public function __construct(string $name, Symbol $type = null)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function __toString()
    {
        return sprintf('<%s:%s>', $this->name, $this->type !== null ? (string) $this->type : '(none)');
    }
}
