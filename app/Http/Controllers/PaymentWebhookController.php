<?php

namespace App\Http\Controllers;

use App\Helpers\signatureHelper;
use App\Mail\PaymentNotifyMail;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VirtualAccount;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class PaymentWebhookController extends Controller
{


    public function handleWebhook(Request $request)
    {

        $payload = $request->all();

        // Verify the signature
        if (! $this->verifySignature($payload)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        // Process the webhook payload

        Log::info('Palmpay webhook received Data:', $payload);

        $this->processReservedAccountTransaction($payload);

        return response('success', 200)->header('Content-Type', 'text/plain');
    }

    private function verifySignature($data)
    {

        $sign = $data['sign'];

        $verifyResults = signatureHelper::verify_callback_signature($data, $sign, config('keys.public'));

        if ($verifyResults != true) {
            return false;
        }

        return true;
    }


    private function processReservedAccountTransaction($payload)
    {

        if (isset($payload['orderId']) && isset($payload['transType']) && $payload['transType'] == 41) {

            Log::info('[PAYOUT]:', $payload);

            // $this->handlePayout($payload);
        } else {

            Log::info('[PAYIN]:', $payload);

            $virtualAccountNo =  $payload['virtualAccountNo'];
            $orderNo =  $payload['orderNo'];
            $amountPaid =  $payload['orderAmount'] / 100;
            $payerBankName =  $payload['payerBankName'];
            $payerAccountName =  $payload['payerAccountName'];
            $service_description = 'Your wallet has been credited with ₦' . number_format($amountPaid, 2);
            $orderStatus = $payload['orderStatus'];

            $response = VirtualAccount::select('user_id')->where('accountNo', $virtualAccountNo)->first();

            if ($response) {
                $this->createTransactionForReservedAccount($response->user_id, $orderNo, $amountPaid, $payerBankName, $payerAccountName, $service_description, $orderStatus);
            }
        }
    }

    private function updateTransaction($orderNo, $amountPaid, $payerBankName, $payerAccountName, $service_description, $orderStatus)
    {
        if ($orderStatus == 1)
            $status = "Approved";

        Transaction::where('referenceId', $orderNo)
            ->update([
                'service_type' => 'Wallet Topup',
                'service_description' => $service_description,
                'amount' => $amountPaid,
                'gateway' => $payerBankName,
                'status' => $status,
            ]);
    }

    private function insertTransaction($userId, $orderNo, $amountPaid, $payerAccountName, $payerBankName, $service_description)
    {

        Transaction::insert([
            'user_id' => $userId,
            'payer_name' => $payerAccountName,
            //'payer_email' => auth()->user()->email,
            //'payer_phone' => auth()->user()->phone_number,
            'transaction_ref' => $orderNo,
            'type' => 'Credit',
            'description' => $service_description,
            'amount' => $amountPaid,
            'status' => 'completed',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    private function createTransactionForReservedAccount($userId, $orderNo, $amountPaid, $payerBankName, $payerAccountName, $service_description, $orderStatus)
    {
        //Check if Transaction Existed in db

        $transaction = Transaction::where('referenceId', $orderNo)->first();

        if ($transaction) {
            $this->updateTransaction($orderNo, $amountPaid, $payerBankName, $payerAccountName, $service_description, $orderStatus);
        } else {
            $this->insertTransaction($userId, $orderNo, $amountPaid, $payerAccountName, $payerBankName, $service_description);
            $this->updateWalletBalance($userId, $amountPaid);
            $this->sendNotificationAndEmail($userId, $amountPaid, $orderNo, $payerBankName, 'Topup');
        }
    }

    private function updateWalletBalance($userId, $amountPaid)
    {
        $wallet = Wallet::where('user_id', $userId)->first();
        if ($wallet) {
            $wallet->update([
                'wallet_balance' => $wallet->wallet_balance + $amountPaid,
                'deposit' => $wallet->deposit + $amountPaid,
            ]);
        } else {
            Log::warning('Wallet not found for user ID: ' . $userId);
        }
    }
        private function sendNotificationAndEmail($userId, $amountPaid, $orderNo, $bankName, $type)
    {
        $user = User::find($userId);
        if ($user) {
            $mail_data = [
                'type' => $type,
                'amount' => number_format($amountPaid, 2),
                'ref' => $orderNo,
                'bankName' => $bankName,
            ];

            // try {
            //     Mail::to($user->email)->send(new PaymentNotifyMail($mail_data));
            // } catch (TransportExceptionInterface $e) {
            //     Log::error('Error sending email for transaction ' . $orderNo . ': ' . $e->getMessage());
            // }
        }
    }
}
