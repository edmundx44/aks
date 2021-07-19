<?php

namespace Tests\Unit;

use App\Models\AffiliateUtility;
use \PHPUnit\Framework\TestCase;

class ExampleAssertionsTest extends TestCase
{
    
    public function testStringMatch()
    {
        $string1 = "testing";
        $string2 = "testing";
        $string3 = "Testing";

        $this->assertSame($string1,$string2);
        //$this->assertSame($string1,$string3);
    }

    public function testThatNumbersAddUp()
    {
        $this->assertEquals(10, 5+5);
    }

    public function affiliateTest()
    {
        $test = new AffiliateUtility;

        print_r($test->returnData());
    }
}