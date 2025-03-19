<?php

namespace NumberToWords\CurrencyTransformer;

use NumberToWords\Arithmetic\FloatValueProcessor;
use NumberToWords\Arithmetic\IntValueProcessor;
use NumberToWords\Arithmetic\StringValueProcessor;
use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\Grammar\Form;
use NumberToWords\Language\Bulgarian\BulgarianDictionary;
use NumberToWords\Language\Bulgarian\BulgarianExponentInflector;
use NumberToWords\Language\Bulgarian\BulgarianNounGenderInflector;
use NumberToWords\Language\Bulgarian\BulgarianTripletTransformer;
use NumberToWords\Language\GrammaticalGenderAwareInterface;
use NumberToWords\NumberTransformer\NumberTransformerBuilder;
use NumberToWords\Service\NumberToTripletsConverter;
use NumberToWords\TransformerOptions\CurrencyTransformerOptions;

class BulgarianCurrencyTransformer extends AbstractCurrencyTransformer
{
    /**
     * @param string|float|int $amount
     *
     * @throws NumberToWordsException
     */
    public function toWords($amount, string $currency, ?CurrencyTransformerOptions $options = null): string
    {
        $currency = strtoupper($currency);

        if (!array_key_exists($currency, BulgarianDictionary::CURRENCY)) {
            throw new NumberToWordsException(
                sprintf('Currency "%s" is not available for "%s" language', $currency, get_class($this))
            );
        }

        $currency = BulgarianDictionary::CURRENCY[$currency];

        $dictionary = new BulgarianDictionary();
        $nounGenderInflector = new BulgarianNounGenderInflector($this->arithmeticProcessor);
        $numberToTripletsConverter = new NumberToTripletsConverter($this->arithmeticProcessor);
        $tripletTransformerWholePart =
            (new BulgarianTripletTransformer($this->arithmeticProcessor, $dictionary))
                ->setGrammaticalGender(
                    $currency
                        [BulgarianDictionary::CURRENCY_WHOLE]
                        [GrammaticalGenderAwareInterface::GRAMMATICAL_GENDER]
                );
        $tripletTransformerFractionPart =
            (new BulgarianTripletTransformer($this->arithmeticProcessor, $dictionary))
                ->setGrammaticalGender(
                    $currency
                        [BulgarianDictionary::CURRENCY_FRACTION]
                        [GrammaticalGenderAwareInterface::GRAMMATICAL_GENDER]
                );
        $exponentInflector = new BulgarianExponentInflector(
            $this->arithmeticProcessor,
            $nounGenderInflector
        );

        $decimal = $this->arithmeticProcessor->floor($this->arithmeticProcessor->div($amount, '100'));
        $fraction = $this->arithmeticProcessor->getCurrencyFraction($amount);

        if ($this->arithmeticProcessor->comp($fraction, '0') === 0) {
            $fraction = null;
        }

        $numberTransformerWholePart = (new NumberTransformerBuilder($this->arithmeticProcessor))
            ->withDictionary($dictionary)
            ->withWordsSeparatedBy($dictionary->getSeparator())
            ->transformNumbersBySplittingIntoPowerAwareTriplets(
                $numberToTripletsConverter,
                $tripletTransformerWholePart
            )
            ->inflectExponentByNumbers($exponentInflector)
            ->build();

        $words = [];

        $words[] = $numberTransformerWholePart->toWords($decimal);
        $words[] = $nounGenderInflector->inflectNounByNumber(
            $decimal,
            $currency[BulgarianDictionary::CURRENCY_WHOLE][Form::SINGULAR],
            $currency[BulgarianDictionary::CURRENCY_WHOLE][Form::PLURAL],
            $currency[BulgarianDictionary::CURRENCY_WHOLE][Form::PLURAL],
        );

        $words[] = BulgarianDictionary::GRAMMATICAL_CONJUNCTION_AND;

        if ($fraction !== null) {
            $numberTransformerFractionPart = (new NumberTransformerBuilder($this->arithmeticProcessor))
                ->withDictionary($dictionary)
                ->withWordsSeparatedBy($dictionary->getSeparator())
                ->transformNumbersBySplittingIntoPowerAwareTriplets(
                    $numberToTripletsConverter,
                    $tripletTransformerFractionPart
                )
                ->inflectExponentByNumbers($exponentInflector)
                ->build();

            $words[] = $numberTransformerFractionPart->toWords($fraction);
            $words[] = $nounGenderInflector->inflectNounByNumber(
                $fraction,
                $currency[BulgarianDictionary::CURRENCY_FRACTION][Form::SINGULAR],
                $currency[BulgarianDictionary::CURRENCY_FRACTION][Form::PLURAL],
                $currency[BulgarianDictionary::CURRENCY_FRACTION][Form::PLURAL],
            );
        } else {
            $words[] = $dictionary->getZero();
            $words[] =
                $currency[BulgarianDictionary::CURRENCY_FRACTION][Form::PLURAL];
        }

        return implode(' ', $words);
    }
}
