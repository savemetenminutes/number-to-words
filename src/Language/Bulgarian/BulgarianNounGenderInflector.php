<?php

namespace NumberToWords\Language\Bulgarian;

use NumberToWords\ArithmeticProcessor\ArithmeticProcessor;

class BulgarianNounGenderInflector
{
    protected ArithmeticProcessor $arithmeticProcessor;

    public function __construct(ArithmeticProcessor $arithmeticProcessor)
    {
        $this->arithmeticProcessor = $arithmeticProcessor;
    }

    /**
     * @param string|float|int $number
     */
    public function inflectNounByNumber($number, string $singular, string $plural, string $genitivePlural): string
    {
        if ($this->arithmeticProcessor->comp($number, 1) === 0) {
            return $singular;
        }

        return $plural;
    }
}
