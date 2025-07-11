<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{User,DoctorDetail};
use App\Notifications\UserNotification;
use App\Traits\SendResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator,Hash};

class UserController extends Controller
{
    use SendResponseTrait;
    /**
     * functionName : getList
     * createdDate  : 30-05-2024
     * purpose      : Get the list for all the user
    */
    public function getDoctorList(Request $request){
        try{
            $doctors = User::where("role_id",3)
                        ->when($request->filled('search_keyword'),function($query) use($request){
                            $query->where(function($query) use($request){
                                $query->where('first_name','like',"%$request->search_keyword%")
                                    ->orWhere('last_name','like',"%$request->search_keyword%")
                                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$request->search_keyword}%"])
                                    ->orWhere('email','like',"%$request->search_keyword%");
                            });
                        })
                        ->when($request->filled('status'),function($query) use($request){
                            $query->where('status',$request->status);
                        })
                        ->orderBy("id","desc")->paginate(10);
            return view("admin.doctor.list",compact("doctors"));
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/

    public function getPatientList(Request $request){
        try{
            $patients = User::where("role_id",4)
                        ->when($request->filled('search_keyword'),function($query) use($request){
                            $query->where(function($query) use($request){
                                $query->where('first_name','like',"%$request->search_keyword%")
                                    ->orWhere('last_name','like',"%$request->search_keyword%")
                                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$request->search_keyword}%"])
                                    ->orWhere('email','like',"%$request->search_keyword%");
                            });
                        })
                        ->when($request->filled('status'),function($query) use($request){
                            $query->where('status',$request->status);
                        })
                        ->orderBy("id","desc")->paginate(10);
            return view("admin.patient.list",compact("patients"));
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * functionName : add
     * createdDate  : 31-05-2024
     * purpose      : add the user
    */
    public function add(Request $request){
        try{
            if($request->isMethod('get')){
                
                return view("admin.doctor.add");

            }elseif( $request->isMethod('post') ){
                
                $validator = Validator::make($request->all(), [
                    'name'        => 'required|string|max:255',
                    'email'       => 'required|unique:users,email|email:rfc,dns',
                    'mobile_no'   => 'required|min:10',
                    'profile_pic' => 'image|max:2048',
                    'gender'      => 'required',
                    'birth_date'  => 'required',
                    'address'     => 'required',
                    'country'     => 'required',
                ]);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                
                $password = generateRandomString();
                
                $user = User::Create([
                    'role_id'           => 3,
                    'name'              => $request->name,
                    'email'             => $request->email,
                    'country'           => $request->country,
                    'country_code'      => '+91',
                    'password'          => $password,
                    'mobile_no'         => $request->mobile_no,
                    'email_verified_at' => date('Y-m-d H:i:s')
                ]);
                
                $ImgName = '';
                if ($request->hasFile('profile_pic')) {
                    $ImgName = uploadFile($request->file('profile_pic'),'images/');
                }

                $passportImg = '';
                if ($request->hasFile('ic_pic')) {
                    $passportImg = uploadFile($request->file('ic_pic'),'images/');
                }

                $eduImg = '';
                if ($request->hasFile('education')) {
                    $eduImg = uploadFile($request->file('education'),'images/');
                }

                $licenseImg = '';
                if ($request->hasFile('medical_license')) {
                    $licenseImg = uploadFile($request->file('medical_license'),'images/');
                }

                DoctorDetail::create([
                    'user_id'                 => $user->id,
                    'present_address'         => $request->address ? $request->address :'',
                    'permanent_address'       => $request->alt_address ? $request->alt_address :'',
                    'profile_pic'             => $ImgName,
                    'ic_pic'                  => $passportImg,
                    'education'               => $eduImg,
                    'gender'                  => $request->gender,
                    'current_wokplace'        => $request->current_workplace ? $request->current_workplace :'',
                    'birth_date'              => $request->birth_date ? $request->birth_date :'',
                    'education_qualification' => $request->education_qualification ? $request->education_qualification :'',
                    'about'                   => $request->about ? $request->about :'',
                    'clinic_interest'         => $request->clinic_interest ? $request->clinic_interest :'',
                    'clinic_fee'              => $request->clinic_fee ? $request->clinic_fee :'',
                    'clinic_follow_up'        => $request->clinic_follow_up ? $request->clinic_follow_up :'',
                    'chat_first_time'         => $request->chat_first_time ? $request->chat_first_time :'',
                    'chat_follow_up'          => $request->chat_follow_up ? $request->chat_follow_up :'',
                    'video_first_time'        => $request->video_first_time ? $request->video_first_time :'',
                    'video_follow_up'         => $request->video_follow_up ? $request->video_follow_up :'',
                    'appointment_description' => $request->appointment_description ? $request->appointment_description :'',
                    'timezone'                => $request->timezone ? $request->timezone :'',
                    'medical_license'         => $licenseImg,
                    'medical_certificate'     => $request->medical_certificate ? $request->medical_certificate :'',
                    'is_chat'                 => $request->has('is_chat') ? 1 : 0,
                    'is_video'                => $request->has('is_video') ? 1 : 0,
                    'is_clinic'               => $request->has('is_clinic') ? 1 : 0,
                ]);


                // $template = $this->getTemplateByName('Account_detail');
                // if( $template ) { 
                //     $stringToReplace    = ['{{$name}}','{{$password}}','{{$email}}'];
                //     $stringReplaceWith  = [$user->full_name,$password ,$user->email];
                //     $newval             = str_replace($stringToReplace, $stringReplaceWith, $template->template);
                //     $emailData          = $this->mailData($user->email, $template->subject, $newval, 'Account_detail', $template->id);
                //     $this->mailSend($emailData);
                // }

                return redirect()->route('admin.doctor.list')->with('success','Doctor '.config('constants.SUCCESS.ADD_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method add**/

    /**
     * functionName : view
     * createdDate  : 31-05-2024
     * purpose      : Get the detail of specific user
    */
    public function view($id){
        try{
            $user = User::findOrFail($id);
            return view("admin.doctor.view",compact("user"));
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method view**/

    /**
     * functionName : edit
     * createdDate  : 31-05-2024
     * purpose      : edit the user detail
    */
    public function edit(Request $request,$id){
        try{
            if($request->isMethod('get')){
                $user = User::with('doctorDetail')->find($id);
                return view("admin.doctor.edit",compact('user'));
            }elseif( $request->isMethod('post') ){
                $validator = Validator::make($request->all(), [
                    'name'        => 'required|string|max:255',
                    'email'       => 'required|email:rfc,dns',
                    'mobile_no'   => 'required|min:10',
                    'profile_pic' => 'image|max:2048',
                    'gender'      => 'required',
                    'birth_date'  => 'required',
                    'address'     => 'required',
                    'country'     => 'required',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                User::where('id' , $id)->update([
                    'name'        => $request->name,
                    'email'       => $request->email,
                ]);

                $user = User::with('doctorDetail')->find($id);

                $ImgName = $user->doctorDetail ? $user->doctorDetail->profile_pic : '';
                if ($request->hasFile('profile_pic')) {
                    deleteFile($ImgName,'images/');
                    $ImgName = uploadFile($request->file('profile_pic'),'images/');

                }

                $passportImg = $user->doctorDetail ? $user->doctorDetail->ic_pic : '';
                if ($request->hasFile('ic_pic')) {
                    deleteFile($passportImg,'images/');
                    $passportImg = uploadFile($request->file('ic_pic'),'images/');

                }

                $eduImg = $user->doctorDetail ? $user->doctorDetail->education : '';
                if ($request->hasFile('education')) {
                    deleteFile($eduImg,'images/');
                    $eduImg = uploadFile($request->file('education'),'images/');

                }

                $licenseImg = $user->doctorDetail ? $user->doctorDetail->medical_license : '';
                if ($request->hasFile('medical_license')) {
                    deleteFile($licenseImg,'images/');
                    $licenseImg = uploadFile($request->file('medical_license'),'images/');

                }

                DoctorDetail::updateOrCreate(['user_id' => $id],[
                    'present_address'         => $request->address ? $request->address :'',
                    'permanent_address'       => $request->alt_address ? $request->alt_address :'',
                    'profile_pic'             => $ImgName,
                    'ic_pic'                  => $passportImg,
                    'education'               => $eduImg,
                    'gender'                  => $request->gender,
                    'current_wokplace'        => $request->current_workplace ? $request->current_workplace :'',
                    'birth_date'              => $request->birth_date ? $request->birth_date :'',
                    'education_qualification' => $request->education_qualification ? $request->education_qualification :'',
                    'about'                   => $request->about ? $request->about :'',
                    'clinic_interest'         => $request->clinic_interest ? $request->clinic_interest :'',
                    'clinic_fee'              => $request->clinic_fee ? $request->clinic_fee :'',
                    'clinic_follow_up'        => $request->clinic_follow_up ? $request->clinic_follow_up :'',
                    'chat_first_time'         => $request->chat_first_time ? $request->chat_first_time :'',
                    'chat_follow_up'          => $request->chat_follow_up ? $request->chat_follow_up :'',
                    'video_first_time'        => $request->video_first_time ? $request->video_first_time :'',
                    'video_follow_up'         => $request->video_follow_up ? $request->video_follow_up :'',
                    'appointment_description' => $request->appointment_description ? $request->appointment_description :'',
                    'timezone'                => $request->timezone ? $request->timezone :'',
                    'medical_license'         => $licenseImg,
                    'medical_certificate'     => $request->medical_certificate ? $request->medical_certificate :'',
                    'is_chat'                 => $request->has('is_chat') ? 1 : 0,
                    'is_video'                => $request->has('is_video') ? 1 : 0,
                    'is_clinic'               => $request->has('is_clinic') ? 1 : 0,
                ]);
                return redirect()->route('admin.doctor.list')->with('success','User '.config('constants.SUCCESS.UPDATE_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method edit**/

    /**
     * functionName : delete
     * createdDate  : 31-05-2024
     * purpose      : Delete the user by id
    */
    public function delete($id){
        try{
            User::where('id',$id)->delete();     
            return response()->json(["status" => "success","message" => "User ".config('constants.SUCCESS.DELETE_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method delete**/

    /**
     * functionName : restore
     * createdDate  : 31-05-2024
     * purpose      : Delete the user by id
    */
    public function restore($id){
        try{
            User::where('id',$id)->restore();     
            return response()->json(["status" => "success","message" => "User ".config('constants.SUCCESS.RESTORE_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method restore**/

    /**
     * functionName : changeStatus
     * createdDate  : 31-05-2024
     * purpose      : Update the user status
    */
    public function changeStatus(Request $request){
        try{
            
            $validator = Validator::make($request->all(), [
                'id'        => 'required',
                "status"    => "required|in:0,1",
            ]);
            if ($validator->fails()) {
                if($request->ajax()){
                    return response()->json(["status" =>"error", "message" => $validator->errors()->first()],422);
                }
            }
           
            User::where('id',$request->id)->update(['status' => $request->status]);

            return response()->json(["status" => "success","message" => "User status ".config('constants.SUCCESS.CHANGED_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method changeStatus**/

    /**
     * functionName : changeSubscription
     * createdDate  : 17-12-2024
     * purpose      : Upgrade the user premium
    */
    public function changeSubscription($id){
        try{
            
            User::where('id',$id)->update(['plan_type' => 'premium']);

            return response()->json(["status" => "success","message" => "User plan ".config('constants.SUCCESS.CHANGED_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method changeSubscription**/
}