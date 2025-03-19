<?php

namespace NumberToWords\Language\Bulgarian;

use NumberToWords\ArithmeticProcessor\ArithmeticProcessor;
use NumberToWords\Language\GrammaticalGenderAwareInterface;
use NumberToWords\Language\GrammaticalGenderAwareTrait;
use NumberToWords\Language\PowerAwareTripletTransformer;

class BulgarianTripletTransformer implements PowerAwareTripletTransformer, GrammaticalGenderAwareInterface
{
    use GrammaticalGenderAwareTrait;

    protected ArithmeticProcessor $arithmeticProcessor;
    protected BulgarianDictionary $dictionary;
    protected array $currency;

    public function __construct(ArithmeticProcessor $arithmeticProcessor, BulgarianDictionary $dictionary)
    {
        $this->arithmeticProcessor = $arithmeticProcessor;
        $this->dictionary = $dictionary;
    }

    public function transformToWords(string $number, int $power): ?string
    {
        $units = $this->arithmeticProcessor->getUnits($number);
        $tens = $this->arithmeticProcessor->getTens($number);
        $hundreds = $this->arithmeticProcessor->getHundreds($number);
        $words = [];

        if ($this->arithmeticProcessor->comp($hundreds, 0) === 1) {
            $words[] = $this->dictionary->getCorrespondingHundred(
                $this->arithmeticProcessor->mul($hundreds, 100)
            );
        }

        if ($this->arithmeticProcessor->comp($hundreds, 0) === 1
            && $this->arithmeticProcessor->comp($tens, 0) === 1
            && $this->arithmeticProcessor->comp($units, 0) === 0
        ) {
            $words[] = BulgarianDictionary::GRAMMATICAL_CONJUNCTION_AND;
        }

        if ($this->arithmeticProcessor->comp($tens, 1) === 0) {
            $words[] = $this->dictionary->getCorrespondingTeen($this->arithmeticProcessor->add($units, 10));
        }

        if ($this->arithmeticProcessor->comp($tens, 1) === 1) {
            $words[] = $this->dictionary->getCorrespondingTen($tens * 10);
        }

        if ($this->arithmeticProcessor->comp($units, 0) === 1
            && $this->arithmeticProcessor->comp($tens, 1) !== 0
        ) {
            /**
             * Handles one quantity of a thousand by omitting the quantifier (one) to comply with Bulgarian grammar
             * Example #1: 1001345 => един милион хиляда триста четиридесет и пет лева и нула стотинки
             * Example #2: 1002345 => един милион две хиляди триста четиридесет и пет лева и нула стотинки
             */
            if ($this->arithmeticProcessor->comp($power, 1) === 0
                && $this->arithmeticProcessor->comp($units, 1) === 0
                && $this->arithmeticProcessor->comp($hundreds, 0) === 0
                && $this->arithmeticProcessor->comp($tens, 0) === 0
            ) {
                return null;
            } else {
                if ($this->arithmeticProcessor->comp($hundreds, 0) === 1
                    || $this->arithmeticProcessor->comp($tens, 0) === 1
                ) {
                    $words[] = BulgarianDictionary::GRAMMATICAL_CONJUNCTION_AND;
                }

                $words[] = $this->dictionary->getCorrespondingUnitForGrammaticalGender(
                    $units,
                    $power === 0
                        ? $this->getGrammaticalGender()
                        : BulgarianDictionary
                            ::ENUMERATIONS
                                [BulgarianDictionary::ENUMERATION_BY_POWERS_OF_A_THOUSAND]
                                [$power]
                                [GrammaticalGenderAwareInterface::GRAMMATICAL_GENDER]
                );
            }
        }

        return implode($this->dictionary->getSeparator(), $words);
    }
}
