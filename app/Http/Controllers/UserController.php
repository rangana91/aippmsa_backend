<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function getUserDetails(): ?Authenticatable
    {
       return Auth::user();
    }

    public function updateUser(UpdateUserRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->update($request->all());
            return response()->json('User successfully updated.');
        } catch (Exception $exception){
            return response()->json('User update failed.', 400);
        }

    }

    public function getCustomerData()
    {
        try {
            $users = User::whereHas('roles', function($query) {
                $query->where('name', 'customer');
            })->get();
            return DataTables::of($users)
                ->addColumn('name', function ($user) {
                    return $user->first_name.' '.$user->last_name;
                })
                ->addColumn('email', function ($user) {
                    return $user->email;
                })
                ->addColumn('address', function ($user) {
                    return $user->address;
                })
                ->make(true);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json('User fetch failed.', 400);
        }
    }

    public function tableActions(): string
    {
        $delete = '<a class="col mb-2 btn btn-neutral-shadow table-action-delete text-primary border-r25" type="button"><span class="btn-inner--icon"><i class="fas fa-trash"></i></span> <span class="btn-inner--text d-none d-sm-inline"></span></a>';
        $edit = '<a class="col mb-2 btn btn-neutral-shadow table-action-edit text-primary border-r25" type="button"><span class="btn-inner--icon"><i class="fas fa-edit"></i></span> <span class="btn-inner--text d-none d-sm-inline"></span></a>';
        return  '<div class="btn-group-sm row justify-content-lg-center mx-0" role="group">'.$edit . $delete . '</div>';
    }
}
