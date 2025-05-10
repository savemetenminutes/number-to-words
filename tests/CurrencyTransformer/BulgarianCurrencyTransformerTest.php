<?php

namespace NumberToWords\CurrencyTransformer;

class BulgarianCurrencyTransformerTest extends CurrencyTransformerTest
{
    protected function setUp(): void
    {
        $this->currencyTransformer = new BulgarianCurrencyTransformer();
    }

    public function providerItConvertsMoneyAmountToWords(): array
    {
        return [
            [100, 'BGN', 'един лев и нула стотинки'],
            [200, 'BGN', 'два лева и нула стотинки'],
            [500, 'BGN', 'пет лева и нула стотинки'],
            [54000, 'BGN', 'петстотин и четиридесет лева и нула стотинки'],
            [54100, 'BGN', 'петстотин четиридесет и един лева и нула стотинки'],
            [54200, 'BGN', 'петстотин четиридесет и два лева и нула стотинки'],
            [54400, 'BGN', 'петстотин четиридесет и четири лева и нула стотинки'],
            [54500, 'BGN', 'петстотин четиридесет и пет лева и нула стотинки'],
            [54501, 'BGN', 'петстотин четиридесет и пет лева и една стотинка'],
            [54552, 'BGN', 'петстотин четиридесет и пет лева и петдесет и две стотинки'],
            [54599, 'BGN', 'петстотин четиридесет и пет лева и деветдесет и девет стотинки'],
            [304501, 'BGN', 'три хиляди четиридесет и пет лева и една стотинка'],
            [304501, 'BGN', 'три хиляди четиридесет и пет лева и една стотинка'],
            [
                /**
                 * With \NumberToWords\ArithmeticProcessor\BCMathEnabledArithmeticProcessor
                 * there is no loss of precision
                 */
                '82987394829012101.01',
                'BGN',
                'осемдесет и два квадрилиона'
                    . ' деветстотин осемдесет и седем трилиона'
                    . ' триста деветдесет и четири милиарда'
                    . ' осемстотин двадесет и девет милиона'
                    . ' дванадесет хиляди сто и един лева'
                    . ' и една стотинка',

                /**
                 * With \NumberToWords\ArithmeticProcessor\BuiltInOperandsArithmeticProcessor
                 * there is loss of precision in the last five orders of the value
                 */
                //'82987394829012101.01',
                //'BGN',
                //'осемдесет и два квадрилиона'
                //    . ' деветстотин осемдесет и седем трилиона'
                //    . ' триста деветдесет и четири милиарда'
                //    . ' осемстотин двадесет и девет милиона'
                //    . ' дванадесет хиляди лева'
                //    . ' и дванадесет стотинки',
            ],
        ];
    }
}
