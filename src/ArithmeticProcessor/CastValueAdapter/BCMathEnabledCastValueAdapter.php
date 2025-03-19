<?php

namespace NumberToWords\ArithmeticProcessor\CastValueAdapter;

class BCMathEnabledCastValueAdapter extends SimpleCastValueAdapter
{
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
            $this->floatingPointScale ?? bcscale(),
            '.',
            ''
        );
    }
}
