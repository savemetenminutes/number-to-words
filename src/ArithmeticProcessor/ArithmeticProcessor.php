<?php

namespace NumberToWords\ArithmeticProcessor;

interface ArithmeticProcessor
{
    /**
     * @param numeric-string|float|int $value
     *
     * @return numeric-string|int $value
     */
    public function getUnits($value);

    /**
     * @param numeric-string|float|int $value
     *
     * @return numeric-string|int $value
     */
    public function getTens($value);

    /**
     * @param numeric-string|float|int $value
     *
     * @return numeric-string|int $value
     */
    public function getHundreds($value);

    /**
     * @param numeric-string|float|int $value
     *
     * @return numeric-string|int $value
     */
    public function getCurrencyFraction($value);

    /**
     * @param numeric-string|float|int $value
     */
    public function comp($value0, $value1): int;

    /**
     * @param numeric-string|float|int $value
     *
     * @return numeric-string|float|int $value
     */
    public function add($value0, $value1);

    /**
     * @param numeric-string|float|int $value
     *
     * @return numeric-string|float|int $value
     */
    public function sub($value0, $value1);

    /**
     * @param numeric-string|float|int $value
     *
     * @return numeric-string|float|int $value
     */
    public function mul($value0, $value1);

    /**
     * @param numeric-string|float|int $value
     *
     * @return numeric-string|float $value
     */
    public function div($value0, $value1);

    /**
     * @param numeric-string|float|int $value
     *
     * @return numeric-string|int $value
     */
    public function mod($value0, $value1);

    /**
     * @param numeric-string|float|int $value
     *
     * @return numeric-string|float|int $value
     */
    public function abs($value);

    /**
     * @param numeric-string|float|int $number
     *
     * @return numeric-string|float|int
     */
    public function ceil($number);

    /**
     * @param numeric-string|float|int $number
     *
     * @return numeric-string|float|int
     */
    public function floor($number);

    /**
     * @param numeric-string|float|int $number
     *
     * @return numeric-string|int
     */
    public function round($number, int $precision = 0);

    /**
     * @param numeric-string[] $numbers
     *
     * @return numeric-string
     */
    public function min(...$numbers);

    /**
     * @param numeric-string[] $numbers
     *
     * @return numeric-string
     */
    public function max(...$numbers);
}
