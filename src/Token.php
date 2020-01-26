<?php

declare(strict_types=1);

namespace Pascal;

class Token
{
    /**
     * @var string
     */
    public string $type;

    /**
     * @var mixed
     */
    public $value;

    /**
     * @param string $type
     * @param mixed $value
     */
    public function __construct(string $type, $value = null)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * String representation of the class instance.
     *
     * Examples:
     *      Token(INTEGER, 3)
     *      Token(PLUS '+')
     */
    public function __toString(): string
    {
        return sprintf('Token(%s, %s)', $this->type, (string) $this->value);
    }
}
