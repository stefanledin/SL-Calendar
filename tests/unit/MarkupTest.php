<?php

use ordbild\Calendar;
use ordbild\Markup;

class MarkupTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    // tests
    public function test_header()
    {
        $markup = new Markup(new Calendar('2014', '08'));
        $header = '<caption><a href="#" title="" class="prev"></a>Augusti 2014<a href="#" title="" class="next"></a></caption>';
        $this->assertEquals($header, $markup->header());

        $markup2 = new Markup(new Calendar('2015', '01'));
        $header2 = '<caption><a href="#" title="" class="prev"></a>Januari 2015<a href="#" title="" class="next"></a></caption>';
        $this->assertEquals($header2, $markup2->header());
    }

    public function test_week()
    {
        $markup = new Markup(new Calendar);
        #$markup->weeks();        
    }

    public function test_day()
    {
        $october = new Markup(new Calendar('2014', '10'));
        $first_row = '<tr><td colspan="2"></td><td>1</td>';
        $last_row = '<td>31</td><td colspan="2"></td></tr>';
        $this->assertEquals($first_row, $october->day(strtotime('2014-10-01'),1));
        $this->assertEquals($last_row, $october->day(strtotime('2014-10-31'), 31));

        $september = new Markup(new Calendar('2014', '09'));
        $last_row_with_offset = '<td>30</td><td colspan="5"></td></tr>';
        $this->assertEquals($last_row_with_offset, $september->day(strtotime('2014-09-30'), 30));

        $august = new Markup(new Calendar('2014', '08'));
        $last_row_without_offset = '<td>31</td></tr>';
        $this->assertEquals($last_row_without_offset, $august->day(strtotime('2014-08-31'), 31));
    } 

}