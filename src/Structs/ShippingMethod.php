<?php

namespace Montonio\Structs;

class ShippingMethod extends AbstractStruct
{

    protected string $type;
    protected string $id;


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type e.g. courier, pickupPoint
     * @return ShippingMethod
     */
    public function setType(string $type): ShippingMethod
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id e.g. b8a6ade6-36a8-4546-9054-173b33321956
     * @return ShippingMethod
     */
    public function setId(string $id): ShippingMethod
    {
        $this->id = $id;
        return $this;
    }

}