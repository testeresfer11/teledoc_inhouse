<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{Card,Category,OrderCard,Payment, User};
use Spatie\Permission\Models\Role;

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
   public function index()
{
    // Get role IDs
    $doctorRole = Role::where('name', config('constants.ROLES.DOCTOR'))->first();
    $patientRole = Role::where('name', config('constants.ROLES.PATIENT'))->first();

    // Get counts
    $totalDoctors = $doctorRole ? User::where('role_id', $doctorRole->id)->count() : 0;
    $totalPatients = $patientRole ? User::where('role_id', $patientRole->id)->count() : 0;

    // Total registered users (all roles)
    $totalUsers = User::count();

    // Example: Total appointments (if you have a model/table like `appointments`)
    $totalAppointments = 0;//DB::table('appointments')->count(); // adjust table name if different

    $responseData = [
        'total_registered_user' => $totalUsers,
        'total_appointment'     => $totalAppointments,
        'total_doctor'          => $totalDoctors,
        'total_patient'         => $totalPatients,
    ];

    return view("admin.dashboard", compact('responseData'));
}

    /**End method index**/
}
