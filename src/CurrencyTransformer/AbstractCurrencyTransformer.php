<?php

namespace NumberToWords\CurrencyTransformer;

use NumberToWords\ArithmeticProcessor\ArithmeticProcessor;

abstract class AbstractCurrencyTransformer implements  CurrencyTransformer
{
    protected ArithmeticProcessor $arithmeticProcessor;

    public function __construct(ArithmeticProcessor  $arithmeticProcessor)
    {
        $this->arithmeticProcessor = $arithmeticProcessor;
    }
}
