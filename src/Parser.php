<?php

declare(strict_types=1);

namespace Pascal;

use Exception;

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

    public function factor(): int
    {
        $token = $this->currentToken;
        $this->eat(TokenType::INTEGER);
        return intval($token->value ?? '');
    }

    public function term(): float
    {
        $result = $this->factor();

        while (
            null !== $this->currentToken &&
            TokenType::OPERATOR === $this->currentToken->type &&
            in_array($this->currentToken->value, ['*', '/'])
        ) {
            $op = $this->currentToken;
            $this->eat(TokenType::OPERATOR);

            switch ($op->value) {
                case '*':
                    $result *= $this->factor();
                    break;
                case '/':
                    $result /= $this->factor();
                    break;
                default:
                    break;
            }
        }

        return $result;
    }

    public function expr(): float
    {
        $result = $this->term();

        while (
            null !== $this->currentToken &&
            TokenType::OPERATOR === $this->currentToken->type &&
            in_array($this->currentToken->value, ['+', '-'])
        ) {
            $op = $this->currentToken;
            $this->eat(TokenType::OPERATOR);

            switch ($op->value) {
                case '+':
                    $result += $this->term();
                    break;
                case '-':
                    $result -= $this->term();
                    break;
                default:
                    break;
            }
        }

        return $result;
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
