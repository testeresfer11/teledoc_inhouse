<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{Card,Category,OrderCard,Payment, Role, User};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * functionName : index
     * createdDate  : 29-05-2024
     * purpose      : Get the dashboard detail for the admin
     */
    public function index(){

        $role = Role::where('name' , config('constants.ROLES.USER'))->first();
        $user = User::where('role_id',$role->id);

        $responseData =[
            'total_registered_user'         => $user->clone()->count(),
            'total_appointment'         => $user->clone()->count(),
            'total_doctor'         => $user->clone()->count(),
            'total_patient'         => $user->clone()->count(),
        ];
        return view("admin.dashboard",compact('responseData'));
    }
    /**End method index**/
}
