<?php

declare(strict_types=1);

namespace Pascal;

use Exception;

class Interpreter
{
    /**
     * client string input, e.g. "3+5"
     *
     * @var string
     */
    public string $text;
    /**
     * index into `Interpreter::$text`
     *
     * @var int
     */
    public int $position = 0;
    /**
     * current token instance
     *
     * @var Token|null
     */
    public ?Token $currentToken = null;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * Lexical analyzer (also known as scanner or tokenizer)
     * This method is responsible for breaking a sentence
     * apart into tokens. One token at a time.
     */
    public function getNextToken(): Token
    {
        // position is past last index in text, so nothing
        // is left to be read
        if ($this->position > mb_strlen($this->text) - 1) {
            return new Token(TokenType::EOF);
        }

        $currentChar = $this->text[$this->position];

        if (preg_match('/[0-9]/', $currentChar)) {
            $token = new Token(TokenType::INTEGER, (int) $currentChar);
            $this->position++;
            return $token;
        }

        if ('+' === $currentChar) {
            $token = new Token(TokenType::PLUS, '+');
            $this->position++;
            return $token;
        }

        throw new Exception(sprintf('Unknown token: %s', $currentChar));
    }

    public function eat(string $type)
    {
        if (null === $this->currentToken || $this->currentToken->type !== $type) {
            throw new Exception(sprintf('Unexpected current token type: %s', $this->currentToken));
        }

        $this->currentToken = $this->getNextToken();
    }

    public function expression(): int
    {
        $left = $this->currentToken = $this->getNextToken();
        $this->eat(TokenType::INTEGER);

        $op = $this->currentToken;
        $this->eat(TokenType::PLUS);

        $right = $this->currentToken;
        $this->eat(TokenType::INTEGER);

        switch ($op->value) {
            case '+':
                return $left->value + $right->value;
            default:
                throw new Exception(sprintf('Unknown operation: %s', $op));
        }
    }
}
