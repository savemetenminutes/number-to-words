<?php

namespace NumberToWords\Service;

use NumberToWords\ArithmeticProcessor\ArithmeticProcessor;

class NumberToTripletsConverter
{
    protected ArithmeticProcessor $arithmeticProcessor;

    public function __construct(ArithmeticProcessor $arithmeticProcessor)
    {
        $this->arithmeticProcessor = $arithmeticProcessor;
    }

    /**
     * @param string|float|int $number
     */
    public function convertToTriplets($number): array
    {
        $triplets = [];

        while ($this->arithmeticProcessor->comp($number, 0) === 1) {
            $triplets[] = $this->arithmeticProcessor->floor($this->arithmeticProcessor->mod($number, 1000));
            $number = $this->arithmeticProcessor->floor($this->arithmeticProcessor->div($number, 1000));
        }

        return array_reverse($triplets);
    }
}
