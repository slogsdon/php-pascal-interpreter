<?php

declare(strict_types=1);

namespace Pascal\Parser;

use Exception;
use Pascal\Lexer\{Token, TokenType};
use Pascal\Parser\AST\{BinaryOperation, Node, Number};

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
            throw new Exception("Unreachable: no token present");
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
            default:
                throw new Exception('Unexpected form');
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
        return $this->expr();
    }

    public function eat(string $type): void
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
