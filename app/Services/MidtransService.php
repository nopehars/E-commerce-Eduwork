<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected $serverKey;
    protected $clientKey;
    protected $isProduction;
    protected $apiUrl;

    public function __construct()
    {
        $this->serverKey = env('MIDTRANS_SERVER_KEY');
        $this->clientKey = env('MIDTRANS_CLIENT_KEY');
        $this->isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        $this->apiUrl = $this->isProduction
            ? 'https://app.midtrans.com/snap/v1'
            : 'https://app.sandbox.midtrans.com/snap/v1';
    }

    public function createSnapToken($orderId, $totalAmount, $user, $itemDetails = null)
    {
        try {
            // Check if keys are properly configured
            if (strpos($this->serverKey, 'YOUR_SERVER_KEY') !== false ||
                strpos($this->clientKey, 'YOUR_CLIENT_KEY') !== false ||
                empty($this->serverKey) || empty($this->clientKey)) {

                Log::warning('Midtrans keys not configured, using test token', [
                    'order_id' => $orderId,
                ]);

                // Return a test token for development
                return 'test-snap-token-' . uniqid() . '-' . $orderId;
            }

            $client = new Client();

            $transactionDetails = [
                'order_id' => (string)$orderId,
                'gross_amount' => (int)$totalAmount,
            ];

            $customerDetails = [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '-',
            ];

            $payload = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $itemDetails ?? [
                    [
                        'id' => $orderId,
                        'price' => (int)$totalAmount,
                        'quantity' => 1,
                        'name' => 'Order #' . $orderId,
                    ]
                ],
            ];

            $response = $client->post($this->apiUrl . '/transactions', [
                'auth' => [$this->serverKey, ''],
                'json' => $payload,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['token'])) {
                return $result['token'];
            }

            Log::error('Midtrans token creation failed', ['response' => $result]);
            throw new \Exception('Failed to create Snap token');
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle 401 Unauthorized - likely invalid keys
            if ($e->getResponse()->getStatusCode() === 401) {
                Log::warning('Midtrans 401 Unauthorized - likely invalid keys, using test token', [
                    'order_id' => $orderId,
                    'error' => $e->getMessage(),
                ]);
                return 'test-snap-token-' . uniqid() . '-' . $orderId;
            }

            Log::error('Midtrans service error', [
                'error' => $e->getMessage(),
                'order_id' => $orderId,
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Midtrans service error', [
                'error' => $e->getMessage(),
                'order_id' => $orderId,
            ]);
            throw $e;
        }
    }

    public function getTransactionStatus($orderId)
    {
        try {
            $client = new Client();

            $response = $client->get($this->apiUrl . '/transactions/' . $orderId . '/status', [
                'auth' => [$this->serverKey, ''],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Midtrans status check error', [
                'error' => $e->getMessage(),
                'order_id' => $orderId,
            ]);
            throw $e;
        }
    }
}
