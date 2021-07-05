<?php

namespace Modules\Core\Http\Controllers\Api;

use stdClass;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Core\Entities\Organization;
use Illuminate\Contracts\Support\Renderable;
use Modules\Core\Http\Controllers\ApiController;

class OrganizationController extends ApiController
{
    protected $organ;

    public function __construct(Organization $organ)
    {
        $this->organ = $organ;
    }

    public function getAllOrgan(Request $request)
    {
        try {
            $listData = new stdClass();
            $listData->organ = Organization::select('*')->get();

            if ($listData) {
                return $this->successResponse(['result' => $listData], 'Response Successfully');
            } else {
                return $this->successResponse(['errors' => 'Data not exist!'], 'Response Successfully');
            }
        } catch (\Throwable $th) {
            Log::error('[Organ get]' . $th->getMessage());
            return $this->successResponse(["errors" => $th->getMessage()], 'Response Successfully');
        }
    }
}
