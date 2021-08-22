<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignRoleController extends Controller
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
        $user = User::findOrFail($user_id);

        try {

            DB::beginTransaction();

            foreach ($request->get('role_ids') as $role_id) {
                $user->assignRole($role_id);
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Role Assigned']);
        } catch (\Exception $exception) {
            DB::rollBack();
            logger()->error($exception);
            return response()->json(['status' => false]);
        }
    }
}
