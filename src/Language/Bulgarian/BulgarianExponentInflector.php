<?php

namespace NumberToWords\Language\Bulgarian;

use NumberToWords\ArithmeticProcessor\ArithmeticProcessor;
use NumberToWords\Grammar\Form;
use NumberToWords\Language\ExponentInflector;

class BulgarianExponentInflector implements ExponentInflector
{
    protected ArithmeticProcessor $arithmeticProcessor;
    protected BulgarianNounGenderInflector $inflector;

    public function __construct(
        ArithmeticProcessor $arithmeticProcessor,
        BulgarianNounGenderInflector $inflector
    ) {
        $this->arithmeticProcessor = $arithmeticProcessor;
        $this->inflector = $inflector;
    }

    public function inflectExponent($number, int $power): string
    {
        if ($this->arithmeticProcessor->comp($power, 0) === 0) {
            return '';
        }

        return $this->inflector->inflectNounByNumber(
            $number,
            BulgarianDictionary
                ::ENUMERATIONS
                    [BulgarianDictionary::ENUMERATION_BY_POWERS_OF_A_THOUSAND]
                    [$power]
                    [Form::SINGULAR],
            BulgarianDictionary
                ::ENUMERATIONS
                    [BulgarianDictionary::ENUMERATION_BY_POWERS_OF_A_THOUSAND]
                    [$power]
                    [Form::PLURAL],
            BulgarianDictionary
                ::ENUMERATIONS
                    [BulgarianDictionary::ENUMERATION_BY_POWERS_OF_A_THOUSAND]
                    [$power]
                    [Form::PLURAL],
        );
    }
}
