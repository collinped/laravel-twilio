<?php

namespace Collinped\Twilio;

use Illuminate\Support\Str;
use Twilio\Rest\Client;

class TwilioPay
{
    private \Twilio\Rest\Client $twilio;

    private string $callSid;

    private string $indempotencyKey;

    private string $statusCallbackUrl;

    private string $paymentSid;

    private string $bankAccountType;

    private string $currency = 'USD';

    private string $description;

    private string $paymentConnector = 'Default';

    private string $paymentMethod;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    public function create(array $options): \Twilio\Rest\Api\V2010\Account\Call\PaymentInstance
    {
        return $this->twilio
            ->calls($this->callSid)
            ->payments
            ->create($this->indempotencyKey, $this->statusCallbackUrl, $options);
    }

    // payment-card-number, expiration-date, security-code, postal-code, bank-routing-number, or bank-account-number
    public function capture(string $captureMethod): \Twilio\Rest\Api\V2010\Account\Call\PaymentInstance
    {
        return $this->twilio
            ->calls($this->callSid)
            ->payments($this->paymentSid)
            ->update(
                $this->indempotencyKey,
                $this->statusCallbackUrl,
                ['capture' => $captureMethod]
            );
    }

    public function cancel(): \Twilio\Rest\Api\V2010\Account\Call\PaymentInstance
    {
        return $this->twilio
            ->calls($this->callSid)
            ->payments($this->paymentSid)
            ->update(
                $this->indempotencyKey,
                $this->statusCallbackUrl,
                ['status' => 'cancel']
            );
    }

    public function complete(): \Twilio\Rest\Api\V2010\Account\Call\PaymentInstance
    {
        return $this->twilio
            ->calls($this->callSid)
            ->payments($this->paymentSid)
            ->update(
                $this->indempotencyKey,
                $this->statusCallbackUrl,
                ['status' => 'complete']
            );
    }

    public function call($callSid): static
    {
        $this->callSid = $callSid;

        return $this;
    }

    public function payment($paymentSid): static
    {
        $this->paymentSid = $paymentSid;

        return $this;
    }

    public function generateIndempotencyKey($length = 16): string
    {
        return Str::random($length);
    }

    public function indempotencyKey($indempotencyKey): static
    {
        $this->indempotencyKey = $indempotencyKey;

        return $this;
    }

    public function statusCallbackUrl(string $statusCallbackUrl): static
    {
        $this->statusCallbackUrl = $statusCallbackUrl;

        return $this;
    }

    // consumer-checking, consumer-savings, commercial-checking
    public function bankAccount($bankAccountType = 'consumer-checking'): static
    {
        $this->bankAccountType = $bankAccountType;

        return $this;
    }

    public function creditCard()
    {
        $this->paymentMethod = 'credit-card';

        return $this;
    }

    public function ach()
    {
        $this->paymentMethod = 'ach-debit';

        return $this;
    }

    public function amount($chargeAmount): static
    {
        $this->chargeAmount = $chargeAmount;

        return $this;
    }

    public function currency($currency = 'USD')
    {
        $this->currency = $currency;

        return $this;
    }

    public function description($description)
    {
        $this->description = $description;

        return $this;
    }

    public function paymentConnector($paymentConnector)
    {
        $this->paymentConnector = $paymentConnector;

        return $this;
    }
}
