<?php

namespace Montonio\Structs;

class ShippingAddress extends AbstractStruct
{

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $phoneCountryCode;

    /**
     * @var string
     */
    protected string $phoneNumber;

    /**
     * @var string
     */
    protected ?string $companyName = null;

    /**
     * @var string
     */
    protected ?string $streetAddress = null;

    /**
     * @var string
     */
    protected ?string $locality = null;

    /**
     * @var string
     */
    protected ?string $region = null;

    /**
     * @var string
     */
    protected ?string $postalCode = null;

    /**
     * @var string
     */
    protected ?string $country = null;

    /**
     * @var string
     */
    protected ?string $email = null;


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ShippingAddress
     */
    public function setName(string $name): ShippingAddress
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneCountryCode(): string
    {
        return $this->phoneCountryCode;
    }

    /**
     * @param string $phoneCountryCode eg 372
     * @return ShippingAddress
     */
    public function setPhoneCountryCode(string $phoneCountryCode): ShippingAddress
    {
        $this->phoneCountryCode = $phoneCountryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber eg 5555555
     * @return ShippingAddress
     */
    public function setPhoneNumber(string $phoneNumber): ShippingAddress
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return ShippingAddress
     */
    public function setCompanyName(?string $companyName): ShippingAddress
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }

    /**
     * @param string $streetAddress
     * @return ShippingAddress
     */
    public function setStreetAddress(string $streetAddress): ShippingAddress
    {
        $this->streetAddress = $streetAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocality(): ?string
    {
        return $this->locality;
    }

    /**
     * @param string $locality
     * @return ShippingAddress
     */
    public function setLocality(string $locality): ShippingAddress
    {
        $this->locality = $locality;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param string $region
     * @return ShippingAddress
     */
    public function setRegion(string $region): ShippingAddress
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return ShippingAddress
     */
    public function setPostalCode(string $postalCode): ShippingAddress
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return ShippingAddress
     */
    public function setCountry(string $country): ShippingAddress
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return ShippingAddress
     */
    public function setEmail(string $email): ShippingAddress
    {
        $this->email = $email;
        return $this;
    }

}