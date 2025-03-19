<?php

namespace NumberToWords\Concerns;

use NumberToWords\ArithmeticProcessor\ArithmeticProcessor;

interface ManagesArithmeticProcessorsInterface
{
    /**
     * If the BCMath extension is loaded, the
     * \NumberToWords\ArithmeticProcessor\BCMathEnabledArithmeticProcessor
     * will be used. Set this option to true to enforce using
     * \NumberToWords\ArithmeticProcessor\BuiltInOperandsArithmeticProcessor
     * in this case.
     */
    public const OPTION_NAME_USE_NATIVE_OPERANDS = 'useNativeOperands';
    public const OPTION_NAME_FLOATING_POINT_PRECISION = 'floatingPointPrecision';
    public const DEFAULT_OPTIONS = [
        self::OPTION_NAME_USE_NATIVE_OPERANDS => false,
        /**
         * If null, the value will be obtained from
         * \NumberToWords\ArithmeticProcessor\CastValueAdapter\CastValueAdapter::DEFAULT_FLOATING_POINT_SCALE
         */
        self::OPTION_NAME_FLOATING_POINT_PRECISION => null,
    ];

    /**
     * @param string|float|int $value
     */
    public function getArithmeticProcessor($value, $options): ArithmeticProcessor;
}
