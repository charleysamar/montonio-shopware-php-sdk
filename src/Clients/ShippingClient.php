<?php

namespace Montonio\Clients;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Montonio\Structs\ShipmentData;
use Montonio\MockHandler;

class ShippingClient extends AbstractClient
{
    const SANDBOX_URL = '';
    const LIVE_URL = 'https://shipping.montonio.com/api/v2';
    private $mockHandler;

    /**
     * Get all available carriers.
     *
     * @return array
     * @throws Exception
     */
    public function getAllCarriers(): array
    {
        return $this->call('GET', $this->getUrl('/carriers'), null, $this->getHeaders());
    }

    /**
     * Get shipping methods for a specific store.
     *
     * @return array
     * @throws Exception
     */
    public function getShippingMethodsForStore(): array
    {
        return $this->call('GET', $this->getUrl("/shipping-methods"), null, $this->getHeaders());
    }

    /**
     * Get pickup points for a store.
     *
     * @param string $carrierCode
     * @param string $countryCode eg 'EE'
     * @return array
     * @throws Exception
     */
    public function getPickupPointsForStore(string $carrierCode, string $countryCode): array
    {
        return $this->call('GET', $this->getUrl("/shipping-methods/pickup-points?carrierCode={$carrierCode}&countryCode={$countryCode}"), null, $this->getHeaders());
    }

    /**
     * Get courier services for a store.
     *
     * @param string $carrierCode
     * @param string $countryCode
     * @return array
     * @throws Exception
     */
    public function getCourierServicesForStore(string $carrierCode, string $countryCode): array
    {
        return $this->call('GET', $this->getUrl("/shipping-methods/courier-services?carrierCode={$carrierCode}&countryCode={$countryCode}"), null, $this->getHeaders());
    }

    /**
     * Get possible shipping methods for given parcels.
     *
     * @param string $countryCode
     * @param array $payload eg ["parcels": [{"weight": 2, "length": 0.39, "width": 0.38, "height": 0.64}]]
     * @return array
     * @throws Exception
     */
    public function getPossibleShippingMethods(string $countryCode, array $payload): array
    {
        return $this->call('POST', $this->getUrl("/shipping-methods/filter-by-parcels?destination={$countryCode}"),  json_encode($payload), $this->getHeaders());
    }

    /**
     * Create a new shipment.
     *
     * @param ShipmentData $shipmentData
     * @return array
     * @throws Exception
     */
    public function createShipment(ShipmentData $shipmentData): array
    {
        return $this->call('POST', $this->getUrl('/shipments'), json_encode($shipmentData->toArray()), $this->getHeaders());
    }

    /**
     * Update an existing shipment.
     *
     * @param string $shipmentId
     * @param ShipmentData $updateData
     * @return array
     * @throws Exception
     */
    public function updateShipment(string $shipmentId, ShipmentData $updateData): array
    {
        return $this->call('PATCH', $this->getUrl("/shipments/{$shipmentId}"), json_encode($updateData->toArray()), $this->getHeaders());
    }

    /**
     * Get details of a specific shipment.
     *
     * @param string $shipmentId
     * @return array
     * @throws Exception
     */
    public function getShipmentDetails(string $shipmentId): array
    {
        return $this->call('GET', $this->getUrl("/shipments/{$shipmentId}"), null, $this->getHeaders());
    }

    /**
     * Create a label file for a shipment.
     *
     * @param string $shipmentId
     * @param array $labelData
     * @return array
     * @throws Exception
     */
    public function createLabelFile(string $shipmentId, array $labelData): array
    {
        // return $this->call('POST', $this->getUrl("/shipments/{$shipmentId}/label"), json_encode($labelData), $this->getHeaders());
        return [];
    }

    /**
     * Get a label file for a shipment.
     *
     * @param string $shipmentId
     * @return array
     * @throws Exception
     */
    public function getLabelFile(string $shipmentId): array
    {
        // return $this->call('GET', $this->getUrl("/shipments/{$shipmentId}/label"), null, $this->getHeaders());
        return [];
    }

    /**
     * Create a webhook.
     *
     * @param array $webhookData
     * @return array
     * @throws Exception
     */
    public function createWebhook(array $webhookData): array
    {
        // return $this->call('POST', $this->getUrl('/webhooks'), json_encode($webhookData), $this->getHeaders());
        return [];
    }

    /**
     * Get all registered webhooks.
     *
     * @return array
     * @throws Exception
     */
    public function getAllWebhooks(): array
    {
        return $this->call('GET', $this->getUrl('/webhooks'), null, $this->getHeaders());
    }

    /**
     * Delete a webhook.
     *
     * @param string $webhookId
     * @return array
     * @throws Exception
     */
    public function deleteWebhook(string $webhookId): array
    {
        return $this->call('DELETE', $this->getUrl("/webhooks/{$webhookId}"), null, $this->getHeaders());
    }

    /**
     * Construct the URL based on the environment.
     *
     * @param string $path
     * @return string
     */
    protected function getUrl(string $path): string
    {
        $baseUrl = $this->isSandbox() ? self::SANDBOX_URL : self::LIVE_URL;
        return $baseUrl . (substr($path, 0, 1) === '/' ? '' : '/') . $path;
    }

    /**
     * @return string
     */
    protected function getBearerToken(): string
    {
        return JWT::encode(
            [
                'accessKey' => $this->getAccessKey(),
            ],
            $this->getSecretKey(),
            static::ENCODING_ALGORITHM
        );
    }
    /**
     * Get common headers for API requests.
     *
     * @return array
     */
    private function getHeaders(): array
    {
        return [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->getBearerToken(),
        ];
    }

    private function getMockHandler(): MockHandler
    {
		if( !isset( $this->mockHandler ) )
		{
			$this->mockHandler = new MockHandler();
		}

		return $this->mockHandler;
    }
    /**
     * @throws Exception
     */
    protected function call($method, $url, $payload, $headers)
    {
        if ($this->isSandbox()) {
            return $this->getMockHandler()->getMockResponse($method, $url, $payload, $headers);
        }

        return parent::call($method, $url, $payload, $headers);
    }
}
