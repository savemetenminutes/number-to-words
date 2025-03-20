<?php

namespace NumberToWords;

use NumberToWords\Concerns\ManagesArithmeticProcessorsInterface;
use NumberToWords\Concerns\ManagesCurrencyTransformers;
use NumberToWords\Concerns\ManagesNumberTransformers;

class NumberToWords implements ManagesArithmeticProcessorsInterface
{
    use ManagesCurrencyTransformers;
    use ManagesNumberTransformers;
}
