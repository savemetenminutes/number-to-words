<?php

namespace NumberToWords\ArithmeticProcessor\CastValueAdapter;

class SimpleCastValueAdapter implements CastValueAdapter
{
    protected ?int $floatingPointScale = null;

    public function __construct(?int $floatingPointScale = null)
    {
        $this->floatingPointScale = $floatingPointScale;
    }

    /**
     * @inheritDoc
     */
    public function castValue($value, string $castTo)
    {
        switch ($castTo) {
            case self::CAST_TO_STRING:
                return static::castToString($value);
            case self::CAST_TO_FLOAT:
                return static::castToFloat($value);
            case self::CAST_TO_INT:
                return static::castToInt($value);
        }
    }

    /**
     * @inheritDoc
     */
    public function castToString($value): string
    {
        if ($value === null) {
            return '0';
        }

        if (is_string($value)) {
            return $value;
        }

        if (is_int($value)) {
            return (string) $value;
        }

        /**
         * Handles casting scientific notation floating point numbers
         */
        return number_format(
            $value,
            $this->floatingPointScale ?? self::DEFAULT_FLOATING_POINT_SCALE,
            '.',
            ''
        );
    }

    /**
     * @inheritDoc
     */
    public function castToFloat($value): float
    {
        return (float)$value;
    }

    /**
     * @inheritDoc
     */
    public function castToInt($value): int
    {
        return (int)$value;
    }
}
