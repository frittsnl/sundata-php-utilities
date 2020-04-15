<?php


namespace Sundata\Utilities\Test\Time;

use Carbon\CarbonImmutable;
use Sundata\Utilities\Time\Period;
use PHPUnit\Framework\TestCase;

class PeriodTest extends TestCase
{

  public function periodLengthDataProvider()
  {
    return [
        '12 minutes diff in seconds' => ['2000-01-01T00:00:00+01:00', '2000-01-01T00:12:00+01:00', 'inSeconds', 12*60],
        '3 days, 25 min diff in seconds' => ['2000-01-01T00:00:00+01:00', '2000-01-04T00:25:00+01:00', 'inSeconds', (60*60*24*3) + (25*60)],
        '1 hour diff in hours' => ['2000-01-01T00:00:00+01:00', '2000-01-01T01:00:00+01:00', 'inHours', 1],
        '2 days 4 hours, 30 min diff in hours' => ['2000-01-01T00:00:00+01:00', '2000-01-03T04:30:00+01:00', 'inHours', (24*2) + 4 + 0.5],
        '2 days 4 hours, 30 min, 10sec diff in hours' => ['2000-01-01T00:00:00+01:00', '2000-01-03T04:31:51+01:00', 'inHours', 52.53],
        '1 day in days' => ['2000-01-01T00:00:00+01:00', '2000-01-02T00:00:00+01:00', 'inDays', 1],
        '1 day and 1 hour in days' => ['2000-01-01T00:00:00+01:00', '2000-01-02T01:00:00+01:00', 'inDays', 1.04],
        '5 day and 12 hours in days' => ['2000-01-01T00:00:00+01:00', '2000-01-06T12:00:00+01:00', 'inDays', 5.5],
        '1 week in weeks' => ['2000-01-01T00:00:00+01:00', '2000-01-08T00:00:00+01:00', 'inWeeks', 1],
        '3.5 days in weeks' => ['2000-01-01T00:00:00+01:00', '2000-01-04T12:00:00+01:00', 'inWeeks', 0.5],
        '31 days in weeks' => ['2000-01-01T00:00:00+01:00', '2000-02-01T00:00:00+01:00', 'inWeeks', 4.43]
    ];
  }

  /** @dataProvider periodLengthDataProvider */
  public function testPeriodLength($start, $end, $methodName, $expectedResult)
  {
    $this->assertPeriodLength($start, $end, $methodName, $expectedResult);
  }

//TODO remove
  public function daySplitDataProvider()
  {
    return [
      ['2015-12-27T22:22:00+01:00', '2015-12-29T01:11:00+01:00', [
        ['2015-12-27T22:22:00+01:00', '2015-12-28T00:00:00+01:00'],
        ['2015-12-28T00:00:00+01:00', '2015-12-29T00:00:00+01:00'],
        ['2015-12-29T00:00:00+01:00', '2015-12-29T01:11:00+01:00'],
      ]],
    ];
  }

  private function assertPeriodLength($start, $end, string $methodName, $expectedResult): void
  {
    $start = CarbonImmutable::parse($start, 'Europe/Amsterdam');
    $end = CarbonImmutable::parse($end, 'Europe/Amsterdam');

    $period = new Period($start, $end);

    $result = $period->$methodName();
    $this->assertEquals($expectedResult, $result);
  }
}