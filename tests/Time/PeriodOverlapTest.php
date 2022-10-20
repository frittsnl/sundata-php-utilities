<?php


namespace Sundata\Utilities\Test\Time;

use Carbon\CarbonImmutable;
use Sundata\Utilities\Time\Period;
use PHPUnit\Framework\TestCase;

class PeriodOverlapTest extends TestCase
{

    public function testPeriodsThatDontOverlapReturnNull()
    {
        $periodA = new Period(
            CarbonImmutable::create(2000, 1,15),
            CarbonImmutable::create(2000, 10,15)
        );

        $periodB = new Period(
            CarbonImmutable::create(2001, 1,15),
            CarbonImmutable::create(2001, 10,15)
        );

        $this->assertEquals(null, $periodA->getOverlap($periodB));
        $this->assertEquals(null, $periodB->getOverlap($periodA));
    }

    public function testGettingTheOverlapOnTheSamePeriodReturnsTheSamePeriod()
    {
        $periodA = new Period(
            CarbonImmutable::create(2000, 1,15),
            CarbonImmutable::create(2000, 10,15)
        );

        $this->assertEquals($periodA, $periodA->getOverlap($periodA));
    }

    public function testFullOverlapReturnsTheSamePeriod()
    {
        $periodA = new Period(
            CarbonImmutable::create(2000, 1,15),
            CarbonImmutable::create(2000, 10,15)
        );

        $periodB = new Period(
            CarbonImmutable::create(1900, 1,15),
            CarbonImmutable::create(2100, 10,15)
        );

        $this->assertEquals($periodA, $periodA->getOverlap($periodB));
        $this->assertEquals($periodA, $periodB->getOverlap($periodA));
    }

    public function testPartialOverlapAtTheStart()
    {
        $periodA = new Period(
            CarbonImmutable::create(2000, 1,15),
            CarbonImmutable::create(2000, 10,15)
        );

        $periodB = new Period(
            CarbonImmutable::create(1999, 1,15),
            CarbonImmutable::create(2000, 5,15)
        );

        $expectedOutcome = new Period(
            $periodA->getStart(),
            $periodB->getEnd()
        );
        $this->assertEquals($expectedOutcome, $periodA->getOverlap($periodB));
        $this->assertEquals($expectedOutcome, $periodB->getOverlap($periodA));
    }

    public function testPartialOverlapAtTheEnd()
    {
        $periodA = new Period(
            CarbonImmutable::create(2000, 1,15),
            CarbonImmutable::create(2000, 10,15)
        );

        $periodB = new Period(
            CarbonImmutable::create(2000, 5,15),
            CarbonImmutable::create(2100, 1,1)
        );

        $expectedOutcome = new Period(
            $periodB->getStart(),
            $periodA->getEnd()
        );
        $this->assertEquals($expectedOutcome, $periodA->getOverlap($periodB));
        $this->assertEquals($expectedOutcome, $periodB->getOverlap($periodA));
    }

    public function testPeriodIsOutsideOfPeriodB()
    {
        $periodA = new Period(
            CarbonImmutable::create(2000, 1,15),
            CarbonImmutable::create(2000, 10,15)
        );

        $periodB = new Period(
            CarbonImmutable::create(1900, 1,15),
            CarbonImmutable::create(1910, 1,1)
        );

        $this->assertEquals(null, $periodA->getOverlap($periodB));
        $this->assertEquals(null, $periodB->getOverlap($periodA));
    }
}