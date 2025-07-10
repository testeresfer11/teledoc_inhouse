<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{User, UserDetail, PatientDetail};
use App\Notifications\UserNotification;
use App\Traits\SendResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator,Hash,Auth};

class PatientController extends Controller
{
    use SendResponseTrait;

    public function getPatientList(Request $request)
    {
        try {
            $patients = User::where("role_id", 3)
                ->when($request->filled('search_keyword'), function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('first_name', 'like', "%$request->search_keyword%")
                            ->orWhere('last_name', 'like', "%$request->search_keyword%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$request->search_keyword}%"])
                            ->orWhere('email', 'like', "%$request->search_keyword%");
                    });
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->orderBy("id", "desc")->paginate(10);
            return view("admin.patient.list", compact("patients"));
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    public function addPatient(Request $request)
    {
        try {
            if ($request->isMethod('get')) {
                return view("admin.patient.add");
            } elseif ($request->isMethod('post')) {

                $validator = Validator::make($request->all(), [
                    'name'         => 'required|string|max:255',
                    'email'        => 'required|unique:users,email|email:rfc,dns',
                    'password'     => 'nullable|string|min:6',
                    'gender'       => 'required|in:1,2,3', 
                    'birth_date'   => 'nullable|date',
                    'profile_pic'  => 'nullable|image|max:2048',
                    'id_proof'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
                    'mobile_no'    => 'nullable|string|max:20',
                    'country_code' => 'nullable|string|max:10',
                    'present_address'   => 'nullable|string',
                    'permanent_address' => 'nullable|string',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // Set password
                $password = $request->filled('password') ? $request->password : generateRandomString();

                // Create user
                $user = User::create([
                    'role_id'           => 3, 
                    'name'              => $request->name,
                    'email'             => $request->email,
                    'password'          => Hash::make($password),
                    'mobile_no'         => $request->mobile_no,
                    'country_code'      => $request->country_code,
                    'is_email_verified' => 1,
                    'email_verified_at' => now(),
                    'created_by'        => auth()->id(),
                ]);

                // Handle image uploads
                $imagePath = $request->hasFile('profile_pic') ? uploadFile($request->file('profile_pic'), 'images/patients/') : null;
                $idProofPath = $request->hasFile('id_proof') ? uploadFile($request->file('id_proof'), 'documents/id_proof/') : null;

                // Create patient detail
                PatientDetail::create([
                    'user_id'           => $user->id,
                    'gender'            => $request->gender,
                    'birth_date'        => $request->birth_date,
                    'present_address'   => $request->present_address,
                    'pat_lat'           =>$request->pat_lat,
                    'pat_long'           =>$request->pat_long,
                    'permanent_address' => $request->permanent_address,
                    'image'             => $imagePath,
                    'id_proof'          => $idProofPath,
                    'mobile_no'         => $request->mobile_no,
                    'country_code'      => $request->country_code,
                    'created_by'        => auth()->id(),
                    'is_active'         => 1,
                ]);

                // Send email with credentials
                $template = $this->getTemplateByName('Account_detail');
                if ($template) {
                    $stringToReplace   = ['{{$name}}', '{{$password}}', '{{$email}}'];
                    $stringReplaceWith = [$user->name, $password, $user->email];
                    $body              = str_replace($stringToReplace, $stringReplaceWith, $template->template);
                    $emailData         = $this->mailData($user->email, $template->subject, $body, 'Account_detail', $template->id);
                    $this->mailSend($emailData);
                }

                return redirect()->route('admin.patient.list')->with('success', 'Patient ' . config('constants.SUCCESS.ADD_DONE'));
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * functionName : view
     * createdDate  : 31-05-2024
     * purpose      : Get the detail of specific user
     */
    public function view($id)
{
    try {
        $user = User::with('patientDetail')->findOrFail($id);
       
        return view("admin.patient.view", compact("user"));
    } catch (\Exception $e) {
        return redirect()->back()->with("error", $e->getMessage());
    }
}
    /**End method view**/

    /**
     * functionName : edit
     * createdDate  : 31-05-2024
     * purpose      : edit the user detail
     */
    public function edit(Request $request, $id)
{
    try {
        if ($request->isMethod('get')) {
            $user = User::with('patientDetail')->findOrFail($id);
            return view("admin.patient.edit", compact('user'));
        }

        // POST request (update logic)
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'email'             => 'required|email:rfc,dns|unique:users,email,' . $id,
            'mobile_no'         => 'nullable|string|max:20',
            'country_code'      => 'nullable|string|max:10',
            'gender'            => 'required|in:1,2,3',
            'birth_date'        => 'nullable|date',
            'profile_pic'       => 'nullable|image|max:2048',
            'id_proof'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'present_address'   => 'nullable|string',
            'permanent_address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        $user->update([
            'name'         => $request->name,
            'email'        => $request->email,
            'mobile_no'    => $request->mobile_no,
            'country_code' => $request->country_code,
        ]);

        $patient = $user->patientDetail;

        // Handle file uploads
        $imagePath = $patient && $request->hasFile('image')
            ? uploadFile($request->file('image'), 'images/patients/', $patient->image)
            : ($patient->image ?? null);

        $idProofPath = $patient && $request->hasFile('id_proof')
            ? uploadFile($request->file('id_proof'), 'documents/id_proof/', $patient->id_proof)
            : ($patient->id_proof ?? null);

        // Update or create patient detail
        PatientDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'gender'             => $request->gender,
                'birth_date'         => $request->birth_date,
                'present_address'    => $request->present_address,
                'permanent_address'  => $request->permanent_address,
                'pat_lat'            => $request->pat_lat,
                'pat_long'           => $request->pat_long,
                'image'              => $imagePath,
                'id_proof'           => $idProofPath,
                'mobile_no'          => $request->mobile_no,
                'country_code'       => $request->country_code,
                'updated_by'         => auth()->id(),
            ]
        );

        return redirect()->route('admin.patient.list')->with('success', 'Patient ' . config('constants.SUCCESS.UPDATE_DONE'));
    } catch (\Exception $e) {
        return redirect()->back()->with("error", $e->getMessage());
    }
}

    /**End method edit**/

    /**
     * functionName : delete
     * createdDate  : 31-05-2024
     * purpose      : Delete the user by id
     */
    public function delete($id)
    {
        try {
            User::where('id', $id)->delete();
            return response()->json(["status" => "success", "message" => "User " . config('constants.SUCCESS.DELETE_DONE')], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", $e->getMessage()], 500);
        }
    }
    /**End method delete**/
}
