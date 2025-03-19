<?php

namespace NumberToWords\CurrencyTransformer;

use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\TransformerOptions\CurrencyTransformerOptions;

interface CurrencyTransformer
{
    /**
     * @param string|float|int $amount
     *
     * @throws NumberToWordsException
     */
    public function toWords(
        $amount,
        string $currency,
        ?CurrencyTransformerOptions $options = null
    ): string;
}
