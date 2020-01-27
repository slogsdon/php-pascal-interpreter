<?php

declare(strict_types=1);

namespace Pascal\LexicalAnalysis;

use Exception;

class Lexer
{
    /**
     * client string input, e.g. "3+5"
     *
     * @var string
     */
    protected string $text;

    /**
     * index into `Interpreter::$text`
     *
     * @var int
     */
    protected int $position = 0;

    /**
     * current token instance
     *
     * @var Token|null
     */
    protected ?Token $currentToken = null;

    protected ?string $currentChar;

    public function __construct(string $text)
    {
        $this->text = $text;
        $this->currentChar = $this->text[$this->position];
    }

    /**
     * @return Token[]
     */
    public function getTokens(): array
    {
        $result = [];
        $this->currentToken = $this->getNextToken();

        while (TokenType::EOF !== $this->currentToken->type) {
            $result[] = $this->currentToken;
            $this->currentToken = $this->getNextToken();
        }

        return $result;
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

    /**
     * Return a (multidigit) integer consumed from the input.
     */
    public function integer(): Token
    {
        $result = $this->currentChar ?? '';

        while (null !== $this->currentChar && preg_match('/[0-9]/', $this->currentChar)) {
            $result .= $this->advance() ?? '';
        }

        return new Token(TokenType::INTEGER, trim($result));
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

            if ('*' === $this->currentChar) {
                $this->advance();
                return new Token(TokenType::OPERATOR, '*');
            }

            if ('/' === $this->currentChar) {
                $this->advance();
                return new Token(TokenType::OPERATOR, '/');
            }

            if ('(' === $this->currentChar) {
                $this->advance();
                return new Token(TokenType::OPEN_PAREN, '(');
            }

            if (')' === $this->currentChar) {
                $this->advance();
                return new Token(TokenType::CLOSE_PAREN, ')');
            }

            throw new Exception(sprintf('Unknown token: %s', (string) $this->currentChar));
        }

        return new Token(TokenType::EOF);
    }
}
