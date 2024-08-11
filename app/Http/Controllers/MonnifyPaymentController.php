<?php

namespace App\Http\Controllers;

use App\Services\MonnifyService;
use Illuminate\Http\Request;

class MonnifyPaymentController extends Controller
{
    protected $monnifyService;

    public function __construct(MonnifyService $monnifyService)
    {
        $this->monnifyService = $monnifyService;
    }

    public function initiatePayment(Request $request)
    {
        $amount = $request->input('amount');
        $reference = $request->input('paymentReference');
        $narration = $request->input('narration');
        $destinationBankCode = $request->input('destinationBankCode');
        $sourceAccountNumber = $request->input('sourceAccountNumber');
        $destinationAccountName = $request->input('destinationAccountName');
        $paymentReference = uniqid('txn_', true);

        $response = $this->monnifyService->initiatePayment($amount, $paymentReference, $narration, $destinationBankCode, $sourceAccountNumber, $destinationAccountName);

        if ($response['requestSuccessful']) {
            return redirect($response['responseBody']['checkoutUrl']);
        }

        return back()->with('error', 'Unable to initiate payment. Please try again.');
    }

    public function paymentCallback(Request $request)
    {
        $paymentReference = $request->input('paymentReference');

        $response = $this->monnifyService->verifyTransaction($paymentReference);

        if ($response['requestSuccessful']) {
            // Handle successful payment
            return view('payment.success', ['transaction' => $response['responseBody']]);
        }

        // Handle failed payment
        return view('payment.failed', ['transaction' => $response['responseBody']]);
    }

    public function transferFunds(Request $request)
    {
        $amount = $request->input('amount');
        $accountNumber = $request->input('account_number');
        $bankCode = $request->input('bank_code');
        $narration = $request->input('narration');

        $response = $this->monnifyService->transferFunds($amount, $accountNumber, $bankCode, $narration);

        
        // return json_decode($response->getBody()->getContents(), true);

        if ($response['requestSuccessful']) {
            return back()->with('success', 'Transfer successful.');
        }

        return back()->with('error', 'Transfer failed. Please try again.');
    }
    
    public function transferFundsold(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'customerName' => 'required|string',
            'destinationBankName' => 'required|string',
            'paymentDescription' => 'required|string',
        ]);

        $response = $this->monnifyService->transferFundsold(
            $validated['amount'],
            $validated['customerName'],
            $validated['destinationBankName'],
            $validated['paymentDescription']
        );

        return response()->json($response);
    }

    public function sellAirtime(Request $request)
    {
        $amount = $request->input('amount');
        $phoneNumber = $request->input('phone_number');
        $networkCode = $request->input('network_code');

        $response = $this->monnifyService->sellAirtime($amount, $phoneNumber, $networkCode);

        if ($response['requestSuccessful']) {
            return back()->with('success', 'Airtime purchase successful.');
        }

        return back()->with('error', 'Airtime purchase failed. Please try again.');
    }

    public function sellAirtimeold(Request $request)
    {
        $amount = $request->input('amount');
        $phoneNumber = $request->input('phoneNumber');
        $provider = $request->input('provider');

        $response = $this->monnifyService->sellAirtime($amount, $phoneNumber, $provider);

        return response()->json($response);
    }

    public function sellData(Request $request)
    {
        $amount = $request->input('amount');
        $phoneNumber = $request->input('phone_number');
        $networkCode = $request->input('network_code');

        $response = $this->monnifyService->sellData($amount, $phoneNumber, $networkCode);

        if ($response['requestSuccessful']) {
            return back()->with('success', 'Data purchase successful.');
        }

        return back()->with('error', 'Data purchase failed. Please try again.');
    }

    public function sellDataold(Request $request)
    {
        $amount = $request->input('amount');
        $phoneNumber = $request->input('phoneNumber');
        $provider = $request->input('provider');
        $dataPlan = $request->input('dataPlan');

        $response = $this->monnifyService->sellData($amount, $phoneNumber, $provider, $dataPlan);

        return response()->json($response);
    }
    
    public function payUtilityBills(Request $request)
    {
        $amount = $request->input('amount');
        $customerAccountNumber = $request->input('customer_account_number');
        $providerCode = $request->input('provider_code');
        $serviceCode = $request->input('service_code');

        $response = $this->monnifyService->payUtilityBills($amount, $customerAccountNumber, $providerCode, $serviceCode);

        if ($response['requestSuccessful']) {
            return back()->with('success', 'Utility bill payment successful.');
        }

        return back()->with('error', 'Utility bill payment failed. Please try again.');
    }

    public function receiveFunds(Request $request)
    {
        $amount = $request->input('amount');
        $customerName = $request->input('customerName');
        $customerEmail = $request->input('customerEmail');
        $transactionReference = $request->input('transactionReference');

        $response = $this->monnifyService->receiveFunds($amount, $customerName, $customerEmail, $transactionReference);

        return response()->json($response);
    }

}
