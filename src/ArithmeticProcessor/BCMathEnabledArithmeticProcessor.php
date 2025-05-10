<?php

namespace NumberToWords\ArithmeticProcessor;

class BCMathEnabledArithmeticProcessor extends AbstractArithmeticProcessor
{
    /**
     * @inheritDoc
     */
    public function getUnits($value)
    {
        $value = $this->castValueAdapter->castToString($value);

        return $this->floor(bcmod($value, '10'));
    }

    /**
     * @inheritDoc
     */
    public function getTens($value)
    {
        $value = $this->castValueAdapter->castToString($value);

        return $this->floor(bcmod(bcdiv($value, '10'), '10'));
    }

    /**
     * @inheritDoc
     */
    public function getHundreds($value)
    {
        $value = $this->castValueAdapter->castToString($value);

        return $this->floor(bcmod(bcdiv($value, '100'), '10'));
    }

    /**
     * @inheritDoc
     */
    public function getCurrencyFraction($value)
    {
        $value = $this->castValueAdapter->castToString($value);

        return $this->floor(bcmod(static::abs($value), '100'));
    }

    /**
     * @inheritDoc
     */
    public function comp($value0, $value1): int
    {
        $value0 = $this->castValueAdapter->castToString($value0);
        $value1 = $this->castValueAdapter->castToString($value1);

        return bccomp($value0, $value1);
    }

    /**
     * @inheritDoc
     */
    public function add($value0, $value1)
    {
        $value0 = $this->castValueAdapter->castToString($value0);
        $value1 = $this->castValueAdapter->castToString($value1);

        $result = bcadd($value0, $value1);

        if (str_contains($result, '.')) {
            $result = rtrim($result, '0');
            $result = rtrim($result, '.');
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function sub($value0, $value1)
    {
        $value0 = $this->castValueAdapter->castToString($value0);
        $value1 = $this->castValueAdapter->castToString($value1);

        $result = bcsub($value0, $value1);

        if (str_contains($result, '.')) {
            $result = rtrim($result, '0');
            $result = rtrim($result, '.');
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function mul($value0, $value1)
    {
        $value0 = $this->castValueAdapter->castToString($value0);
        $value1 = $this->castValueAdapter->castToString($value1);

        $result = bcmul($value0, $value1);

        if (str_contains($result, '.')) {
            $result = rtrim($result, '0');
            $result = rtrim($result, '.');
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function div($value0, $value1)
    {
        $value0 = $this->castValueAdapter->castToString($value0);
        $value1 = $this->castValueAdapter->castToString($value1);

        $result = bcdiv($value0, $value1);

        if (str_contains($result, '.')) {
            $result = rtrim($result, '0');
            $result = rtrim($result, '.');
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function mod($value0, $value1)
    {
        $value0 = $this->castValueAdapter->castToString($value0);
        $value1 = $this->castValueAdapter->castToString($value1);

        $result = bcmod($value0, $value1);

        if (str_contains($result, '.')) {
            $result = rtrim($result, '0');
            $result = rtrim($result, '.');
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function abs($value)
    {
        $value = $this->castValueAdapter->castToString($value);

        if (strpos($value, '-') === 0) {
            return substr($value, 1);
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function ceil($number)
    {
        if (str_contains($number, '.')) {
            if (preg_match('#\.0+$#', $number)) {
                if (function_exists('bcround')) { // Available as of PHP 8.4
                    return bcround($number, 0);
                } else {
                    return static::round($number, 0);
                }
            }

            if ($number[0] !== '-') {
                return bcadd($number, '1', 0);
            }

            return bcsub($number, '0', 0);
        }

        return $number;
    }

    /**
     * @inheritDoc
     */
    public function floor($number)
    {
        if (str_contains($number, '.')) {
            if (preg_match('#\.0+$#', $number)) {
                if (function_exists('bcround')) { // Available as of PHP 8.4
                    return bcround($number, 0);
                } else {
                    return static::round($number, 0);
                }
            }

            if ($number[0] !== '-') {
                return bcadd($number, '0', 0);
            }

            return bcsub($number, '1', 0);
        }

        return $number;
    }

    /**
     * @inheritDoc
     */
    public function round($number, int $precision = 0)
    {
        $result = $number;

        if (str_contains($number, '.')) {
            $diff = '0.' . str_repeat('0', $precision) . '5';
            $result =
                ($number[0] === '-')
                    ? bcsub($number, $diff, $precision)
                    : bcadd($number, $diff, $precision);

            if (str_contains($result, '.')) {
                $result = rtrim($result, '0');
                $result = rtrim($result, '.');
            }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function min(...$numbers)
    {
        $result = $numbers[0];
        array_shift($numbers);

        foreach ($numbers as $number) {
            if (bccomp($result, $number) === 1) {
                $result = $number;
            }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function max(...$numbers)
    {
        $result = $numbers[0];
        array_shift($numbers);

        foreach ($numbers as $number) {
            if (bccomp($result, $number) === -1) {
                $result = $number;
            }
        }

        return $result;
    }
}
