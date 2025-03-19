<?php

namespace NumberToWords\NumberTransformer;

use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\Language\English\EnglishDictionary;
use NumberToWords\Language\English\EnglishExponentGetter;
use NumberToWords\Language\English\EnglishTripletTransformer;
use NumberToWords\Service\NumberToTripletsConverter;

class EnglishNumberTransformer implements NumberTransformer
{
    /**
     * @param string|float|int $number
     *
     * @throws NumberToWordsException
     */
    public function toWords($number): string
    {
        $dictionary = new EnglishDictionary();
        $numberToTripletsConverter = new NumberToTripletsConverter();
        $tripletTransformer = new EnglishTripletTransformer($dictionary);
        $exponentInflector = new EnglishExponentGetter();

        $numberTransformer = (new NumberTransformerBuilder())
            ->withDictionary($dictionary)
            ->withWordsSeparatedBy(' ')
            ->transformNumbersBySplittingIntoTriplets($numberToTripletsConverter, $tripletTransformer)
            ->useRegularExponents($exponentInflector)
            ->build();

        return $numberTransformer->toWords($number);
    }
}
