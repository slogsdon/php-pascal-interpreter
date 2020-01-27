<?php

declare(strict_types=1);

namespace Pascal\Tests\Integration;

use Pascal\Interpreter\Interpreter;

class ArithmeticTest extends \PHPUnit\Framework\TestCase
{
    protected Interpreter $interpreter;

    public function setUp(): void
    {
        $this->interpreter = new Interpreter();
    }

    public function testSimpleTerms()
    {
        $this->assertEquals('2', $this->interpreter->interpret('2'));
    }

    public function testAdditionSubtraction()
    {
        $this->assertEquals('14', $this->interpreter->interpret('12 + 2'));
        $this->assertEquals('10', $this->interpreter->interpret('12 - 2'));
        $this->assertEquals('16', $this->interpreter->interpret('12 + 2 + 2'));
        $this->assertEquals('8', $this->interpreter->interpret('12 - 2 - 2'));
        $this->assertEquals('12', $this->interpreter->interpret('12 + 2 - 2'));
        $this->assertEquals('12', $this->interpreter->interpret('12 - 2 + 2'));
    }

    public function testOrderOfOperations()
    {
        $this->assertEquals('8', $this->interpreter->interpret('12 - 2 * 2'));
        $this->assertEquals('20', $this->interpreter->interpret('(12 - 2) * 2'));
    }
}
