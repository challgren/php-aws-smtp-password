<?php
namespace PhpAwsSmtpPassword\Test\TestCase;

use PhpAwsSmtpPassword\PhpAwsSmtpPassword;
use PHPUnit\Framework\TestCase;

class PhpAwsSmtpPasswordTest extends TestCase
{
    protected $key = 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY';
    protected $region = 'us-east-1';

    /**
     * Tests the convert function
     */
    public function testConvert()
    {
        $expected = 'BLBM/9hSUELfq8Gw+rU1YcBjkOxGbhT2XG763xVLGWL9';

        $this->assertEquals($expected, PhpAwsSmtpPassword::convert($this->key, $this->region));
    }

    public function testConvertInvalidRegion()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('us-central-1 is not setup for SES.');
        PhpAwsSmtpPassword::convert($this->key, 'us-central-1');
    }
}
