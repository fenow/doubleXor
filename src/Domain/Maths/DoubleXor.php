<?php


namespace App\Domain\Maths;

use App\Domain\Maths\Exceptions\DoubleXorLimitException;

/***
 * Let us introduce a new operation called double xor, and use the operator ^^ to denote it.
 * For two integers A and B, A ^^ B is calculated as follows:
 *
 * Class DoubleXor
 * @package App\Domain\Maths
 */
class DoubleXor implements DoubleXorInterface
{
    const MIN_LIMIT = 1;
    const MAX_LIMIT = 1000000;

    const ERROR_RESULT = -1;
    const DEFAULT_RESULT = 1;

    const SINGLE_DIGIT = 0;
    const MULTIPLE_DIGIT = 1;

    const SINGLE_MODULO = 2;
    const MULTIPLE_MODULO = 10;

    const PREPEND_CHARACTER = 0;

    /***
     * @var int $n
     */
    private $n;

    /***
     * Function to calculate the DoubleXor
     *
     * When multiple ^^ operations occur in an expression, they must be evaluated from left to right.
     * For example, A ^^ B ^^ C means (A ^^ B) ^^ C.
     * You are given an int N. Return the value of N ^^ (N ­ 1) ^^ (N ­ 2) ^^ ... ^^ 1.
     *
     *
     * @param int $n
     * @return int
     */
    public function calculate(int $n): int
    {
        $this->n = $n;

        // We are testing the perimeter to know if a calcul is necessary
        try {
            $this->checkPerimeterLimit();
        } catch (DoubleXorLimitException $e) {
            return self::ERROR_RESULT;
        }

        // We are getting the list of digit from the n value
        $list = $this->getDigitList();

        // While more one element in the list we can make the operation
        while (count($list) > 1) {
            $a = $list[0];
            $b = $list[1];

            // Be careful operation will different if it's a single digit
            if (self::checkElementLongerAndType($a, $b) === self::SINGLE_DIGIT) {
                $newValue = self::oneDigitCalculate($a, $b);
            } else {
                $newValue = self::multipleDigitCalculate($a, $b);
            }

            // We remove the two first elements of the list (old $a and $b value)
            $list = array_slice($list, 2);

            // We add the new value at the begining of the list => The result of the previous operation made by $a and $b
            array_unshift($list, $newValue);
        }

        return $newValue ?? self::DEFAULT_RESULT;
    }

    /***
     * Function to test the perimeter of the n parameter
     *
     * @throws DoubleXorLimitException
     */
    private function checkPerimeterLimit(): void
    {
        if ($this->n < self::MIN_LIMIT || $this->n > self::MAX_LIMIT) {
            throw new DoubleXorLimitException('n is out of space');
        }
    }

    /***
     * Function to explode the n parameter in list of decrement digit
     *
     * @return array
     */
    private function getDigitList(): array
    {
        $output = [];

        for ($i = $this->n; $i>= 1; $i--) {
            $output[] = $i;
        }

        return $output;
    }

    /***
     * Function to analyse the type of digit => SINGLE or MULTIPLE
     *
     * @param $digit
     * @return string
     */
    private static function getElementType($digit): string
    {
        $digitLong = strlen($digit);

        return ($digitLong === 1) ? self::SINGLE_DIGIT : self::MULTIPLE_DIGIT;
    }

    /***
     * Function to set the digits with the same length.
     * Be careful params are set in reference because we render the type of digit but we also want to have the good length for $a and $b
     *
     * Take the decimal representations of A and B.
     * If they have different lengths, prepend the shorter one with leading zeros until they both have the same length.
     *
     * For example
     *      - 5^^123 = 126 ("5" is prepended with two leading zeros to become "005")
     * @param int $a First digit
     * @param int $b Second digit
     * @return string Here, we need to know how to calculate the XOR of two digits
     */
    private static function checkElementLongerAndType(int &$a, int &$b): string
    {
        $aLong = strlen($a);
        $bLong = strlen($b);

        if ($aLong < $bLong) {
            $a = str_pad($a, $bLong, self::PREPEND_CHARACTER, STR_PAD_LEFT);
        } elseif ($bLong < $aLong) {
            $b = str_pad($b, $aLong, '0', STR_PAD_LEFT);
        }

        return self::getElementType($a);
    }

    /***
     * Calcul method for 2 single digits
     *
     * If a and b are single bits then a ^ b is defined as (a + b) % 2.
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    private static function oneDigitCalculate(int $a, int $b) : int
    {
        return ($a + $b) % self::SINGLE_MODULO;
    }

    /***
     * Calcul method for 2 multiple digits
     *
     * Then, label the digits of A as a​1,​ a​2,​ ..., a​n (from left to right) and the digits of B as b​1,​ b​2,​ ... , b​n (from left to right).
     * C = A ^^ B will consist of the digits c​1,​ c​2,​ ... , c​n​ (from left to right), where c​i = (a​i ^ b​i)​ % 10,
     * where ^ is the usual bitwise XOR operator (see notes for exact definition) and x % y is the remainder of x divided by y.
     *
     * For example, 8765 ^^ 2309 = 462
     *      - c​1 = (8 ^ 2) % 10 = 10 % 10 = 0
     *      - c​2 =(7 ^ 3) % 10 = 4 % 10 = 4
     *      - c​3 =(6 ^ 0) % 10 = 6 % 10 = 6
     *      - c​4 = (5 ^9) % 10 = 12 % 10 = 2
     *
     * @param string $a
     * @param string $b
     * @return int
     */
    private static function multipleDigitCalculate(string $a, string $b): int
    {
        $output = '';

        $aList = str_split($a);
        $bList = str_split($b);

        $nbDigits = count($aList);

        for ($i=0; $i < $nbDigits; $i++) {
            $output .= gmp_xor($aList[$i], $bList[$i]) % self::MULTIPLE_MODULO;
        }

        return intval(ltrim($output, self::PREPEND_CHARACTER));
    }
}
