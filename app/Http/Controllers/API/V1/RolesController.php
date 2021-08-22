<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        return Role::all();
    }

    public function store(Request $request)
    {
        return Role::create($request->validate([
            'name' => 'required'
        ]));
    }

    public function show(Request $request, $id)
    {
        return Role::findOrFail($id);
    }

    public function destroy(Request $request, $id)
    {
        Role::findOrFail($id)->delete();
    }

}
