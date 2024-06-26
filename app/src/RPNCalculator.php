<?php

class RPNCalculator
{
    private array $stack;

    public function __construct()
    {
        $this->stack = [];
    }

    /**
     * @throws Exception
     */
    public function calculate(string $expression)
    {
        $tokens = explode(' ', $expression);

        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $this->stack[] = $token;
            } else {
                $this->performOperation($token);
            }
        }

        if (count($this->stack) != 1) {
            throw new Exception("Invalid RPN expression");
        }

        return array_pop($this->stack);
    }

    /**
     * @throws Exception
     */
    private function performOperation(string $operation): void
    {
        if (count($this->stack) < 2 && $operation !== 'SQRT') {
            throw new Exception("Not enough operands for operation $operation");
        }

        if ($operation === 'SQRT') {
            $operand = array_pop($this->stack);
            $this->stack[] = sqrt($operand);
        } elseif ($operation === 'MAX') {
            $operand1 = array_pop($this->stack);
            $operand2 = array_pop($this->stack);
            $this->stack[] = max($operand1, $operand2);
        } else {
            $operand2 = array_pop($this->stack);
            $operand1 = array_pop($this->stack);

            switch ($operation) {
                case '+': $this->stack[] = $operand1 + $operand2; break;
                case '-': $this->stack[] = $operand1 - $operand2; break;
                case '*': $this->stack[] = $operand1 * $operand2; break;
                case '/':
                    if ($operand2 == 0) {
                        throw new Exception("Division by zero error");
                    }
                    $this->stack[] = $operand1 / $operand2;
                    break;
                default: throw new Exception("Invalid operation $operation");
            }
        }
    }
}