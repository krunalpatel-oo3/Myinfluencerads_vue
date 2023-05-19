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
use App\Helpers\PaypalTrait;
use Validator;
use JWTAuth;
use DB;
use App\Helpers\StripeTrait;
use App\Helpers\EmailTrait;
use App\Models\GeneralSetting;
use App\Models\User;

class OrderApiController extends BaseController {

    use ResponseTrait;
    use PaypalTrait;
    use StripeTrait;
    use EmailTrait;

    /**
     */
    function __construct()
    {
        
    }
    
    /**
     * Validate create order request
     * @param type $request
     * @return int
     */
    private function validateCreateOrderRequest($request)
    {
        $validation = Validator::make($request->all(), config('app_validations.create_order'));
        if ($validation->fails()) {
            return $this->validationError($validation);
        }
        
        if ($request->payment_method == "cc") {
            $validation = Validator::make($request->all(), config('app_validations.cc_payment_validation'));
            if ($validation->fails()) {
                return $this->validationError($validation);
            }
        }
        
        return 0;
    }

    /**
     * Place order
     * @param Request $request
     * @return type
     */
    public function createOrder(Request $request) {
        try {
            DB::beginTransaction();
            $error = $this->validateCreateOrderRequest($request);// validate request
            if($error) return $error;
        
            $loggedUser = auth()->user();

            $plan = Plan::select(['id', 'price'])->where(['id' => $request->plan_id])->first();

            $createOrderData['plan_id'] = $request->plan_id;
            $createOrderData['user_id'] = $loggedUser->id;
            $createOrderData['total_amount'] = $plan->price;
            $order = Order::create($createOrderData);

            $data['order'] = $order;
            $data['payment_url'] = "";
            if ($request->payment_method == "paypal") {
                $data['payment_url'] = $this->payWithPaypal($order, 'plan');
                $msg = "Please pay on link";
            } else {
                $data['payment_details'] = $this->payWithCC($request, $order, 'plan', $loggedUser);
                $msg = "Payment done";
            }
            DB::commit();
            
            return $this->success($data, $msg);
        } catch(\Exception $e) {
            DB::rollback();            
            return $this->error($e->getMessage());
        }
    }
    
    /**
     * Pay with paypal account
     * @param type $order
     * @param type $type
     * @return type
     * @throws Exception
     */
    public function payWithPaypal($order, $type)
    {
        $description = "$type transaction.";
        $transaction = $this->authorizeGateway($order, $description, 'paypal');//auth gateway

        $response = $transaction->send();
        if ($response->isRedirect()) {
            PaymentTransaction::store($response->getTransactionReference(), $order->id);            
            $redirectUrl = $response->getRedirectUrl();
        }
        
        if(!isset($redirectUrl)) {
            throw new Exception('Error in connecting paypal');
        }
        
        return $redirectUrl;
    }

    /**
     * Pay with Card
     * @param type $request
     * @param type $order
     * @param type $type
     */
    public function payWithCC($request, $order, $type, $loggedUser)
    {        
        $charge = $this->payWithStripe($request, $order); //call strip apis            
        //save complete response
        if($charge->status == 'succeeded') {
            $order->status = "Done";
            $order->save();
            //save data in transactions table
            $stArr['order_id'] = $order->id;
            $stArr['stripe_id'] = $charge->id;
            $stArr['status'] = "Done";
            $stArr['amount'] = $order->total_amount;
            PaymentTransaction::create($stArr);

            PlanUserAssoc::assocUserWithOrder($order->plan_id, $order->user_id); //associate plan with user
            $this->sendSubscriptionMail($order->plan_id, $loggedUser->id, 'emails.subscription.confirmation'); //send mail
        } else {
            //save data in transactions table
            $stArr['order_id'] = $order->id;
            $stArr['stripe_id'] = $charge->id;
            $stArr['status'] = "Failed";
            $stArr['amount'] = $order->total_amount;
            PaymentTransaction::create($stArr);
        }
        
        return $charge;
    }

    /**
     * 
     * @return type
     */
    public function orderList()
    {
        $result = [];
        try {
            $loggedUser = auth()->user();
        
            $orders = Order::where(['user_id' => $loggedUser->id, 'status' => 'Done'])
                ->with(['plan', 'paidOrder'])->orderBy('created_at', 'Desc')->get();
                   
            foreach($orders as $order) {
                $result[] = $this->formatOrderObject($order);
            }
            
            return $this->success($result, "Order list");
        } catch (Exception $ex) {
            return $this->error($e->getMessage());
        }
    }
    
    /**
     * Format order Object
     * @param type $order
     * @return type
     */
    private function formatOrderObject($order)
    {
        $responseArr = [
            "id" => $order->id,
            "user_id" => $order->user_id,
            "plan_id" => $order->plan_id,
            "plan_name" => $order->plan->name,
            "plan_period" => $order->plan->period,
            "total_amount" => $order->total_amount,
            "status" => $order->status,
            "created_at" => $order->created_at,
        ];
        
        if($order->paidOrder->stripe_id != null) {
            $responseArr['stripe_id'] = $order->paidOrder->stripe_id;
            $responseArr['paid_via'] = "Card";
        } else {
            $responseArr['paypal_payer_id'] = $order->paidOrder->paypal_payer_id;
            $responseArr['paypal_payment_id'] = $order->paidOrder->paypal_payment_id;
            $responseArr['paid_via'] = "Paypal";
        }
        
        $responseArr['payment_status'] = $order->paidOrder->status;
        
        return $responseArr;
    }
}
