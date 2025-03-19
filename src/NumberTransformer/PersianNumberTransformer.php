<?php

namespace NumberToWords\NumberTransformer;

use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\Language\Persian\PersianConverter;
use NumberToWords\Language\Persian\PersianDictionary;

class PersianNumberTransformer implements NumberTransformer
{
    /**
     * @param string|float|int $number
     *
     * @throws NumberToWordsException
     */
    public function toWords($number): string
    {
        $dictionary = new PersianDictionary();
        return (new PersianConverter($dictionary))->convert($number);
    }
}
