<?php

namespace Montonio\Structs;

class PaymentMethodOptions extends AbstractStruct
{
    /**
     * @var string
     */
    protected $paymentDescription;

    /**
     * @var string
     */
    protected $paymentReference;

    /**
     * @var string
     */
    protected $preferredCountry;

    /**
     * @var string
     */
    protected $preferredProvider;

    /**
     * @var string
     */
    protected $preferredLocale;

    /**
     * @var string
     */
    protected $preferredMethod;

    /**
     * @var int
     */
    protected $period;

    /**
     * @return string
     */
    public function getPaymentDescription(): ?string
    {
        return $this->paymentDescription;
    }

    /**
     * @param string $paymentDescription
     * @return PaymentMethodOptions
     */
    public function setPaymentDescription(string $paymentDescription): PaymentMethodOptions
    {
        $this->paymentDescription = $paymentDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getPreferredCountry(): ?string
    {
        return $this->preferredCountry;
    }

    /**
     * @param string $preferredCountry
     * @return PaymentMethodOptions
     */
    public function setPreferredCountry(string $preferredCountry): PaymentMethodOptions
    {
        $this->preferredCountry = $preferredCountry;
        return $this;
    }

    /**
     * @return string
     */
    public function getPreferredProvider(): ?string
    {
        return $this->preferredProvider;
    }

    /**
     * @param string $preferredProvider
     * @return PaymentMethodOptions
     */
    public function setPreferredProvider(string $preferredProvider): PaymentMethodOptions
    {
        $this->preferredProvider = $preferredProvider;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentReference(): ?string
    {
        return $this->paymentReference;
    }

    /**
     * @param string $paymentReference
     * @return PaymentMethodOptions
     */
    public function setPaymentReference(string $paymentReference): PaymentMethodOptions
    {
        $this->paymentReference = $paymentReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getPreferredLocale(): ?string
    {
        return $this->preferredLocale;
    }

    /**
     * @param string $preferredLocale
     * @return PaymentMethodOptions
     */
    public function setPreferredLocale(string $preferredLocale): PaymentMethodOptions
    {
        $this->preferredLocale = $preferredLocale;
        return $this;
    }

    public function getPreferredMethod(): string
    {
        return $this->preferredMethod;
    }

    public function setPreferredMethod(string $preferredMethod): PaymentMethodOptions
    {
        $this->preferredMethod = $preferredMethod;
        return $this;
    }

    public function getPeriod(): ?int
    {
        return $this->period;
    }

    public function setPeriod(int $period): PaymentMethodOptions
    {
        $this->period = $period;
        return $this;
    }
}
