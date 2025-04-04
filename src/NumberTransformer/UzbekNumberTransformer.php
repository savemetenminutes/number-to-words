<?php

namespace NumberToWords\NumberTransformer;

use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\Language\Uzbek\UzbekDictionary;
use NumberToWords\Language\Uzbek\UzbekExponentGetter;
use NumberToWords\Language\Uzbek\UzbekTripletTransformer;
use NumberToWords\Service\NumberToTripletsConverter;

class UzbekNumberTransformer implements NumberTransformer
{
    /**
     * @param string|float|int $number
     *
     * @throws NumberToWordsException
     */
    public function toWords($number): string
    {
        $dictionary = new UzbekDictionary();
        $numberToTripletsConverter = new NumberToTripletsConverter();
        $tripletTransformer = new UzbekTripletTransformer($dictionary);
        $exponentInflector = new UzbekExponentGetter();

        $numberTransformer = (new NumberTransformerBuilder())
            ->withDictionary($dictionary)
            ->withWordsSeparatedBy(' ')
            ->transformNumbersBySplittingIntoTriplets($numberToTripletsConverter, $tripletTransformer)
            ->useRegularExponents($exponentInflector)
            ->build();

        return $numberTransformer->toWords($number);
    }
}
