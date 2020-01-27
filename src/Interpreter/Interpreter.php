<?php

declare(strict_types=1);

namespace Pascal\Interpreter;

use Exception;
use Pascal\Interpreter\Visitor\Visitor;
use Pascal\Lexer\Lexer;
use Pascal\Parser\{Node, Parser};

class Interpreter
{
    /**
     * @return mixed
     */
    public function interpret(string $text)
    {
        $tokens = (new Lexer($text))->getTokens();
        $tree = (new Parser($tokens))->parse();
        return $this->visit($tree);
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
}
