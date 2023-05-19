<?php

namespace App\Http\Controllers\api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Platform;
use App\Helpers\ResponseTrait;
use App\Helpers\CommonTrait;
use Exception;
use DB;

class PlatformApiController extends BaseController {

    use ResponseTrait;
    use CommonTrait;

    /**
     */
    function __construct() {
        
    }

    /**
     * User brand list
     * @return type
     */
    public function getPlatformList() {
        try {
            $list = Platform::select(['*', DB::raw('title As text')])->get();
            return $this->success(['platform' => $list], "Platform list");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

}
