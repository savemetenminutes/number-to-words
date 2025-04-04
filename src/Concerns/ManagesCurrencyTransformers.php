<?php

namespace NumberToWords\Concerns;

use NumberToWords\ArithmeticProcessor\ArithmeticProcessor;
use NumberToWords\CurrencyTransformer as Transformer;
use NumberToWords\Exception\InvalidArgumentException;
use NumberToWords\CurrencyTransformer\CurrencyTransformer;
use NumberToWords\Exception\NumberToWordsException;

trait ManagesCurrencyTransformers
{
    use ManagesArithmeticProcessors;
    use ManagesLocaleAlias;

    private array $currencyTransformers = [
        'ar' => Transformer\ArabicCurrencyTransformer::class,
        'al' => Transformer\AlbanianCurrencyTransformer::class,
        'az' => Transformer\AzerbaijaniCurrencyTransformer::class,
        'bg' => Transformer\BulgarianCurrencyTransformer::class,
        'de' => Transformer\GermanCurrencyTransformer::class,
        'dk' => Transformer\DanishCurrencyTransformer::class,
        'en' => Transformer\EnglishCurrencyTransformer::class,
        'es' => Transformer\SpanishCurrencyTransformer::class,
        'fr' => Transformer\FrenchCurrencyTransformer::class,
        'hu' => Transformer\HungarianCurrencyTransformer::class,
        'id' => Transformer\IndonesianCurrencyTransformer::class,
        'ka' => Transformer\GeorgianCurrencyTransformer::class,
        'lt' => Transformer\LithuanianCurrencyTransformer::class,
        'lv' => Transformer\LatvianCurrencyTransformer::class,
        'ms' => Transformer\MalaysianCurrencyTransformer::class,
        'pl' => Transformer\PolishCurrencyTransformer::class,
        'pt_BR' => Transformer\PortugueseBrazilianCurrencyTransformer::class,
        'ro' => Transformer\RomanianCurrencyTransformer::class,
        'ru' => Transformer\RussianCurrencyTransformer::class,
        'sk' => Transformer\SlovakCurrencyTransformer::class,
        'sr' => Transformer\SerbianCurrencyTransformer::class,
        'sw' => Transformer\SwahiliCurrencyTransformer::class,
        'tk' => Transformer\TurkmenCurrencyTransformer::class,
        'tr' => Transformer\TurkishCurrencyTransformer::class,
        'ua' => Transformer\UkrainianCurrencyTransformer::class,
        'uz' => Transformer\UzbekCurrencyTransformer::class,
        'yo' => Transformer\YorubaCurrencyTransformer::class,
    ];

    /**
     * @throws InvalidArgumentException
     */
    public function getCurrencyTransformer(
        string $language,
        ArithmeticProcessor $arithmeticProcessor
    ): CurrencyTransformer {
        $language = $this->resolveAlias($language);

        if (!array_key_exists($language, $this->currencyTransformers)) {
            throw new InvalidArgumentException(sprintf(
                'Currency transformer for "%s" language is not implemented.',
                $language
            ));
        }

        return new $this->currencyTransformers[$language]($arithmeticProcessor);
    }

    /**
     * @param string|float|int $number
     *
     * @throws NumberToWordsException
     * @throws InvalidArgumentException
     */
    public static function transformCurrency(
        string $language,
        $number,
        string $currency,
        array $options = []
    ): string {
        $static = new static();
        $language = $static->resolveAlias($language);
        $arithmeticProcessor = $static->getArithmeticProcessor($number, $options);

        return
            $static
                ->getCurrencyTransformer($language, $arithmeticProcessor)
                ->toWords($number, $currency);
    }
}
