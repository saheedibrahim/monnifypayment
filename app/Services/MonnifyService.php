<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class MonnifyService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;
    protected $secretKey;
    protected $contractCode;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = env('https://sandbox.monnify.com');
        $this->apiKey = env('MK_TEST_WR66CY5EUY');
        $this->secretKey = env('31A4JJDHG99EE6JPB1AX4N7AG2U29GVB');
        $this->contractCode = env('6761245091');
    }

    // private function authenticate()
    // {
    //     $response = $this->client->post($this->baseUrl . '/api/v1/auth/login', [
    //         'headers' => [
    //             'Content-Type' => 'application/json',
    //             'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->secretKey),
    //         ],
    //     ]);

    //     $data = json_decode($response->getBody(), true);
    //     return $data['responseBody']['accessToken'];
    // }
    
    // public function authenticate()
    // {
    //     $response = $this->client->post($this->baseUrl . 'auth/login', [
    //         'headers' => [
    //             'Content-Type' => 'application/json',
    //             'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->secretKey),
    //         ],
    //     ]);
        
    //     $body = json_decode($response->getBody(), true);
    //     return $body['responseBody']['accessToken'];
    // }

    private function authenticateold()
    {
        $response = Http::withBasicAuth($this->apiKey, $this->secretKey)
            ->post("{$this->baseUrl}/auth/login");
        
        if ($response->successful()) {
            return $response->json()['responseBody']['accessToken'];
        }

        return null;
    }

    private function authenticate()
    {
        $response = $this->client->post("{$this->baseUrl}/api/v1/auth/login", [
            'auth' => [$this->apiKey, $this->secretKey],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() == 200) {
            return $data['responseBody']['accessToken'];
        }

        return null;
    }

        // Initiate payment for receive money
    public function initiatePayment($amount, $paymentReference, $narration, $destinationBankCode, $sourceAccountNumber, $destinationAccountName)
    {
        $accessToken = $this->authenticate();

        $response = $this->client->post("{$this->baseUrl}/merchant/transactions/init-transaction", [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'amount' => $amount,
                'reference' => $paymentReference,
                "narration" => $narration,
                "destinationBankCode" => $destinationBankCode,
                'currency' => 'NGN',
                "sourceAccountNumber" => $sourceAccountNumber,
                "destinationAccountName" => $destinationAccountName,
                'customerName' => 'Customer Name',
                'paymentDescription' => 'Payment for services',
                'contractCode' => $this->contractCode,
                'redirectUrl' => route('payment.callback'),
                "async" => true,
                'paymentMethods' => ['CARD', 'ACCOUNT_TRANSFER']
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    // Verify transaction for receive money
    public function verifyTransaction($paymentReference)
    {
        $accessToken = $this->authenticate();

        $response = $this->client->get("{$this->baseUrl}/merchant/transactions/query", [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
            ],
            'query' => [
                'paymentReference' => $paymentReference,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

        // Transfer funds
    public function transferFunds($amount, $accountNumber, $bankCode, $narration)
    {
        $accessToken = $this->authenticate();

        $response = $this->client->post("{$this->baseUrl}/disbursements/single", [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'amount' => $amount,
                'destinationAccountNumber' => $accountNumber,
                'destinationBankCode' => $bankCode,
                'currencyCode' => 'NGN',
                'narration' => $narration,
                'sourceAccountNumber' => 'YOUR_ACCOUNT_NUMBER',
                'sourceBankCode' => 'YOUR_BANK_CODE',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
    
    public function transferFundsold($amount, $customerName, $destinationBankName, $paymentDescription)
    {
        $token = $this->authenticate();

        $response = $this->client->post($this->baseUrl . 'disbursements/single', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'amount' => $amount,
                'customerName' => $customerName,
                'destinationBankName' => $destinationBankName,
                'paymentDescription' => $paymentDescription,
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    // Sell airtime
    public function sellAirtime($amount, $phoneNumber, $networkCode)
    {
        $accessToken = $this->authenticate();

        $response = $this->client->post("{$this->baseUrl}/transactions/airtime", [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'amount' => $amount,
                'phoneNumber' => $phoneNumber,
                'networkCode' => $networkCode,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
    
    public function sellAirtimeold($amount, $phoneNumber, $provider)
    {
        $token = $this->authenticate();

        $response = $this->client->post($this->baseUrl . 'airtime/top-up', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ],
            'json' => [
                'amount' => $amount,
                'phoneNumber' => $phoneNumber,
                'provider' => $provider
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    // Sell data
    public function sellData($amount, $phoneNumber, $networkCode)
    {
        $accessToken = $this->authenticate();

        $response = $this->client->post("{$this->baseUrl}/transactions/data", [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'amount' => $amount,
                'phoneNumber' => $phoneNumber,
                'networkCode' => $networkCode,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
    
    public function sellDataold($amount, $phoneNumber, $provider, $dataPlan)
    {
        $token = $this->authenticate();

        $response = $this->client->post($this->baseUrl . 'data/top-up', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ],
            'json' => [
                'amount' => $amount,
                'phoneNumber' => $phoneNumber,
                'provider' => $provider,
                'dataPlan' => $dataPlan
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    // Pay utility bills
    public function payUtilityBills($amount, $customerAccountNumber, $providerCode, $serviceCode)
    {
        $accessToken = $this->authenticate();

        $response = $this->client->post("{$this->baseUrl}/transactions/bill-payment", [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'amount' => $amount,
                'customerAccountNumber' => $customerAccountNumber,
                'providerCode' => $providerCode,
                'serviceCode' => $serviceCode,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function receiveFunds($amount, $customerName, $customerEmail, $transactionReference)
    {
        $token = $this->authenticate();

        $response = $this->client->post($this->baseUrl . 'transactions/initiate', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ],
            'json' => [
                'amount' => $amount,
                'customerName' => $customerName,
                'customerEmail' => $customerEmail,
                'transactionReference' => $transactionReference
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}