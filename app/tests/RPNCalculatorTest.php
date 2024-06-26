<?php

require_once '/app/src/RPNCalculator.php';

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass('RPNCalculator')]
final class RPNCalculatorTest extends TestCase
{
    private RPNCalculator $calculator;

    /**
     * @throws Exception
     */
    #[TestDox('Addition')]
    public function testAddition()
    {
        $result = $this->calculator->calculate('2 3 +');
        $this->assertEquals(5, $result);
    }

    /**
     * @throws Exception
     */
    #[TestDox('Subtraction')]
    public function testSubtraction()
    {
        $result = $this->calculator->calculate('5 3 -');
        $this->assertEquals(2, $result);
    }

    /**
     * @throws Exception
     */
    #[TestDox('Multiplication')]
    public function testMultiplication()
    {
        $result = $this->calculator->calculate('2 3 *');
        $this->assertEquals(6, $result);
    }

    /**
     * @throws Exception
     */
    #[TestDox('Division')]
    public function testDivision()
    {
        $result = $this->calculator->calculate('6 3 /');
        $this->assertEquals(2, $result);
    }

    #[TestDox('Division by zero launches an exception')]
    public function testDivisionByZero()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Division by zero error');

        $this->calculator->calculate('6 0 /');
    }

    /**
     * @throws Exception
     */
    #[TestDox('Square root')]
    public function testSquareRoot()
    {
        $result = $this->calculator->calculate('9 SQRT');
        $this->assertEquals(3, $result);
    }

    /**
     * @throws Exception
     */
    #[TestDox('Max')]
    public function testMax()
    {
        $result = $this->calculator->calculate('2 3 MAX');
        $this->assertEquals(3, $result);
    }

    #[TestDox('Invalid RPN expression')]
    public function testInvalidRPNExpression()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid RPN expression');

        $this->calculator->calculate('2 3');
    }

    #[TestDox('Not enough operands for operation +')]
    public function testNotEnoughOperandsForOperation()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Not enough operands for operation +');

        $this->calculator->calculate('2 +');
    }

    #[TestDox('Not enough operands for operation MAX')]
    public function testNotEnoughOperandsForOperationMAX()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Not enough operands for operation MAX');

        $this->calculator->calculate('MAX');
    }

    #[TestDox('Invalid operation')]
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

    protected function setUp(): void
    {
        $this->calculator = new RPNCalculator();
    }

}