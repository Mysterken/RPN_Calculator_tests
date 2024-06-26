<?php

require_once '/app/src/RPNCalculator.php';

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass('RPNCalculator')]
final class RPNCalculatorTest extends TestCase
{
    private RPNCalculator $calculator;

    /**
     * @throws Exception
     */
    #[TestDox('Addition')]
    #[TestWith(['2 3 +', 5])]
    #[TestWith(['5 3 +', 8])]
    #[TestWith(['2 3 4 + +', 9])]
    public function testAddition(string $expression, int $expected)
    {
        $this->calculate($expression, $expected);
    }

    /**
     * @throws Exception
     */
    private function calculate(string $expression, int $expected): void
    {
        $result = $this->calculator->calculate($expression);
        $this->assertEquals($expected, $result);
    }

    /**
     * @throws Exception
     */
    #[TestDox('Subtraction')]
    #[TestWith(['5 3 -', 2])]
    #[TestWith(['5 3 2 - -', 4])]
    #[TestWith(['5 3 2 - +', 6])]
    public function testSubtraction(string $expression, int $expected)
    {
        $this->calculate($expression, $expected);
    }

    /**
     * @throws Exception
     */
    #[TestDox('Multiplication')]
    #[TestWith(['2 3 *', 6])]
    #[TestWith(['5 3 *', 15])]
    #[TestWith(['5 3 2 * *', 30])]
    public function testMultiplication(string $expression, int $expected)
    {
        $this->calculate($expression, $expected);
    }

    /**
     * @throws Exception
     */
    #[TestDox('Division')]
    #[TestWith(['6 3 /', 2])]
    #[TestWith(['6 3 2 / /', 4])]
    #[TestWith(['6 3 2 / *', 9])]
    public function testDivision(string $expression, int $expected)
    {
        $this->calculate($expression, $expected);
    }

    #[TestDox('Division by zero launches an exception')]
    #[TestWith(['6 0 /'])]
    #[TestWith(['6 0 2 / /'])]
    public function testDivisionByZero(string $expression)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Division by zero error');

        $this->calculator->calculate($expression);
    }

    /**
     * @throws Exception
     */
    #[TestDox('Square root')]
    #[TestWith(['9 SQRT', 3])]
    #[TestWith(['16 SQRT', 4])]
    #[TestWith(['25 SQRT', 5])]
    public function testSquareRoot(string $expression, int $expected)
    {
        $this->calculate($expression, $expected);
    }

    /**
     * @throws Exception
     */
    #[TestDox('Max')]
    #[TestWith(['2 3 MAX', 3])]
    #[TestWith(['5 3 MAX', 5])]
    #[TestWith(['5 3 2 MAX MAX', 5])]
    public function testMax(string $expression, int $expected)
    {
        $this->calculate($expression, $expected);
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
    #[TestWith(['2 3 INVALID'])]
    #[TestWith(['2 3 4 INVALID'])]
    public function testInvalidOperation()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid operation');

        $this->calculator->calculate('2 3 INVALID');
    }

    protected function setUp(): void
    {
        $this->calculator = new RPNCalculator();
    }

}