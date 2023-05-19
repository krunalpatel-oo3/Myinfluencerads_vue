<?php

namespace App\Http\Controllers\api;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Order;
use App\Models\Plan;
use App\Models\PlanUserAssoc;
use App\Models\PaymentTransaction;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\ResponseTrait;
use Validator;
use JWTAuth;
use DB;
use App\Helpers\EmailTrait;

class PaymentController extends BaseController {

    use ResponseTrait;
    use EmailTrait;
    
    /**
     */
    function __construct()
    {
        
    }
    
    /**
     * called on paypal success
     * @param Request $request
     */
    public function paypalReturnUrl(Request $request)
    {
        $paymentTransaction = PaymentTransaction::where(['paypal_payment_id' => $request->paymentId, 'status' => 'Redirect'])->first();
        if(!empty($paymentTransaction)) {
            $order = Order::where('id', $paymentTransaction->order_id)->first();
            $order->status = 'Done';
            $order->save();
            $paymentTransaction->status = "Done";
            $paymentTransaction->amount = $order->total_amount;
            $paymentTransaction->paypal_payer_id = $request->PayerID;
            $paymentTransaction->save();
            
            PlanUserAssoc::assocUserWithOrder($order->plan_id, $order->user_id); //associate plan with user
            $this->sendSubscriptionMail($order->plan_id, $order->user_id, 'emails.subscription.confirmation'); //send mail
            return redirect('/paymentSuccess?key='.base64_encode($order->status));
        } else {
            return redirect('/paymentFailed');
        }
    }

    /**
     * called on paypal failure
     * @param Request $request
     */
    public function paypalCancelUrl(Request $request)
    {
        $paymentTransaction = PaymentTransaction::where(['paypal_payment_id' => $request->paymentId, 'status' => 'Redirect'])->first();
        if(!empty($paymentTransaction)) {            
            $paymentTransaction->status = "Failed";
            $paymentTransaction->save();
        }

        return redirect('/paymentFailed');        
    }
          
    /**
     * success screen url
     * @param Request $request
     */
    public function paymentSuccess(Request $request)
    {
        return view('payments.success', []);     
    }
    
    /**
     * failed screen url
     * @param Request $request
     */
    public function paymentFailed(Request $request)
    {
        return view('payments.failed', []);     
    }
}
