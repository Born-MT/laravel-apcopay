<?php

namespace BornMT\ApcoPay\Contracts;

interface ApcoPayServiceInterface
{
    public function getHostedPage(string $sessionReference, float $amount, string $returnUrl);

    public function getPayment(string $sessionReference);

    public function getPaymentWithRetry(string $sessionReference, int $retries = 3);
}
