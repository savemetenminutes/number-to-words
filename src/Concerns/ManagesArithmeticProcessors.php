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

        $resolvedOptions = array_replace_recursive(
            ManagesArithmeticProcessorsInterface::DEFAULT_OPTIONS,
            $options
        );

        /**
         * Sort the options by key to avoid initializing an arithmetic processor with the same, but rearranged options
         */
        ksort($resolvedOptions);
        $optionsHash = hash('sha256', serialize($resolvedOptions));

        switch (true) {
            case extension_loaded('bcmath')
                && !($options[ManagesArithmeticProcessorsInterface::OPTION_NAME_USE_NATIVE_OPERANDS]):
                if (isset($this->arithmeticProcessors['string']['bcmath'][$optionsHash])) {
                    return $this->arithmeticProcessors['string']['bcmath'][$optionsHash];
                }

                return
                    $this->arithmeticProcessors['string']['bcmath'][$optionsHash] =
                        new BCMathEnabledArithmeticProcessor(
                            new BCMathEnabledCastValueAdapter(
                                $resolvedOptions
                                    [ManagesArithmeticProcessorsInterface::OPTION_NAME_FLOATING_POINT_PRECISION]
                            )
                        );
            default:
                if (isset($this->arithmeticProcessors['int'][$optionsHash])) {
                    return $this->arithmeticProcessors['int'][$optionsHash];
                }

                return
                    $this->arithmeticProcessors['int'][$optionsHash] =
                        new BuiltInOperandsArithmeticProcessor(
                            new SimpleCastValueAdapter(
                                $resolvedOptions
                                    [ManagesArithmeticProcessorsInterface::OPTION_NAME_FLOATING_POINT_PRECISION]
                            )
                        );
        }
    }
}
