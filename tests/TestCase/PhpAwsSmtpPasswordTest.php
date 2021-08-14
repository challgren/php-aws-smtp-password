<?php
namespace PhpAwsSmtpPassword\Test\TestCase;

use PhpAwsSmtpPassword\PhpAwsSmtpPassword;
use PHPUnit\Framework\TestCase;

class PhpAwsSmtpPasswordTest extends TestCase
{
    /**
     * Tests the convert function
     */
    public function testConvert()
    {
        $key = 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY';
        $region = 'us-east-1';
        $expected = 'WzRdsEz/2FJQQt+rwbD6tTVhwGOQ7EZuFPZcbvrfFUsZYv0=';

        $this->assertEquals($expected, PhpAwsSmtpPassword::convert($key, $region));
    }
}
