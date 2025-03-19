<?php

namespace NumberToWords\NumberTransformer;

use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\Language\Azerbaijani\AzerbaijaniDictionary;
use NumberToWords\Language\Azerbaijani\AzerbaijaniExponentGetter;
use NumberToWords\Language\Azerbaijani\AzerbaijaniTripletTransformer;
use NumberToWords\Service\NumberToTripletsConverter;

class AzerbaijaniNumberTransformer implements NumberTransformer
{
    /**
     * @param string|float|int $number
     *
     * @throws NumberToWordsException
     */
    public function toWords($number): string
    {
        $dictionary = new AzerbaijaniDictionary();
        $numberToTripletsConverter = new NumberToTripletsConverter();
        $tripletTransformer = new AzerbaijaniTripletTransformer($dictionary);
        $exponentInflector = new AzerbaijaniExponentGetter();

        $numberTransformer = (new NumberTransformerBuilder())
            ->withDictionary($dictionary)
            ->withWordsSeparatedBy(' ')
            ->transformNumbersBySplittingIntoTriplets($numberToTripletsConverter, $tripletTransformer)
            ->useRegularExponents($exponentInflector)
            ->build();

        return $numberTransformer->toWords($number);
    }
}
