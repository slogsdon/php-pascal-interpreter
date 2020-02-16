<?php

declare(strict_types=1);

namespace Pascal\SemanticAnalyzer;

class SymbolTable
{
    /** @var array<string, Symbol> */
    protected array $symbols = [];

    public function __construct()
    {
        $this->initBuiltins();
    }

    public function initBuiltins(): void
    {
        $this->define(new BuiltinTypeSymbol('INTEGER'));
        $this->define(new BuiltinTypeSymbol('REAL'));
    }

    public function define(Symbol $symbol): void
    {
        $this->symbols[$symbol->name] = $symbol;
    }

    public function lookup(string $name): ?Symbol
    {
        return $this->symbols[$name] ?? null;
    }

    public function __toString()
    {
        $values = [];

        foreach ($this->symbols as $value) {
            $values[] = $value;
        }

        return sprintf('Symbols: %s', print_r($values, true));
    }
}
