<?php

namespace NumberToWords\ArithmeticProcessor\CastValueAdapter;

interface CastValueAdapter
{
    public const CAST_TO_STRING = 'string';
    public const CAST_TO_FLOAT = 'float';
    public const CAST_TO_INT = 'int';

    public const DEFAULT_FLOATING_POINT_SCALE = 10;

    /**
     * @param string|float|int $value
     */
    public function castValue($value, string $castTo);

    /**
     * @param string|float|int $value
     */
    public function castToString($value): string;

    /**
     * @param string|float|int $value
     */
    public function castToFloat($value): float;

    /**
     * @param string|float|int $value
     */
    public function castToInt($value): int;
}
