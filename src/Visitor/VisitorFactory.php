<?php

declare(strict_types=1);

namespace Pascal\Visitor;

use Exception;
use Pascal\Parser\AST\Node;

class VisitorFactory
{
    /**
     * @return mixed
     */
    public static function forInterpreter(Node $node)
    {
        return self::visit($node, false);
    }

    /**
     * @return mixed
     */
    public static function forSymbolTable(Node $node)
    {
        return self::visit($node, true);
    }

    /**
     * @return mixed
     */
    public static function visit(Node $node, bool $isSymbolVisitor)
    {
        $visitorName = self::getVistorName($node);

        /**
         * @var Visitor
         * @psalm-suppress InvalidStringClass
         */
        $visitor = new $visitorName($this, $isSymbolVisitor);
        return $visitor->visit($node);
    }

    public static function getVistorName(Node $node): string
    {
        $className = get_class($node);
        $classParts = explode('\\', $className);
        $visitorName = sprintf((string) Visitor::CLASS_PATTERN, (string) end($classParts));

        if (!class_exists($visitorName)) {
            throw new Exception(sprintf('Visitor not defined for %s, tried %s', $className, $visitorName));
        }

        return $visitorName;
    }
}
