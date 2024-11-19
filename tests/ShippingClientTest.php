<?php

namespace Montonio\Tests;

use Montonio\Clients\AbstractClient;
use Montonio\Clients\ShippingClient;
use Montonio\Structs\ShipmentData;
use Montonio\Structs\ShippingAddress;
use PHPUnit\Framework\TestCase;

class ShippingClientTest extends TestCase
{
    protected $config = [
        'accessKey' => '',
        'secretKey' => '',
    ];

    private $carrierCode = 'dpd';
    private $countryCode = 'EE';
    private $shipmentId = '';

    public function testGetAllCarriers()
    {
        $shippingClient = new ShippingClient($this->config['accessKey'], $this->config['secretKey'], AbstractClient::ENVIRONMENT_SANDBOX);
        $carriers = $shippingClient->getAllCarriers();

        $this->assertTrue(!empty($carriers));
        $this->assertArrayHasKey('carriers', $carriers);
    }

    public function testGetShippingMethodsForStore()
    {
        $shippingClient = new ShippingClient($this->config['accessKey'], $this->config['secretKey'], AbstractClient::ENVIRONMENT_SANDBOX);
        $shippingMethods = $shippingClient->getShippingMethodsForStore();

        $this->assertTrue(!empty($shippingMethods));
        $this->assertArrayHasKey('countries', $shippingMethods);
    }

    public function testGetPickupPointsForStore()
    {
        $shippingClient = new ShippingClient($this->config['accessKey'], $this->config['secretKey'], AbstractClient::ENVIRONMENT_SANDBOX);
        $pickupPoints = $shippingClient->getPickupPointsForStore($this->carrierCode, $this->countryCode);

        $this->assertTrue(!empty($pickupPoints));
        $this->assertArrayHasKey('pickupPoints', $pickupPoints);
    }

    public function testGetCourierServicesForStore()
    {
        $shippingClient = new ShippingClient($this->config['accessKey'], $this->config['secretKey'], AbstractClient::ENVIRONMENT_SANDBOX);
        $courierServices = $shippingClient->getCourierServicesForStore($this->carrierCode, $this->countryCode);

        $this->assertTrue(!empty($courierServices));
        $this->assertArrayHasKey('courierServices', $courierServices);

        $this->assertEquals($this->countryCode, $courierServices['countryCode']);
    }

    public function testGetPossibleShippingMethods()
    {
        $shippingClient = new ShippingClient($this->config['accessKey'], $this->config['secretKey'], AbstractClient::ENVIRONMENT_SANDBOX);

        $payload = [
            'parcels' => [
                [
                    'weight' => 2,
                    'length' => 0.39,
                    'width' => 0.38,
                    'height' => 0.64,
                ],
            ],
        ];

        $shippingMethods = $shippingClient->getPossibleShippingMethods($this->countryCode, $payload);

        $this->assertTrue(!empty($shippingMethods));
        $this->assertArrayHasKey('countries', $shippingMethods);
    }

    public function testCreateShipment()
    {
        $shippingClient = new ShippingClient($this->config['accessKey'], $this->config['secretKey'], AbstractClient::ENVIRONMENT_SANDBOX);

        $referenceId = uniqid("TEST");
        $shipmentData = (new ShipmentData())
            ->setMerchantReference($referenceId)
            ->setShippingMethod([
                'type' => 'courier',
                'id' => 'f21430bd-c0e6-4470-a7da-1702e9c7879e',
            ])
            ->setSender(
                (new ShippingAddress())
                    ->setName('Sender Y')
                    ->setCompanyName('Company Y')
                    ->setStreetAddress('Kai 1')
                    ->setLocality('Tallinn')
                    ->setRegion('Harjumaa')
                    ->setPostalCode('10111')
                    ->setCountry('EE')
                    ->setPhoneCountryCode('372')
                    ->setPhoneNumber('53334770')
                    ->setEmail('support@montonio.com')
            )
            ->setReceiver(
                (new ShippingAddress())
                    ->setName('Receiver X')
                    ->setCompanyName('Company X')
                    ->setStreetAddress('Kai 11')
                    ->setLocality('Tallinn')
                    ->setRegion('Harjumaa')
                    ->setPostalCode('10111')
                    ->setCountry('EE')
                    ->setPhoneCountryCode('372')
                    ->setPhoneNumber('53334770')
                    ->setEmail('support@montonio.com')
            )
            ->addParcel(['weight' => 1]);

        $shipment = $shippingClient->createShipment($shipmentData);

        $this->assertTrue(!empty($shipment));
        $this->assertTrue(isset($shipment['orderId']) && $shipment['orderId'] == $referenceId);
    }

    public function testGetShipmentDetails()
    {
        $shippingClient = new ShippingClient($this->config['accessKey'], $this->config['secretKey'], AbstractClient::ENVIRONMENT_SANDBOX);
        $shipment = $shippingClient->getShipmentDetails($this->shipmentId);

        $this->assertTrue(!empty($shipment));
    }
}
