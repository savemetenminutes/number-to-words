<?php

namespace NumberToWords\Language;

interface TripletTransformer
{
    public function transformToWords(string $number): string;
}
