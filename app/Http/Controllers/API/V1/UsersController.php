<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\EmailFilter;
use App\Filters\NameFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $users = app(Pipeline::class)
            ->send(User::query())
            ->through([
                EmailFilter::class,
                NameFilter::class
            ])
            ->via('process')
            ->thenReturn()
            ->paginate(15);

        return UserResource::collection($users);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::with('roles')->where('id', $id)->first();
    }

    public function removeRoles(Request $request, $user_id): JsonResponse
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
