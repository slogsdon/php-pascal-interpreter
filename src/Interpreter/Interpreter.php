<?php

declare(strict_types=1);

namespace Pascal\Interpreter;

use Exception;
use Pascal\Interpreter\Visitor\Visitor;
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
        $className = get_class($node);
        $classParts = explode('\\', $className);
        $visitorName = sprintf((string) Visitor::CLASS_PATTERN, (string) end($classParts));

        if (!class_exists($visitorName)) {
            throw new Exception(sprintf('Visitor not defined for %s, tried %s', $className, $visitorName));
        }

        /**
         * @var Visitor
         * @psalm-suppress MixedMethodCall
         */
        $visitor = new $visitorName($this);
        return $visitor->visit($node);
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
