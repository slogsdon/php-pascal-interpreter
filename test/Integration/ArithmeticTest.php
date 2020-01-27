<?php

declare(strict_types=1);

namespace Pascal\Tests\Integration;

use Pascal\Interpreter\Interpreter;

class ArithmeticTest extends \PHPUnit\Framework\TestCase
{
    protected ?Interpreter $interpreter = null;

    public function setUp(): void
    {
        $this->interpreter = new Interpreter();
    }

    public function testSimpleTerms(): void
    {
        // $this->assertEquals('2', $this->interpreter->interpret('BEGIN 2; END.'));
    }

    public function testAdditionSubtraction(): void
    {
        // $this->assertEquals('14', $this->interpreter->interpret('BEGIN 12 + 2; END.'));
        // $this->assertEquals('10', $this->interpreter->interpret('BEGIN 12 - 2; END.'));
        // $this->assertEquals('16', $this->interpreter->interpret('BEGIN 12 + 2 + 2; END.'));
        // $this->assertEquals('8', $this->interpreter->interpret('BEGIN 12 - 2 - 2; END.'));
        // $this->assertEquals('12', $this->interpreter->interpret('BEGIN 12 + 2 - 2; END.'));
        // $this->assertEquals('12', $this->interpreter->interpret('BEGIN 12 - 2 + 2; END.'));
    }

    public function testOrderOfOperations(): void
    {
        // $this->assertEquals('8', $this->interpreter->interpret('BEGIN 12 - 2 * 2; END.'));
        // $this->assertEquals('20', $this->interpreter->interpret('BEGIN (12 - 2) * 2; END.'));
    }
}
