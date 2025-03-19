<?php

namespace NumberToWords\CurrencyTransformer;

use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\Legacy\Numbers\Words;
use NumberToWords\TransformerOptions\CurrencyTransformerOptions;

class PortugueseBrazilianCurrencyTransformer extends AbstractCurrencyTransformer
{
    /**
     * @param string|float|int $amount
     *
     * @throws NumberToWordsException
     */
    public function toWords($amount, string $currency, ?CurrencyTransformerOptions $options = null): string
    {
        $converter = new Words($options);

        return $converter->transformToCurrency($amount, 'pt_BR', $currency);
    }
}
