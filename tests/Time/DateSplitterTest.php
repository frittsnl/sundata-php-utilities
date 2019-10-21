<?php

namespace Sundata\Utilities\Time\Test;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Time\DateSplitter;

class DateSplitterTest extends TestCase
{
  private $dateSplitter;

  /**
   * This method is called before each test.
   */
  public function setUp(): void
  {
    $this->dateSplitter = new DateSplitter();
  }

  /**
   * @group datesplitter
   * @test
   */
  public function it_splits_a_date_range_into_years()
  {
    $startDate = $this->createRandomDateTime();
    $endDate = $startDate->copy()->addDays(rand(200, 2000));

    $response = $this->dateSplitter->split($startDate->copy(), $endDate->copy(), 'year');

    // Check the amount of years that should come back
    $years = ((int)$endDate->format('Y') - (int)$startDate->format('Y')) + 1;

    if (count($response) > 2) {
      // Check if response contains periods of 7 days
      $this->assertTrue($response[1]->startDate->diffInYears($response[1]->endDate->addSecond()->startOfDay()) == 1);
    }

    $this->assertTrue($response[0]->startDate == $startDate);
    $this->assertTrue($response[count($response) - 1]->endDate == $endDate);
    $this->assertTrue($years == count($response));
  }

  /**
   * @group datesplitter
   * @test
   */
  public function it_splits_a_date_range_into_months()
  {
    $startDate = $this->createRandomDateTime();
    $endDate = $startDate->copy()->addDays(rand(200, 2000));

    // Whatever the date range, we always expect at least 1 month
    $expectedMonths = 1;

    // If start and end are not in the same month and year we should find out how many months are in between
    if ($startDate->format('Y-m') != $endDate->format('Y-m')) {
      $secondMonth = $startDate->copy()->endOfMonth()->addHour()->startOfMonth();
      $lastMonth = $endDate->copy()->startOfMonth();

      $expectedMonths = $expectedMonths + $secondMonth->diffInMonths($lastMonth) + 1; // Add 1 month since Carbon returns the difference between the months and we're actually returning a 'month set' for the last period as well.
    }

    $response = $this->dateSplitter->split($startDate->copy(), $endDate->copy(), 'month');

    if (count($response) > 2) {
      // Check if response contains periods of 7 days
      $this->assertTrue($response[1]->startDate->diffInMonths($response[1]->endDate->addSecond()->startOfDay()) == 1);
    }

    $this->assertTrue($response[0]->startDate == $startDate, 'Assert ' . $response[0]->startDate . ' == ' . $startDate);
    $this->assertTrue($response[count($response) - 1]->endDate == $endDate, 'Assert ' . $response[count($response) - 1]->endDate . ' == ' . $endDate);
    $this->assertTrue($expectedMonths == count($response), 'Assert ' . $expectedMonths . ' == ' . count($response) . ' with $startDate ' . $startDate . ' and $endDate ' . $endDate);
  }

  /**
   * @group datesplitter
   * @test
   */
  public function it_splits_a_date_range_into_weeks()
  {
    $startDate = $this->createRandomDateTime();
    $endDate = $startDate->copy()->addDays(rand(4, 500));

    $response = $this->dateSplitter->split($startDate->copy(), $endDate->copy(), 'week');

    $weeks = $startDate->copy()->startOfWeek()->diffInWeeks($endDate->copy()->endOfWeek()) + 1;

    if (count($response) > 2) {
      // Check if response contains periods of 7 days
      $this->assertTrue($response[1]->startDate->diffInDays($response[1]->endDate->addSecond()->startOfDay()) == 7);
    }

    $this->assertTrue($weeks == count($response));
    $this->assertTrue($response[0]->startDate == $startDate);
    $this->assertTrue($response[count($response) - 1]->endDate == $endDate);
  }

  /**
   * @group datesplitter
   * @test
   */
  public function it_splits_a_date_range_into_days()
  {
    $startDate = $this->createRandomDateTime();
    $endDate = $startDate->copy()->addDays(rand(4, 500));

    $response = $this->dateSplitter->split($startDate->copy(), $endDate->copy(), 'day');
    $days = $startDate->copy()->startOfDay()->diffInDays($endDate->copy()->endOfDay()) + 1;

    if (count($response) > 2) {
      // Check if response contains periods of 7 days
      $this->assertTrue($response[1]->startDate->diffInDays($response[1]->endDate->addSecond()->startOfDay()) == 1);
    }

    $this->assertTrue($days == count($response));
    $this->assertTrue($response[0]->startDate == $startDate);
    $this->assertTrue($response[count($response) - 1]->endDate == $endDate);
  }

  /**
   * @group datesplitter
   * @test
   */
  public function it_splits_a_date_range_into_hours()
  {
    $startDate = Carbon::create(rand(1985, 2016), rand(1, 12), rand(1, 28), rand(1, 23), rand(1, 59), 0);
    $endDate = $startDate->copy()->addDays(rand(1, 1));

    $response = $this->dateSplitter->split($startDate->copy(), $endDate->copy(), 'hour');

    // Start and end of hour is added to make sure count adds the gap if hour not starts and ends perfectly
    $hours = $startDate->copy()->startOfHour()->diffInHours($endDate->copy()->endOfHour()) + 1;
    $this->assertTrue($hours == count($response));
    $this->assertTrue($response[0]->startDate == $startDate);
    $this->assertTrue($response[count($response) - 1]->endDate == $endDate);
  }

  /**
   * @group datesplitter
   * @test
   */
  public function it_splits_a_date_range_when_start_and_end_date_is_the_same()
  {
    $testDate = Carbon::create(rand(1985, 2016), rand(1, 12), rand(1, 28), 0, 0, 0);

    foreach (['year', 'month', 'week', 'day'] as $periodType) {
      $response = $this->dateSplitter->split($testDate, $testDate, $periodType);
      $this->assertTrue($response[0]->startDate == $testDate);
      $this->assertTrue($response[0]->endDate == $testDate);
    }
  }

  /**
   * @group datesplitter
   * @test
   */
  public function it_splits_a_date_range_into_hours_when_start_and_end_date_is_the_same_day()
  {
    $testDate = Carbon::create(rand(1985, 2016), rand(1, 12), rand(1, 28), 0, 0, 0);

    $response = $this->dateSplitter->split($testDate, $testDate->copy()->endOfDay(), 'hour');

    $this->assertTrue($response[0]->startDate == $testDate);
    $this->assertTrue($response[23]->endDate == $testDate->copy()->endOfDay());

  }

  public function createRandomDateTime()
  {
    return Carbon::create(rand(1985, 2016), rand(1, 12), rand(1, 28), rand(1, 59), rand(1, 59), 0);
  }

}