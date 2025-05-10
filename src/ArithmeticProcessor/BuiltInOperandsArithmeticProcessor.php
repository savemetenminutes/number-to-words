<?php

namespace NumberToWords\ArithmeticProcessor;

class BuiltInOperandsArithmeticProcessor extends AbstractArithmeticProcessor
{
    /**
     * @inheritDoc
     */
    public function getUnits($value)
    {
        return $value % 10;
    }

    /**
     * @inheritDoc
     */
    public function getTens($value)
    {
        return (int)($value / 10) % 10;
    }

    /**
     * @inheritDoc
     */
    public function getHundreds($value)
    {
        return (int)($value / 100) % 10;
    }

    /**
     * @inheritDoc
     */
    public function getCurrencyFraction($value)
    {
        return abs($value) % 100;
    }

    /**
     * @inheritDoc
     */
    public function comp($value0, $value1): int
    {
        switch (true) {
            case $value0 < $value1:
                return -1;
            case $value0 == $value1:
                return 0;
            default:
                return 1;
        }
    }

    /**
     * @inheritDoc
     */
    public function add($value0, $value1)
    {
        return $value0 + $value1;
    }

    /**
     * @inheritDoc
     */
    public function sub($value0, $value1)
    {
        return $value0 - $value1;
    }

    /**
     * @inheritDoc
     */
    public function mul($value0, $value1)
    {
        return $value0 * $value1;
    }

    /**
     * @inheritDoc
     */
    public function div($value0, $value1)
    {
        return $value0 / $value1;
    }

    /**
     * @inheritDoc
     */
    public function mod($value0, $value1)
    {
        return $value0 % $value1;
    }

    /**
     * @inheritDoc
     */
    public function abs($value)
    {
        return abs($value);
    }

    /**
     * @inheritDoc
     */
    public function ceil($number)
    {
        return ceil($number);
    }

    /**
     * @inheritDoc
     */
    public function floor($number)
    {
        return floor($number);
    }

    /**
     * @inheritDoc
     */
    public function round($number, int $precision = 0)
    {
        return round($number, $precision);
    }

    /**
     * @inheritDoc
     */
    public function min(...$numbers)
    {
        return min(...$numbers);
    }

    /**
     * @inheritDoc
     */
    public function max(...$numbers)
    {
        return max(...$numbers);
    }
}
