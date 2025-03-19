<?php

namespace NumberToWords\Language;

interface ExponentInflector
{
    public function inflectExponent($number, int $power): string;
}
