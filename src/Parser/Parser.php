<?php

declare(strict_types=1);

namespace Pascal\Parser;

use Exception;
use Pascal\Lexer\{Token, TokenType};
use Pascal\Parser\AST\{Assignment, BinaryOperation, Compound, Node, NoOperation, Number, Variable};

class Parser
{
    protected int $position = 0;

    /**
     * @var Token[]
     */
    protected array $tokens;

    /**
     * @var Token|null
     */
    protected ?Token $currentToken = null;

    /**
     * @param Token[] $tokens
     */
    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
        $this->currentToken = $this->getNextToken();
    }

    public function getNextToken(): ?Token
    {
        if (!isset($this->tokens[$this->position])) {
            return null;
        }

        return $this->currentToken = $this->tokens[$this->position++];
    }

    public function factor(): Node
    {
        $token = $this->currentToken;

        if (null === $token) {
            throw new Exception('Missing expected token');
        }

        switch ($token->type) {
            case TokenType::INTEGER:
                $this->eat(TokenType::INTEGER);
                return new Number($token);
            case TokenType::OPEN_PAREN:
                $this->eat(TokenType::OPEN_PAREN);
                $node = $this->expr();
                $this->eat(TokenType::CLOSE_PAREN);
                return $node;
            case TokenType::OPERATOR:
                if ('+' === $token->value) {
                    $this->eat(TokenType::OPERATOR);
                    return new BinaryOperation(
                        new Number(new Token(TokenType::INTEGER, '0')),
                        $token,
                        $this->factor()
                    );
                } else {
                    $this->eat(TokenType::OPERATOR);
                    return new BinaryOperation(
                        new Number(new Token(TokenType::INTEGER, '0')),
                        $token,
                        $this->factor()
                    );
                }
            default:
                return $this->variable();
        }
    }

    public function term(): Node
    {
        $node = $this->factor();

        while (
            null !== $this->currentToken &&
            TokenType::OPERATOR === $this->currentToken->type &&
            in_array($this->currentToken->value, ['*', '/'])
        ) {
            $token = $this->currentToken;
            $this->eat(TokenType::OPERATOR);
            $node = new BinaryOperation($node, $token, $this->factor());
        }

        return $node;
    }

    public function expr(): Node
    {
        $node = $this->term();

        while (
            null !== $this->currentToken &&
            TokenType::OPERATOR === $this->currentToken->type &&
            in_array($this->currentToken->value, ['+', '-'])
        ) {
            $token = $this->currentToken;
            $this->eat(TokenType::OPERATOR);
            $node = new BinaryOperation($node, $token, $this->term());
        }

        return $node;
    }

    public function parse(): Node
    {
        $node = $this->program();

        if (null !== $this->currentToken && TokenType::EOF !== $this->currentToken->type) {
            throw new Exception('Unexpected end');
        }

        return $node;
    }

    public function program(): Node
    {
        $node = $this->compoundStatement();
        $this->eat(TokenType::DOT);
        return $node;
    }

    public function compoundStatement(): Node
    {
        $this->eat(TokenType::BEGIN);
        $nodes = $this->statementList();
        $this->eat(TokenType::END);
        $root = new Compound($nodes);
        return $root;
    }

    /**
     * @return Node[]
     */
    public function statementList(): array
    {
        $node = $this->statement();
        $results = [$node];

        while (null !== $this->currentToken && TokenType::END_STATEMENT === $this->currentToken->type) {
            $this->eat(TokenType::END_STATEMENT);
            $results[] = $this->statement();
        }

        if (null !== $this->currentToken && TokenType::ID === $this->currentToken->type) {
            throw new Exception();
        }

        return $results;
    }

    public function statement(): Node
    {
        $node = $this->empty();

        if (null === $this->currentToken) {
            return $node;
        }

        if (TokenType::BEGIN === $this->currentToken->type) {
            $node = $this->compoundStatement();
        } elseif (TokenType::ID === $this->currentToken->type) {
            $node = $this->assignmentStatement();
        }

        return $node;
    }

    public function assignmentStatement(): Node
    {
        if (null === $this->currentToken) {
            throw new Exception('Missing expected token');
        }

        $left = $this->variable();
        $token = $this->currentToken;
        $this->eat(TokenType::ASSIGNMENT);
        $right = $this->expr();
        return new Assignment($left, $token, $right);
    }

    public function variable(): Node
    {
        if (null === $this->currentToken) {
            throw new Exception('Missing expected token');
        }

        $node = new Variable($this->currentToken);
        $this->eat(TokenType::ID);
        return $node;
    }

    public function empty(): Node
    {
        return new NoOperation();
    }

    protected function eat(string $type): void
    {
        if (null !== $this->currentToken && $this->currentToken->type !== $type) {
            throw new Exception(sprintf(
                'Unexpected current token type. Expected %s but found %s',
                $type,
                $this->currentToken->type
            ));
        }

        $this->getNextToken();
    }
}
