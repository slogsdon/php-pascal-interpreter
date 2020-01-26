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
    }

    public function getNextToken(): ?Token
    {
        if (!isset($this->tokens[$this->position])) {
            return null;
        }

        return $this->currentToken = $this->tokens[$this->position++];
    }

    public function term(): int
    {
        $token = $this->currentToken;
        $this->eat(TokenType::INTEGER);
        return intval($token->value ?? '');
    }

    public function eat(string $type): void
    {
        if (null === $this->currentToken) {
            return;
        }

        if ($this->currentToken->type !== $type) {
            throw new Exception(sprintf('Unexpected current token type: %s', (string) $this->currentToken));
        }

        $this->currentToken = $this->getNextToken();
    }

    public function expr(): int
    {
        $this->currentToken = $this->getNextToken();

        $result = $this->term();
        while (null !== $this->currentToken && TokenType::OPERATOR === $this->currentToken->type) {
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
                    throw new Exception(sprintf('Unknown operation: %s', $op->value ?? '(missing)'));
            }
        }

        return $result;
    }
}
