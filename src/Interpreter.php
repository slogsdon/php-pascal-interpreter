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

    public ?string $currentChar;

    public function __construct(string $text)
    {
        $this->text = $text;
        $this->currentChar = $this->text[$this->position];
    }

    /**
     * Advance `position`, and set `currentChar`.
     *
     * @return string|null `currentChar`
     */
    public function advance(): ?string
    {
        $this->position++;

        if ($this->position > mb_strlen($this->text) - 1) {
            $this->currentChar = null;
        } else {
            $this->currentChar = $this->text[$this->position];
        }

        return $this->currentChar;
    }

    public function skipWhitespace(): void
    {
        while (null !== $this->currentChar && preg_match('/\s/', $this->currentChar)) {
            $this->advance();
        }
    }

    public function integer(): Token
    {
        $result = $this->currentChar ?? '';

        while (null !== $this->currentChar && preg_match('/[0-9]/', $this->currentChar)) {
            $result .= $this->advance() ?? '';
        }

        return new Token(TokenType::INTEGER, trim($result));
    }

    public function term(): int
    {
        $token = $this->currentToken;
        $this->eat(TokenType::INTEGER);
        return intval($token->value ?? '');
    }

    /**
     * Lexical analyzer (also known as scanner or tokenizer)
     * This method is responsible for breaking a sentence
     * apart into tokens. One token at a time.
     */
    public function getNextToken(): Token
    {
        while (null !== $this->currentChar) {
            if (preg_match('/\s/', $this->currentChar)) {
                $this->skipWhitespace();
                continue;
            }

            if (preg_match('/[0-9]/', $this->currentChar)) {
                $int = $this->integer();
                return $int;
            }

            if ('+' === $this->currentChar) {
                $this->advance();
                return new Token(TokenType::OPERATOR, '+');
            }

            if ('-' === $this->currentChar) {
                $this->advance();
                return new Token(TokenType::OPERATOR, '-');
            }

            throw new Exception(sprintf('Unknown token: %s', (string) $this->currentChar));
        }
        return new Token(TokenType::EOF);
    }

    public function eat(string $type): void
    {
        if (null === $this->currentToken || $this->currentToken->type !== $type) {
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
