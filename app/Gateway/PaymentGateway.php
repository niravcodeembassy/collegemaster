<?php


namespace App\Gateway;

use App\Model\Order;
use App\Model\PaymentLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


abstract class PaymentGateway
{


    protected $order;
    protected $transaction_id = null;
    public $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function addLog($type = 'cancel')
    {
        $paymentLog = new PaymentLog();
        $paymentLog->response = json_encode($this->request->all());
        $paymentLog->user_id = Auth::id();
        $paymentLog->type = $type;
        $paymentLog->save();

        return $paymentLog;
    }

    protected function gotoHome()
    {
        return redirect('/');
    }

    protected function hasKey()
    {
        return session()->has(['transaction_id']);
    }

    protected function clearkey()
    {
        session()->forget(['transaction_id']);
        return $this;
    }


    public function onCancel()
    {
        if (!$this->hasKey()) {
            return $this->gotoHome();
        }
        $this->addLog();
        $this->clearkey();
        return view('front-end.payment.cancel');
    }

    public function thankyou($userPlan)
    {
        return view('front-end.payment.success', ['id' => $userPlan->invoice_no]);
    }

    public function setOrder($order = [])
    {
        $this->order = json_decode(json_encode($order));
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }


    abstract protected function setContext();
    abstract public function onCharge($order);
    abstract public function onSuccess(Request $request);
    abstract public function redirectTo();
    abstract public function getTransactionId();
}
