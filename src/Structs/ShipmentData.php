<?php

namespace Montonio\Structs;

class ShipmentData extends AbstractStruct
{
    /**
     * @var ShippingAddress
     */
    protected $sender;

    /**
     * @var ShippingAddress
     */
    protected $receiver;

    /**
     * @var string
     */
    protected $merchantReference;

    /**
     * @var array
     */
    protected $shippingMethod;

    /**
     * @var array
     */
    protected $parcels = [];

    /**
     * Get sender address
     *
     * @return ShippingAddress
     */
    public function getSender(): ShippingAddress
    {
        return $this->sender;
    }

    /**
     * Set sender address
     *
     * @param ShippingAddress $sender
     * @return ShipmentData
     */
    public function setSender(ShippingAddress $sender): ShipmentData
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * Get receiver address
     *
     * @return ShippingAddress
     */
    public function getReceiver(): ShippingAddress
    {
        return $this->receiver;
    }

    /**
     * Set receiver address
     *
     * @param ShippingAddress $receiver
     * @return ShipmentData
     */
    public function setReceiver(ShippingAddress $receiver): ShipmentData
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * Get merchant reference
     *
     * @return string
     */
    public function getMerchantReference(): ?string
    {
        return $this->merchantReference;
    }

    /**
     * Set merchant reference
     *
     * @param string $merchantReference
     * @return ShipmentData
     */
    public function setMerchantReference(string $merchantReference): ShipmentData
    {
        $this->merchantReference = $merchantReference;
        return $this;
    }

    /**
     * Get shipping method
     *
     * @return array
     */
    public function getShippingMethod(): array
    {
        return $this->shippingMethod;
    }

    /**
     * Set shipping method
     *
     * @param array $shippingMethod
     * @return ShipmentData
     */
    public function setShippingMethod(array $shippingMethod): ShipmentData
    {
        $this->shippingMethod = $shippingMethod;
        return $this;
    }

    /**
     * Get parcels
     *
     * @return array
     */
    public function getParcels(): array
    {
        return $this->parcels;
    }

    /**
     * Set parcels
     *
     * @param array $parcels
     * @return ShipmentData
     */
    public function setParcels(array $parcels): ShipmentData
    {
        $this->parcels = $parcels;
        return $this;
    }

    /**
     * Add a parcel
     *
     * @param array $parcel
     * @return ShipmentData
     */
    public function addParcel(array $parcel): ShipmentData
    {
        $this->parcels[] = $parcel;
        return $this;
    }
}
