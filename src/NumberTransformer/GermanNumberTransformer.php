<?php

namespace NumberToWords\NumberTransformer;

use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\Language\German\GermanDictionary;
use NumberToWords\Language\German\GermanExponentInflector;
use NumberToWords\Language\German\GermanTripletTransformer;
use NumberToWords\Service\NumberToTripletsConverter;

class GermanNumberTransformer implements NumberTransformer
{
    /**
     * @param string|float|int $number
     *
     * @throws NumberToWordsException
     */
    public function toWords($number): string
    {
        $dictionary = new GermanDictionary();
        $numberToTripletsConverter = new NumberToTripletsConverter();
        $tripletTransformer = new GermanTripletTransformer($dictionary);
        $exponentInflector = new GermanExponentInflector();

        $numberTransformer = (new NumberTransformerBuilder())
            ->withDictionary($dictionary)
            ->withWordsSeparatedBy('')
            ->transformNumbersBySplittingIntoPowerAwareTriplets($numberToTripletsConverter, $tripletTransformer)
            ->inflectExponentByNumbers($exponentInflector)
            ->build();

        return $numberTransformer->toWords($number);
    }
}
