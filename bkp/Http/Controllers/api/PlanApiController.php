<?php

namespace App\Http\Controllers\api;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Plan;
use App\Models\PlanUserAssoc;
use App\Models\PlanFacility;
use Exception;
use App\Helpers\ResponseTrait;
use DB;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\EmailTrait;
use App\Models\GeneralSetting;

class PlanApiController extends BaseController 
{

    use ResponseTrait;
    use EmailTrait;
    
    /**
     */
    function __construct() {
        $this->plan['1'] = ['3 projects per month', '10 products per month', 'Approval required to publish'];
        $this->plan['2'] = ['Publish unlimited projects', 'Publish up to 10 products', 'Instant approval publishing a project', 'Make your projects featured'];
        $this->plan['3'] = ['Everything in Pro plan +', 'Create and customize your brand page', 'Publish unlimited products', 'Manage authorized resellers'];
    }
    
    /**
    * get Active plan's list
    */
    public function getPlansList()
    {
        try {
            $plans = Plan::select(['id', 'name', 'description', 'price', 'period'])->where(['status' => 'Active'])->get()->toArray();
            $planArr = [];
            foreach($plans as $plan) {
                $includes = isset($this->plan[$plan['id']]) ? $this->plan[$plan['id']] : [];
                $priceText = $plan['price'] == null ? "Free /".$plan['period'] : "$".$plan['price']." /".$plan['period'];
                array_push($planArr, array_merge($plan, ['priceText' =>$priceText, 'includes' => $includes]));
            }
            
            return $this->success(['plans' => $planArr], 'Plan List');
        } catch(\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
    
    /**
     * get logged in users current plan
     * @return type
     */
    public function getCurrentPlan()
    {
        $result = [];
        try {
            $loggedInUser = auth()->user();
            $planUserAssoc = PlanUserAssoc::with(['plan'])->where(['user_id' => $loggedInUser->id])->first();
            if(!empty($planUserAssoc)) {                
                $result['id'] = $planUserAssoc->plan->id;
                $result['name'] = $planUserAssoc->plan->name;
                $result['description'] = $planUserAssoc->plan->description;
                $result['period'] = $planUserAssoc->plan->period;
                $result['price'] = $planUserAssoc->plan->price;
                $result['expired_at'] = $planUserAssoc->expired_at;
                $timeleftInSecs = strtotime($planUserAssoc->expired_at) - strtotime(date("Y-m-d H:i:s"));
                $result['days_left'] = round((($timeleftInSecs/24)/60)/60);
                
                $planFacilities = PlanFacility::
                        where(['plan_id' => $planUserAssoc->plan->id, 'status' => 'Active'])->get();
                foreach($planFacilities as $planFacility) {
                    $temp = [];
                    $temp['id'] = $planFacility->id;
                    $temp['facility'] = $planFacility->facility;
                    $result['allowed_features'][] = $temp;
                }
                
            }
            
            return $this->success($result, 'Current plan');
        } catch(\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
    
    /**
     * Downgrade user plan
     * @param Request $request
     * @return type
     */
    public function downgradePlan(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $validation = Validator::make($request->all(), config('app_validations.downgrade_plan'));
            if ($validation->fails()) {
                return $this->validationError($validation);
            }
        
            $loggedInUser = auth()->user();
            
            $planUserAssoc = PlanUserAssoc::select(['plan_id'])->where(['user_id' => $loggedInUser->id])->first(); 
            
            if(empty($planUserAssoc)) {
                throw new \Exception("No existing plan found");
            }
            
            if($planUserAssoc->plan_id == $request->downgrade_plan_id) {
                throw new \Exception("You already have same plan");
            } else {
                $msg = "Plan downgrade successfull";
                PlanUserAssoc::assocUserWithOrder($request->downgrade_plan_id, $loggedInUser->id, $upgrading = false);
            }
                        
            DB::commit();
            
            $this->sendSubscriptionMail($request->downgrade_plan_id, $loggedInUser->id, 'emails.subscription.downgrade'); //send mail
            return $this->success([], $msg);
        } catch(\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }
    }
}
