<?php


namespace App\Tests\Domain\Maths;


use App\Domain\Maths\DoubleXor;
use PHPUnit\Framework\TestCase;

class DoubleXorTest extends TestCase
{
    public function test1()
    {
        $math = new DoubleXor();
        $this->assertEquals(1, $math->calculate(1));
    }

    public function test2()
    {
        $math = new DoubleXor();
        $this->assertEquals(3, $math->calculate(2));
    }

    public function test7()
    {
        $math = new DoubleXor();
        $this->assertEquals(0, $math->calculate(7));
    }

    public function test10()
    {
        $math = new DoubleXor();
        $this->assertEquals(11, $math->calculate(10));
    }

    public function test102()
    {
        $math = new DoubleXor();
        $this->assertEquals(103, $math->calculate(102));
    }
}