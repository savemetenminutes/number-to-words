<?php

namespace NumberToWords\Concerns;

use NumberToWords\ArithmeticProcessor\ArithmeticProcessor;
use NumberToWords\ArithmeticProcessor\BCMathEnabledArithmeticProcessor;
use NumberToWords\ArithmeticProcessor\CastValueAdapter\BCMathEnabledCastValueAdapter;
use NumberToWords\ArithmeticProcessor\CastValueAdapter\SimpleCastValueAdapter;
use NumberToWords\ArithmeticProcessor\BuiltInOperandsArithmeticProcessor;

trait ManagesArithmeticProcessors
{
    protected array $arithmeticProcessors = [];

    /**
     * @param string|float|int $value
     */
    public function getArithmeticProcessor($value, $options): ArithmeticProcessor
    {
        if (!is_scalar($value) || is_bool($value)) {
            throw new \RuntimeException('Value must be of type string|float|int.');
        }

        /**
         * Sort the options by key to avoid initializing an arithmetic processor with the same, but rearranged options
         */
        ksort($options);
        $optionsHash = hash('sha256', serialize($options));

        switch (true) {
            case extension_loaded('bcmath') && !($options['useNativeOperands'] ?? false):
                if (isset($this->arithmeticProcessors['string']['bcmath'][$optionsHash])) {
                    return $this->arithmeticProcessors['string']['bcmath'][$optionsHash];
                }

                return
                    $this->arithmeticProcessors['string']['bcmath'][$optionsHash] =
                        new BCMathEnabledArithmeticProcessor(
                            new BCMathEnabledCastValueAdapter(
                                $options['floatingPointPrecision'] ?? null
                            )
                        );
            default:
                if (isset($this->arithmeticProcessors['int'][$optionsHash])) {
                    return $this->arithmeticProcessors['int'][$optionsHash];
                }

                return
                    $this->arithmeticProcessors['int'][$optionsHash] =
                        new BuiltInOperandsArithmeticProcessor(
                            new SimpleCastValueAdapter($options['floatingPointPrecision'] ?? null)
                        );
        }
    }
}
