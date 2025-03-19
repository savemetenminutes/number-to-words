<?php

namespace NumberToWords\Language;

interface PowerAwareTripletTransformer
{
    public function transformToWords(string $number, int $power): ?string;
}
