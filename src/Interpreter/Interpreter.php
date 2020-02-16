<?php

declare(strict_types=1);

namespace Pascal\Interpreter;

use Exception;
use Pascal\Visitor\VisitorFactory;
use Pascal\Lexer\Lexer;
use Pascal\Parser\Parser;
use Pascal\Parser\AST\Node;

class Interpreter
{
    protected array $globalScope = [];

    public function interpret(string $text): void
    {
        $tokens = (new Lexer($text))->getTokens();
        $tree = (new Parser($tokens))->parse();
        $this->visit($tree);
        /** @psalm-suppress ForbiddenCode */
        var_dump($this->globalScope);
    }

    /**
     * @return mixed
     */
    public function visit(Node $node)
    {
        return VisitorFactory::forInterpreter($node);
    }

    /**
     * @param mixed $value
     */
    public function set(string $name, $value): void
    {
        $this->globalScope[$name] = $value;
    }

    /**
     * @return mixed
     */
    public function get(string $name)
    {
        if (!isset($this->globalScope[$name])) {
            throw new Exception(sprintf('Undefined variable: %s', $name));
        }

        return $this->globalScope[$name];
    }
}
