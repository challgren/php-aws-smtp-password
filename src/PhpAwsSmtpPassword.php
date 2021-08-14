<?php

namespace PhpAwsSmtpPassword;

class PhpAwsSmtpPassword
{
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
    protected static $version = '[4]';

    /**
     * Converts a secret key to a password that can be used with SMTP
     *
     * @param string $key Access secret key
     * @param string $region AWS Region
     * @return string SMTP password
     */
    public static function convert($key, $region)
    {
        $signature = hash_hmac('sha256', PhpAwsSmtpPassword::$date, 'AWS4' . $key, true);
        $signature = hash_hmac('sha256', $region, $signature, true);
        $signature = hash_hmac('sha256', PhpAwsSmtpPassword::$service, $signature, true);
        $signature = hash_hmac('sha256', PhpAwsSmtpPassword::$terminal, $signature, true);
        $signature = hash_hmac('sha256', PhpAwsSmtpPassword::$message, $signature, true);
        $signatureAndVersion = PhpAwsSmtpPassword::$version . $signature;

        return base64_encode($signatureAndVersion);
    }
}
