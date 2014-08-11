<?php

use ordbild\Calendar;

class CalendarTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    // tests
    public function testDefaultDates()
    {
        $calendar = new Calendar;
        $this->assertEquals('2014', $calendar->year);
        $this->assertEquals('08', $calendar->month);
        $calendar2 = new Calendar(array(
            'year' => '2014',
            'month' => '09'
        ));
        $this->assertEquals('09', $calendar2->month);
    }

    public function test_month_name()
    {
        $calendar = new Calendar;
        $this->assertEquals('Augusti', $calendar->month_name);
        $calendar2 = new Calendar(array(
            'year' => '2014',
            'month' => '09'
        ));
        $this->assertEquals('September', $calendar2->month_name);
    }

    public function test_week_number()
    {
        $calendar = new Calendar;
        $this->assertEquals('33', $calendar->week);
        $c2 = new Calendar(array(
            'year' => '2014',
            'month' => '09',
            'day' => '01'
        ));
        $this->assertEquals('36', $c2->week);
    }

    public function test_days_in_month()
    {
        $calendar = new Calendar;
        $calendar2 = new Calendar(array(
            'year' => '2014',
            'month' => '09',
            'day' => '01'
        ));
        $this->assertEquals('31', $calendar->days_in_month);
        $this->assertEquals('30', $calendar2->days_in_month);
    }

}