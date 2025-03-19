<?php

namespace NumberToWords\NumberTransformer;

use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\Legacy\Numbers\Words;

class PortugueseBrazilianNumberTransformer implements NumberTransformer
{
    /**
     * @param string|float|int $number
     *
     * @throws NumberToWordsException
     */
    public function toWords($number): string
    {
        $converter = new Words();

        return $converter->transformToWords($number, 'pt_BR');
    }
}
