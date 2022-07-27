<?php

namespace App\Gateway;

use Razorpay\Api\Api;
use App\Model\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use App\Gateway\PaymentGateway;
use Exception;
use App\Exceptions\GeneralException;
use App\Model\Order;

class Razorpay extends PaymentGateway
{

    protected $key = null;
    protected $key_secret = null;
    protected $statusCode = '';


    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    public function onCharge($order = [])
    {
        $user = Auth::user()->load('address');
        // Generate random receipt id
        $receiptId = Str::random(20);
        // Create an object of razorpay
        $api = $this->setContext();
        // In razorpay you have to convert rupees into paise we multiply by 100 // Currency will be INR
        $amount =  $order['total'] * 100;
        // Creating order
        $razorPayOrder = $api->order->create(array(
            'receipt' => $receiptId,
            'amount' => $amount,
            'currency' => 'INR'
        ));

        // Return response on payment page
        $this->data = [
            'orderId' => $razorPayOrder['id'],
            'razorpayId' => $this->key,
            'amount' => $amount * 100,
            'currency' => 'INR',
            'description' => '',
            'name' => $user->name,
            'email' => $user->email,
            'contactNumber' => $user->email,
            'address' => $user->address->address_one . ' ' . $user->address->address_two,
        ];

        $this->request->merge(['razorpay' => $razorPayOrder]);
    }

    public function redirectTo()
    {
        $this->addLog('pending');
        // Let's checkout payment page is it working
        return view('frontend.payment.razorpay', ['response' => $this->data]);
    }



    public function onSuccess(Request $request)
    {
        $api = $this->setContext();

        $signatureStatus = $this->SignatureVerify(
            $request->rzp_signature,
            $request->rzp_paymentid,
            $request->rzp_orderid
        );

        if ($signatureStatus === true) {
            return $request->all();
        } else {
            return false;
        }
    }

    protected function setContext()
    {

        if (!$this->key && !$this->key_secret) {
            $payment = PaymentSetting::first();
            $this->key = $payment->razorpay_key;
            $this->key_secret = $payment->razorpay_secrete;
        }

        return new Api($this->key, $this->key_secret);
    }

    function getState()
    {
        return $this->statusCode;
    }


    private function SignatureVerify($_signature, $_paymentId, $_orderId)
    {
        try {
            // Create an object of razorpay class
            $api = $this->setContext();

            $attributes  = [
                'razorpay_signature'  => $_signature,
                'razorpay_payment_id'  => $_paymentId,
                'razorpay_order_id' => $_orderId
            ];

            $order  = $api->utility->verifyPaymentSignature($attributes);

            return true;

        } catch (Exception $e) {

            return false;

        }

    }
}
