# php-aws-smtp-password
Converts an AWS secret access key to a SMTP password.

This library helps you convert and IAM user credentials to SES SMTP credentials.

The SMTP username is the Access Key ID. The password can be derived by using a formula provided by AWS at https://docs.aws.amazon.com/ses/latest/DeveloperGuide/smtp-credentials.html 

## Installation
PhpAwsSmtpPassword convert is available on Packagist (using semantic versioning), and installation via Composer is the recommended way to install this. Just add this line to your `composer.json` file:
```json
"challgren/php-aws-smtp-password": "^1.0"
```
or run
```
composer require challgren/php-aws-smtp-password
```

## A Simple example

```php
<?php
use PhpAwsSmtpPassword\PhpAwsSmtpPassword;

$smtp_password = PhpAwsSmtpPassword::convert($key, $region)
```
 
