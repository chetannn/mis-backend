<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevokeRoleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param $user_id
     * @return JsonResponse
     */
    public function __invoke(Request $request, $user_id) : JsonResponse
    {
        try {
            $user = User::findOrFail($user_id);

            DB::beginTransaction();

            foreach ($request->get('role_ids') as $role_id) {
                $user->removeRole($role_id);
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Role Removed Successfully']);
        } catch (\Exception $exception) {
            DB::rollBack();

            logger()->error($exception);
            return response()->json(['status' => false], 500);
        }
    }
}
