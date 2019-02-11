<?php

class BowlingTest extends \PHPUnit\Framework\TestCase
{
    protected $sut;

    protected function setUp(): void
    {
        $this->sut = new Bowling();
    }

    /**
     * @test
     */
    public function numberNumberMustReturnAddition()
    {
        $this->assertEquals(3, $this->sut->play('12'));
    }

    /**
     * @test
     */
    public function spareMustReturnTen()
    {
        $this->assertEquals(10, $this->sut->play('1/'));
    }

    /**
     * @test
     */
    public function strikeMustReturnTen()
    {
        $this->assertEquals(10, $this->sut->play('X'));
    }

    /**
     * @test
     */
    public function strikeSpare()
    {
        $this->assertEquals(30, $this->sut->play('X1/'));
    }

    /**
     * @test
     */
    public function strikeNormal()
    {
        $this->assertEquals(16, $this->sut->play('X12'));
    }

    /**
     * @test
     */
    public function strikeTwoFares()
    {
        $this->assertEquals(60, $this->sut->play('XXX'));
    }

    /**
     * @test
     */
    public function fullStrike()
    {
        $this->assertEquals(272, $this->sut->play('XXXXXXXXX2/X'));
    }

    /**
     * @test
     */
    public function normal()
    {
        $this->assertEquals(137, $this->sut->play('X30XX503/526/4/X8/'));
    }

    /**
     * @test
     */
    public function invalidCombinations()
    {
        $this->assertEquals(-1, $this->sut->play('99'));
        $this->assertEquals(-1, $this->sut->play('1'));
        $this->assertEquals(-1, $this->sut->play('XXXXXXXXXX'));
        $this->assertEquals(0, $this->sut->play(''));
        $this->assertEquals(-1, $this->sut->play('asd'));
    }

}
