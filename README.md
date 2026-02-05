# Laravel ApcoPay

Laravel integration for the ApcoPay payment gateway: hosted payment page and payment status (GetPayment / PreparePayment).

## Requirements

- PHP 8.2+
- Laravel 10.x, 11.x or 12.x
- GuzzleHTTP 7.x

## Installation

```bash
composer require bornmt/laravel-apcopay
```

Publish the config file (optional; defaults are used from the package):

```bash
php artisan vendor:publish --tag=apcopay-config
```

## Configuration

Add to your `.env`:

```env
APCO_PAY_ENV=local
APCO_PAY_USERNAME=
APCO_PAY_PASSWORD=
APCO_PAY_PID=
APCOPAY_BASE_URL=https://www.apsp.biz/GPG/RESTAPI/api/OnlinePayments
APCOPAY_SANDBOX_BASE_URL=https://www.apsp.biz/GPGTest/RESTAPI/api/OnlinePayments
```

Set `APCO_PAY_ENV=production` for live payments.

## Usage

Inject `BornMT\ApcoPay\Contracts\ApcoPayServiceInterface`:

```php
use BornMT\ApcoPay\Contracts\ApcoPayServiceInterface;
use BornMT\ApcoPay\Enums\PaymentStateFields;

// Get hosted page URL for redirect
$response = $apcoPay->getHostedPage(
    sessionReference: $sessionReference,
    amount: $amount,
    returnUrl: $returnUrl
);
$paymentUrl = $response['paymentURLField'];

// Get payment status
$payment = $apcoPay->getPayment($sessionReference);

// Get payment with retries (e.g. while processing)
$payment = $apcoPay->getPaymentWithRetry($sessionReference, 3);

// Check state
PaymentStateFields::CANCELLED->value; // 2
PaymentStateFields::SUCCESS->value;   // 3
PaymentStateFields::FAILED->value;    // 4
```

Exceptions: the service throws `BornMT\ApcoPay\Exceptions\ApcoPayException` on API or retry failures.

## License

The MIT License (MIT). Please see the [License File](LICENSE) for more information.
