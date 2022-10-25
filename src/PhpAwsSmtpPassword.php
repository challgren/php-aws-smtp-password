<?php

namespace PhpAwsSmtpPassword;

class PhpAwsSmtpPassword
{
    protected static $allowed_regions = [
        'us-east-1',       # US East (N. Virginia)
        'us-east-2',       # US East (Ohio)
        'us-west-1',       # US West (N. California)
        'us-west-2',       # US West (Oregon)
        'af-south-1',      # Africa (Cape Town)
        'ap-south-1',      # Asia Pacific (Mumbai)
        'ap-northeast-2',  # Asia Pacific (Seoul)
        'ap-southeast-1',  # Asia Pacific (Singapore)
        'ap-southeast-2',  # Asia Pacific (Sydney)
        'ap-northeast-1',  # Asia Pacific (Tokyo)
        'ca-central-1',    # Canada (Central)
        'eu-central-1',    # Europe (Frankfurt)
        'eu-west-1',       # Europe (Ireland)
        'eu-west-2',       # Europe (London)
        'eu-south-1',      # Europe (Milan)
        'eu-west-3',       # Europe (Paris)
        'eu-north-1',      # Europe (Stockholm)
        'me-south-1',      # Middle East (Bahrain)
        'sa-east-1',       # South America (Sao Paulo)
        'us-gov-west-1',   # AWS GovCloud (US)
    ];

    /**
     * Per https://docs.aws.amazon.com/ses/latest/DeveloperGuide/smtp-credentials.html this should never change
     * @var string Date to hash with
     */
    protected static $date = '11111111';

    /**
     * Per https://docs.aws.amazon.com/ses/latest/DeveloperGuide/smtp-credentials.html this should never change
     * @var string Service to hash with
     */
    protected static $service = 'ses';

    /**
     * Per https://docs.aws.amazon.com/ses/latest/DeveloperGuide/smtp-credentials.html this should never change
     * @var string Terminal to hash with
     */
    protected static $terminal = 'aws4_request';

    /**
     * Per https://docs.aws.amazon.com/ses/latest/DeveloperGuide/smtp-credentials.html this should never change
     * @var string Message to hash with
     */
    protected static $message = 'SendRawEmail';

    /**
     * Per https://docs.aws.amazon.com/ses/latest/DeveloperGuide/smtp-credentials.html this should never change
     * @var string Version to hash with
     */
    protected static $version = 0x04;

    /**
     * Converts a secret key to a password that can be used with SMTP
     *
     * @param string $key Access secret key
     * @param string $region AWS Region
     * @return string SMTP password
     */
    public static function convert($key, $region)
    {
        $region = strtolower($region);
        if (!in_array($region, PhpAwsSmtpPassword::$allowed_regions)) {
            throw new \InvalidArgumentException($region . ' is not setup for SES.');
        }
        $signature = hash_hmac('sha256', PhpAwsSmtpPassword::$date, 'AWS4' . $key, true);
        $signature = hash_hmac('sha256', $region, $signature, true);
        $signature = hash_hmac('sha256', PhpAwsSmtpPassword::$service, $signature, true);
        $signature = hash_hmac('sha256', PhpAwsSmtpPassword::$terminal, $signature, true);
        $signature = hash_hmac('sha256', PhpAwsSmtpPassword::$message, $signature, true);
        $signatureAndVersion = chr(PhpAwsSmtpPassword::$version) . $signature;

        return base64_encode($signatureAndVersion);
    }
}
