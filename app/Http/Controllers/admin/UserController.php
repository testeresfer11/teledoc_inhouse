<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{User, UserDetail, PatientDetail};
use App\Notifications\UserNotification;
use App\Traits\SendResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Hash};

class UserController extends Controller
{
    use SendResponseTrait;
    /**
     * functionName : getList
     * createdDate  : 30-05-2024
     * purpose      : Get the list for all the user
     */
    public function getDoctorList(Request $request)
    {
        try {
            $doctors = User::where("role_id", 2)
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
            return view("admin.doctor.list", compact("doctors"));
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/

   

    /**
     * functionName : add
     * createdDate  : 31-05-2024
     * purpose      : add the user
     */
    public function addDoctor(Request $request)
    {
        try {
            if ($request->isMethod('get')) {
                return view("admin.doctor.add");
            } elseif ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'name'        => 'required|string|max:255',
                    'email'       => 'required|unique:users,email|email:rfc,dns',
                    'mobile_no'   => 'required|min:10',
                    'profile_pic' => 'image|max:2048',
                    'gender'      => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if ($request->filled('password')) {
                    $password = $request->password;
                } else {
                    $password = generateRandomString();
                }
                $user = User::Create([
                    'role_id'           => 3,
                    'name'              => $request->name,
                    'email'             => $request->email,
                    'country'           => 'India',
                    'country_code'      => '+91',
                    'mobile_no'         => $request->mobile_no,
                    'email_verified_at' => date('Y-m-d H:i:s')
                ]);

                $ImgName = User::find(authId())->doctorDetail->profile_pic;
                if ($request->hasFile('profile_pic')) {
                    $ImgName = uploadFile($request->file('profile_pic'), 'images/');
                }

                $ICimg = User::find(authId())->doctorDetail->ic_pic;
                if ($request->hasFile('profile_pic')) {
                    $ImgName = uploadFile($request->file('profile_pic'), 'images/user-documents');
                }

                $Eduimg = User::find(authId())->doctorDetail->education;
                if ($request->hasFile('education')) {
                    $ImgName = uploadFile($request->file('education'), 'images/user-documents');
                }

                $Licenseimg = User::find(authId())->doctorDetail->medical_license;
                if ($request->hasFile('medical_license')) {
                    $ImgName = uploadFile($request->file('medical_license'), 'images/user-documents');
                }

                DoctorDetail::create([
                    'doctor_id'         => $user->id,
                    'present_address'   => $request->address ? $request->address : '',
                    'permanent_address' => $request->alt_address ? $request->alt_address : '',
                    'profile_pic'       => $ImgName,
                    'ic_pic'            => $ICimg,
                    'education'         => $Eduimg,
                    'gender'            => $request->gender,
                    'current_wokplace'  => $request->current_workplace ? $request->current_workplace : '',
                    'birth_date'        => $request->birth_date ? $request->birth_date : '',
                ]);


                $template = $this->getTemplateByName('Account_detail');
                if ($template) {
                    $stringToReplace    = ['{{$name}}', '{{$password}}', '{{$email}}'];
                    $stringReplaceWith  = [$user->full_name, $password, $user->email];
                    $newval             = str_replace($stringToReplace, $stringReplaceWith, $template->template);
                    $emailData          = $this->mailData($user->email, $template->subject, $newval, 'Account_detail', $template->id);
                    $this->mailSend($emailData);
                }

                return redirect()->route('admin.doctor.list')->with('success', 'Doctor ' . config('constants.SUCCESS.ADD_DONE'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method add**/


    /**
     * functionName : restore
     * createdDate  : 31-05-2024
     * purpose      : Delete the user by id
     */
    public function restore($id)
    {
        try {
            User::where('id', $id)->restore();
            return response()->json(["status" => "success", "message" => "User " . config('constants.SUCCESS.RESTORE_DONE')], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", $e->getMessage()], 500);
        }
    }
    /**End method restore**/

    /**
     * functionName : changeStatus
     * createdDate  : 31-05-2024
     * purpose      : Update the user status
     */
    public function changeStatus(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id'        => 'required',
                "status"    => "required|in:0,1",
            ]);
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(["status" => "error", "message" => $validator->errors()->first()], 422);
                }
            }

            User::where('id', $request->id)->update(['status' => $request->status]);

            return response()->json(["status" => "success", "message" => "User status " . config('constants.SUCCESS.CHANGED_DONE')], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", $e->getMessage()], 500);
        }
    }
    /**End method changeStatus**/

    /**
     * functionName : changeSubscription
     * createdDate  : 17-12-2024
     * purpose      : Upgrade the user premium
     */
    public function changeSubscription($id)
    {
        try {

            User::where('id', $id)->update(['plan_type' => 'premium']);

            return response()->json(["status" => "success", "message" => "User plan " . config('constants.SUCCESS.CHANGED_DONE')], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", $e->getMessage()], 500);
        }
    }
    /**End method changeSubscription**/
}
