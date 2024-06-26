<?php

require_once '/app/src/RPNCalculator.php';

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass('RPNCalculator')]
final class RPNCalculatorTest extends TestCase
{
    private RPNCalculator $calculator;

    /**
     * @throws Exception
     */
    public function testAddition()
    {
        $result = $this->calculator->calculate('2 3 +');
        $this->assertEquals(5, $result);
    }

    /**
     * @throws Exception
     */
    public function testSubtraction()
    {
        $result = $this->calculator->calculate('5 3 -');
        $this->assertEquals(2, $result);
    }

    /**
     * @throws Exception
     */
    public function testMultiplication()
    {
        $result = $this->calculator->calculate('2 3 *');
        $this->assertEquals(6, $result);
    }

    /**
     * @throws Exception
     */
    public function testDivision()
    {
        $result = $this->calculator->calculate('6 3 /');
        $this->assertEquals(2, $result);
    }

    public function testDivisionByZero()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Division by zero error');

        $this->calculator->calculate('6 0 /');
    }

    /**
     * @throws Exception
     */
    public function testSquareRoot()
    {
        $result = $this->calculator->calculate('9 SQRT');
        $this->assertEquals(3, $result);
    }

    /**
     * @throws Exception
     */
    public function testMax()
    {
        $result = $this->calculator->calculate('2 3 MAX');
        $this->assertEquals(3, $result);
    }

    protected function setUp(): void
    {
        $this->calculator = new RPNCalculator();
    }

    public function testInvalidRPNExpression()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid RPN expression');

        $this->calculator->calculate('2 3');
    }

    public function testNotEnoughOperandsForOperation()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Not enough operands for operation +');

        $this->calculator->calculate('2 +');
    }

    public function testNotEnoughOperandsForOperationMAX()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Not enough operands for operation MAX');

        $this->calculator->calculate('MAX');
    }

    public function testInvalidOperation()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid operation');

        $this->calculator->calculate('2 3 INVALID');
    }

    public function testInvalidOperation2()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid operation');

        $this->calculator->calculate('2 3 4 INVALID');
    }

}