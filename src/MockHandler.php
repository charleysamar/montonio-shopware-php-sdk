<?php
namespace Montonio;

use Exception;
use Montonio\Clients\ShippingClient;
use Montonio\Exception\RequestException;

class MockHandler
{
    private function getUrl(string $path): string
    {
        $baseUrl = ShippingClient::SANDBOX_URL;
        return $baseUrl . (substr($path, 0, 1) === '/' ? '' : '/') . $path;
    }

    public function getMockResponse($method, $url, $payload, $headers)
    {

        // check headers for Authorization
        $authorizationValue = $this->getAuthorizationValueFromHeader($headers);

        if( $authorizationValue && $this->isJwt($authorizationValue) ) {

            $getMocks = [
                $this->getUrl('/carriers') => 'carriers.json',
                $this->getUrl('/shipping-methods') => 'shipping_methods.json',
                $this->getUrl('/shipping-methods/pickup-points?carrierCode=dpd&countryCode=EE') => 'pickup_points_ee_dpd.json',
                $this->getUrl('/shipping-methods/pickup-points?carrierCode=omniva&countryCode=EE') => 'pickup_points_ee_omniva.json',
                $this->getUrl('/shipping-methods/pickup-points?carrierCode=smartpost&countryCode=EE') => 'pickup_points_ee_smartpost.json',
                $this->getUrl('/shipping-methods/courier-services?carrierCode=dpd&countryCode=EE') => 'courier_services_ee_dpd.json',
                $this->getUrl('/shipping-methods/courier-services?carrierCode=omniva&countryCode=EE') => 'courier_services_ee_omniva.json',
                $this->getUrl('/shipping-methods/courier-services?carrierCode=omniva&countryCode=EE') => 'courier_services_ee_smartpost.json',
            ];

            $postMocks = [
                $this->getUrl('/shipping-methods/filter-by-parcels?destination=EE') => 'filter_by_parcels_ee.json',
                $this->getUrl('/shipments') => 'create_shipment.json',
            ];

            if ($method === 'GET' && strpos($url, $this->getUrl('/shipments/')) === 0) {
                $jsonResponse =$this->loadMockData('get_shipment_by_id.json');
                return $this->replaceDynamicJsonValues($url, $payload, $jsonResponse);
            } else if (isset($getMocks[$url]) && $method === 'GET') {
                return $this->loadMockData($getMocks[$url]);
            } else if (isset($postMocks[$url]) && $method === 'POST') {
                $jsonResponse = $this->loadMockData($postMocks[$url]);
                return $this->replaceDynamicJsonValues($url, $payload, $jsonResponse);
            }

            throw new RequestException(
                '',
                404,
                ''
            );
        }

        throw new RequestException(
            '',
            401,
            ''
        );
    }

    private function getAuthorizationValueFromHeader($headers)
    {
        foreach ($headers as $header) {
            if (strpos($header, 'Authorization:') === 0) {
                return str_replace('Authorization: Bearer ', '', $header);
            }
        }

        return '';
    }

    private function isJwt($value)
    {
        return preg_match('/^[A-Za-z0-9_-]{2,}(?:\.[A-Za-z0-9_-]{2,}){2}$/', $value);
    }

    private function loadMockData(string $filename): array
    {
        $filePath = __DIR__ . '/../tests/mocks/' . $filename;
        if (!file_exists($filePath)) {
            throw new Exception("Mock file {$filename} not found.");
        }
    
        $json = file_get_contents($filePath);
        return json_decode($json, true);
    }

    private function replaceDynamicJsonValues(string $url, ?string $payload, array $data): array
    {
        $payload = json_decode($payload ?? '{}', true);

        if( $url === $this->getUrl('/shipments') ) {
            $data['merchantReference'] = $payload['merchantReference'];
            $data['orderId'] = $payload['merchantReference'];
            $data['shippingMethod']['id'] = $payload['shippingMethod']['id'];

            $data['sender'] = ["id" => $this->uuidv4()] + $payload['sender'];
            $data['receiver'] = ["id" => $this->uuidv4()] + $payload['receiver'];

            $montonioOrderId = $payload['montonioOrderUuid'] ?? $this->uuidv4();
            $data['montonioOrderUuid'] = $montonioOrderId;
            $data['montonioOrderId'] = $montonioOrderId;

            $data['id'] = $this->uuidv4();
            $data['store']['id'] = $this->uuidv4();
            foreach ($data['parcels'] as $key => $parcel) {
                $data['parcels'][$key]['id'] = $this->uuidv4();
            }

            $data['createdAt'] = date('Y-m-d\TH:i:s.u\Z');
        } else if ( strpos($url, $this->getUrl('/shipments/')) === 0 ) {
            $data['id'] = str_replace($this->getUrl('/shipments/'), '', $url);
            $data['createdAt'] = date('Y-m-d\TH:i:s.u\Z');

            foreach ($data['parcels'] as $key => $parcel) {
                $parcelId = $this->uuidv4();
                $data['parcels'][$key]['carrierParcelId'] = $parcelId;
                $data['parcels'][$key]['trackingLink'] = "https://www.dpdgroup.com/ee/mydpd/my-parcels/track?lang=et&parcelNumber=" . $parcelId;
            }
        }


       return $data;
    }
    public function uuidv4(): string
    {
      $data = random_bytes(16);

      $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
      $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

      return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
