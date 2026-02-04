<?php

namespace BornMT\ApcoPay\Services;

use BornMT\ApcoPay\Contracts\ApcoPayServiceInterface;
use BornMT\ApcoPay\Exceptions\ApcoPayException;
use BornMT\ApcoPay\Support\Configuration;
use Exception;
use GuzzleHttp\Client;

class ApcoPayService implements ApcoPayServiceInterface
{
    public function __construct(
        public Configuration $configuration,
        private ?Client $client = null
    ) {
        $this->client ??= new Client();
    }

    public function getHostedPage(
        string $sessionReference,
        float $amount,
        string $returnUrl
    ): array {
        $url = $this->configuration->url . '/PreparePayment';

        $data = [
            'SenderId' => $this->configuration->pid,
            'Username' => $this->configuration->username,
            'Password' => $this->configuration->password,
            'MessageId' => '',
            'ProviderAccountId' => '',
            'ProviderReferences' => '',
            'PaymentSessionProviderReference' => $sessionReference,
            'AmountInCents' => $amount * 100,
            'ReturnURL' => $returnUrl,
            'Language' => 0,
            'HPType' => 1,
            'DynamicAmount' => false,
            'InlineFrame' => false,
        ];

        return $this->sendRequest($url, $data);
    }

    public function getPayment(string $sessionReference): array
    {
        $url = $this->configuration->url . '/GetPayment';

        $data = [
            'SenderId' => $this->configuration->pid,
            'Username' => $this->configuration->username,
            'Password' => $this->configuration->password,
            'MessageId' => '',
            'PaymentId' => '',
            'PaymentSessionProviderReference' => $sessionReference,
        ];

        return $this->sendRequest($url, $data);
    }

    public function getPaymentWithRetry(string $sessionReference, int $retries = 3): array
    {
        $payment = [];
        for ($i = 1; $i <= $retries; $i++) {
            try {
                $payment = $this->getPayment($sessionReference);
                if (($payment['paymentStateField'] ?? null) == 1) {
                    sleep(5);
                    continue;
                }
                break;
            } catch (Exception $e) {
                if ($i == $retries) {
                    throw new ApcoPayException(
                        __('Error getting the payment'),
                        400
                    );
                }
                sleep(5);
                continue;
            }
        }

        return $payment;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendRequest(string $url, array $data = [], string $method = 'POST'): array
    {
        try {
            $headers = [
                'User-Agent' => 'browser/1.0',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            $result = $this->client->request($method, $url, [
                'headers' => $headers,
                'json' => $data,
            ]);

            $contents = $result->getBody()->getContents();

            return json_decode($contents, true) ?? [];
        } catch (Exception $e) {
            throw new ApcoPayException(
                $e->getMessage(),
                $e->getCode()
            );
        }
    }
}
