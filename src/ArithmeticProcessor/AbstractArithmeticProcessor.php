<?php

namespace NumberToWords\ArithmeticProcessor;

use NumberToWords\ArithmeticProcessor\CastValueAdapter\CastValueAdapter;

abstract class AbstractArithmeticProcessor implements  ArithmeticProcessor
{
    protected CastValueAdapter $castValueAdapter;

    public function __construct(CastValueAdapter $castValueAdapter)
    {
        $this->castValueAdapter = $castValueAdapter;
    }
}
