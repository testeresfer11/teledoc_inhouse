<?php
/*ini_set('display_errors', 1);
error_reporting(E_ALL);*/
class Doctors extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('doctors_model','pharmacies/pharmacy_model','booking_model'));
        $this->load->library(array('AesCipher'));
    }
    public function index() {
        $data['title'] = 'Doctors';
        $data['page'] =  'doctors';
        $data['active_url'] =  'doctor/doctors';
        $data['datatable'] = true;
        $data['data'] = $this->doctors_model->get_doctor(array());
        $this->load->view('template',$data);
    }

   public function create()
    {    
        $return_id  = $this->uri->segment(4);      
        if(empty($return_id))
        {
            $data['title'] = 'Doctors Create';
            $data['page'] = 'create_doctor';
            $data['active_url'] =  'doctor/doctors';
            $data['Department'] = $this->doctors_model->hospitaldepart(array('status'=>'active'));
            $data['countries'] = $this->pharmacy_model->getAllCountries();
            $data['Designation'] = array();//$this->doctors_model->getdocdesign(array('is_active'=>1));
            $data['doc'] = [];     
                 $doc_id = $this->input->post('doctor_id');
                 // $post = $this->input->post();
                 // echo "<pre>";
                 // print_r($post); die;
                 if($doc_id == null || $doc_id == '')
                 {
                     $this->form_validation->set_rules('first_name', 'Full Name', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('phone_no', 'Phone No', 'trim|required|strip_tags|xss_clean|numeric|callback_user_phone_exist');
                    // $this->form_validation->set_rules('ic_no', 'IC No', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('country_code', 'Country Code', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('country', 'Country', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('gender', 'Gender', 'trim|required|strip_tags|xss_clean|numeric');
                    $this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|required|strip_tags|xss_clean|callback_valid_date');
                    $this->form_validation->set_rules('present_address', 'Residential Address', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('permanent_address', 'Correspondence Address', 'trim|required|strip_tags|xss_clean');
                    //$this->form_validation->set_rules('registration_no', 'Registration No', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|strip_tags|xss_clean|valid_email|callback_user_email_exist');
                    $this->form_validation->set_rules('education', 'Education', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('current_workplace', 'Current Workplace', 'trim|required|strip_tags|xss_clean');
                     $this->form_validation->set_rules('aboutus', 'About Us', 'trim|required|strip_tags|xss_clean');
                    if ($this->form_validation->run() == FALSE)
                    {
                        $this->load->view('template',$data);
                    }// end if create form validation
                    else
                    {
                       
                       $service = $this->input->post('service', TRUE); // Fetch the selected services from POST data
                        $is_online = 0;
                        $is_clinic = 0;
                        $is_chat = 0;
                        $is_video = 0;
                        $is_home = 0;

                        for($i=0;$i<count($service);$i++)
                        {
                           
                            if($service[$i] == 'is_chat')
                            {
                                $is_chat = 1;
                            }
                            elseif ($service[$i] == 'is_video') {
                                $is_video = 1;
                            }
                            elseif ($service[$i] == 'is_clinic') {
                               $is_clinic = 1;
                            }
                            elseif ($service[$i] == 'is_home')
                            {
                                $is_home = 1;
                            }
                        }

                        $chat_first_time = '0.00';
                        $chat_follow_up = '0.00'; 
                        $video_first_time = '0.00';
                        $video_follow_up = '0.00';  
                        $home_first_time = '0.00'; 
                        $home_follow_up = '0.00';
                        $clinic_first_time = '0.00';
                        $clinic_follow_up = '0.00';
                        $chatFT = $this->input->post('chatFT');
                        $chatFU = $this->input->post('chatFU');
                        $videoFT = $this->input->post('videoFT');
                        $videoFU = $this->input->post('videoFU');
                        $homeFT = $this->input->post('homeFT');
                        $homeFU = $this->input->post('homeFU');
                        $clinicFT = $this->input->post('clinicFT');
                        $clinicFU = $this->input->post('clinicFU');
                        if(empty($chatFT))
                        {
                          $chat_first_time = '0.00';
                        }
                        else
                        {
                          $chat_first_time = $chatFT;
                        }
                        if(empty($chatFU))
                        {
                          $chat_follow_up = '0.00';
                        }
                        else
                        {
                          $chat_follow_up = $chatFU;
                        }
                        if(empty($videoFT))
                        {
                          $video_first_time = '0.00';
                        }
                        else
                        {
                          $video_first_time = $videoFT;
                        }
                        if(empty($videoFU))
                        {
                          $video_follow_up = '0.00';
                        }
                        else
                        {
                          $video_follow_up = $videoFU;
                        }
                        if(empty($homeFT))
                        {
                          $home_first_time = '0.00';
                        }
                        else
                        {
                          $home_first_time = $homeFT;
                        }
                        if(empty($homeFU))
                        {
                          $home_follow_up = '0.00';
                        }
                        else
                        {
                          $home_follow_up = $homeFU;
                        }
                         if(empty($clinicFT))
                        {
                          $clinic_first_time = '0.00';
                        }
                        else
                        {
                          $clinic_first_time = $clinicFT;
                        }
                        if(empty($clinicFU))
                        {
                          $clinic_follow_up = '0.00';
                        }
                        else
                        {
                          $clinic_follow_up = $clinicFU;
                        }
                        
                        $rcc_no = $this->input->post('rcc_no');
                        if(empty($rcc_no))
                        {
                          $rcc_no = '';
                        }
                        else
                        {
                          $rcc_no = AesCipher::encrypt($rcc_no);
                        }
                        // patient data
                        $user_id = get_user_id(2);
                       // prx($user_id);

                        if (!empty($_FILES['profile_image']['name']))
                        {
                            $fileinfo = @getimagesize($_FILES["profile_image"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["profile_image"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                  redirect('doctor/doctors');
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                   

                            }    // Validate image file size
                            else if (($_FILES["profile_image"]["size"] > 2000000)) {                   
                                 $this->session->set_flashdata('error','Image size exceeds 2MB');
                                  redirect('doctor/doctors');
                            }    // Validate image file dimension
                            else {
                                
                                $profile_name = '200220000_'.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $profile_name;
                                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target)) {
                                    $pic_path = $profile_name;
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading profile image.');
                                     redirect('doctor/doctors');
                                   
                                }
                            }
                        }else{
                            $pic_path= null;
                        }

                        if(!empty($_FILES['ic_pic']['name']))
                        {
                           $fileinfo = @getimagesize($_FILES["ic_pic"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["ic_pic"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["ic_pic"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                    redirect('doctor/doctors');
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                    redirect('doctor/doctors');

                            }   
                            else {
                                
                                $ic_picture = $user_id.'_'.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $ic_picture;
                                //$target = "upload/doctor/" . basename($_FILES["ic_pic"]["name"]);
                                if (move_uploaded_file($_FILES["ic_pic"]["tmp_name"], $target)) {
                                    $ic_path = $ic_picture;
                                     $upload = array('ic_pic'=>$ic_path);
                                   // $upload_ic_profile = $this->doctor_model->updatedoctorinfo($upload,$sess_data['user_id']);
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading ID/ passport Picture image files.');
                                    redirect('doctor/doctors');
                                   
                                }
                            }
                        }else{
                            $ic_path=null;
                        }

                        if(!empty($_FILES['education']['name'])){
                           $fileinfo = @getimagesize($_FILES["education"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["education"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["education"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                    redirect('doctor/doctors');
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                    redirect('doctor/doctors');

                            }    // Validate image file size
                              // Validate image file dimension
                            else {
                                
                                if(!empty($doctor[0]->education))
                                {
                                    $path = getcwd()."/upload/doctor/".$doctor[0]->education;
                                    unlink($path);
                                }
                                $education_picture = $user_id.'_'.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $education_picture;
                                if (move_uploaded_file($_FILES["education"]["tmp_name"], $target)) {
                                     $edu_path = $education_picture;
                                     $upload = array('education'=>$edu_path);
                                   
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading Education Certificate image files.');
                                    redirect('doctor/doctors');
                                   
                                }
                            }
                        }

                        if (!empty($_FILES['medical_license']['name'])) {
                            $fileinfo = @getimagesize($_FILES["medical_license"]["tmp_name"]);
                            $file_extension = pathinfo($_FILES["medical_license"]["name"], PATHINFO_EXTENSION);
                            if (!file_exists($_FILES["medical_license"]["tmp_name"])) {
                                $this->session->set_flashdata('error', 'Choose image file to upload.');
                                redirect('doctor/doctors');
                            } elseif (!in_array($file_extension, ["png", "jpg", "jpeg"])) {
                                $this->session->set_flashdata('error', 'Upload valid images. Only PNG, JPEG, and JPG are allowed.');
                                redirect('doctor/doctors');
                            } else {
                                if (!empty($doctor[0]->medical_license)) {
                                    $path = getcwd() . "/upload/doctor/" . $doctor[0]->medical_license;
                                    unlink($path);
                                }
                                $medical_license_filename = $user_id . '_' . rand(0, 999999) . '.' . $file_extension;
                                $target = getcwd() . "/upload/doctor/" . $medical_license_filename;
                                if (move_uploaded_file($_FILES["medical_license"]["tmp_name"], $target)) {
                                    $upload = ['medical_license' => $medical_license_filename];
                                    
                                } else {
                                    $this->session->set_flashdata('error', 'Problem in uploading medical license image files.');
                                    redirect('doctor/doctors');
                                }
                            }
                        }

                       
                        $patient_data = [
                            'doctor_id'    => $user_id,
                            'first_name'    => AesCipher::encrypt($this->input->post('first_name')),
                            'last_name'    => $this->input->post('first_name'),
                            'mobile_no'     => AesCipher::encrypt($this->input->post('phone_no')),
                            'country_code'  =>AesCipher::encrypt($this->input->post('country_code')),
                            'gender'        =>  (int) $this->input->post('gender'),
                            'profile_pic'        =>$pic_path,
                            'medical_license' => $medical_license_filename,
                            'education'=>$edu_path,
                            'ic_pic'=>$ic_path,
                            'birth_date'    =>  date('Y-m-d',strtotime($this->input->post('birth_date'))),
                            'present_address' => AesCipher::encrypt($this->input->post('present_address')),
                            'permanent_address' =>AesCipher::encrypt($this->input->post('permanent_address')),
                            'country'       => $this->input->post('country'),
                            'rcc_no' =>$rcc_no,
                            'education_qualification'=>AesCipher::encrypt($this->input->post('education')),
                            'current_wokplace'=>AesCipher::encrypt($this->input->post('current_workplace')),
                            'about'=>AesCipher::encrypt($this->input->post('aboutus')),
                            'hospital_department_id'=>$this->input->post('category'),
                            'clicnic_intrest'=>AesCipher::encrypt($this->input->post('clinic_intrest')),
                            'appointment_description'=>AesCipher::encrypt($this->input->post('appointment_description')),
                            'is_online'=>$is_online,
                            'timezone'=>$this->input->post('timezone'),
                            'is_home'=>$is_home,
                            'is_clinic'=>$is_clinic,
                            'is_chat'=>$is_chat,
                            'is_video'=>$is_video,
                            'created_by'    => $this->user_id,
                            'created_time'  => $this->created_time,
                            'created_by_ip' => $this->user_ip,
                            'chat_first_time'=>$chat_first_time,
                            'chat_follow_up'=>$chat_follow_up,
                            'video_first_time'=>$video_first_time,
                            'video_follow_up'=>$video_follow_up,
                            'home_fee'=>$home_first_time,
                            'home_follow_up'=>$home_follow_up,
                            'clinic_fee'=>$clinic_first_time,
                            'clinic_fllow_up'=>$clinic_follow_up,
                            'latitude' => $this->input->post('address_latitude'),
                            'longitude' => $this->input->post('address_longitude')
                        ];
                       
                         $p_name=  $this->input->post('first_name');
                         $namekey =  mb_substr($p_name, 0, 4);
                         $dob = $this->input->post('birth_date');
                         $dob1 = date('Y',strtotime($dob));
                         $generate_password = strtoupper($namekey).'@'.$dob1;
                         
                         $email = $this->input->post('email');
                         $user_data = [
                            'user_id'       => $user_id,
                            'email'         => (string) AesCipher::encrypt($this->input->post('email')),
                            'user_type'     => 2,
                            'mobile_no'     => AesCipher::encrypt($this->input->post('phone_no')),
                            'country_code'  =>AesCipher::encrypt($this->input->post('country_code')),
                            'password'      => (string) AesCipher::encrypt($generate_password),
                            'country'       => $this->input->post('country'),
                            'created_by'    => $this->user_id,
                            'created_time'  => $this->created_time,
                            'created_by_ip' => $this->user_ip,
                            'admin_approve'=>1,
                            'is_info'=>1                  
                        ];
                        $insert_catg_id = [];
                        $insert_spec_id = [];
                        $create = $this->doctors_model->create($patient_data,$user_data);
                      
    
                        $speciality = $this->input->post('speciality');
                        
                            for($i=0;$i<count($speciality);$i++)
                            {
                               // $insert_spec = array('doc_id'=>$user_id,'spec_id'=>$speciality[$i]);
                               
                                 $updateData = array('doc_id'=>$user_id,'spec_id'=>$speciality[$i],'chat_first_time'=>$chat_first_time, 'chat_follow_up'=>$chat_follow_up,'video_first_time'=>$video_first_time, 'video_follow_up'=>$video_follow_up,'home_first_time'=>$home_first_time, 'home_follow_up'=>$home_follow_up,'clinic_first_time'=>$clinic_first_time, 'clinic_follow_up'=>$clinic_follow_up);
                                  $insert_spec_id[] = $this->doctors_model->insertdocspeciality($updateData);
                            }

                        if ($create['status'] == 'success'  && count($insert_spec_id) > 0) 
                        {
                             $subject = 'Create Doctor';
                            $body ="Dear ".$p_name."<br /><br /> Your account has been created successfully. your password is combination of the first four letters of your name written in CAPITALS (Name as mentioned during signup) @ your Year of Birth (in YYYY format).";
                            $this->sendmail($email,$subject,$body);
                            $this->session->set_flashdata('success_message', 'New Doctor create successfully');
                            redirect('doctor/doctors');
                        } 
                        else 
                        {
                             $data['status'] = 'error';
                             $data['message'] = 'Doctor Not Created';
                            $data['Department'] = $this->doctors_model->hospitaldepart(array('status'=>'active'));
                            $data['Designation'] = $this->doctors_model->getdocdesign(array('is_active'=>1));
                            $this->load->view('template', $data);
                        }
                    } // end else create form validation

                 } // end if $doc_id
                 else
                 {
                    $this->form_validation->set_rules('first_name', 'Full Name', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('phone_no', 'Phone No', 'trim|required|strip_tags|xss_clean|numeric');
                    // $this->form_validation->set_rules('ic_no', 'IC No', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('country_code', 'Country Code', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('country', 'Country', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('gender', 'Gender', 'trim|required|strip_tags|xss_clean|numeric');
                    $this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|required|strip_tags|xss_clean|callback_valid_date');
                    $this->form_validation->set_rules('present_address', 'Residential Address', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('permanent_address', 'Correspondence Address', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('registration_no', 'Registration No', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|strip_tags|xss_clean|valid_email');
                    $this->form_validation->set_rules('education', 'Education', 'trim|required|strip_tags|xss_clean');
                    $this->form_validation->set_rules('current_workplace', 'Current Workplace', 'trim|required|strip_tags|xss_clean');
                     $this->form_validation->set_rules('aboutus', 'About Us', 'trim|required|strip_tags|xss_clean');
                     if ($this->form_validation->run() == FALSE)
                    {
                        $this->load->view('template',$data);
                    } // end if doctor update form validation
                    else
                    {
                            $doc_id = decrypt($doc_id);
                            $ $pic_path = $this->handle_image_upload('profile_image', 'doctor', $id);
           
                        if(!empty($_FILES['ic_pic']['name'])){
                               $fileinfo = @getimagesize($_FILES["ic_pic"]["tmp_name"]);
                                $width = $fileinfo[0];
                                $height = $fileinfo[1];    
                                $allowed_image_extension = array("png","jpg","jpeg");                
                                $file_extension = pathinfo($_FILES["ic_pic"]["name"], PATHINFO_EXTENSION);
                                if (! file_exists($_FILES["ic_pic"]["tmp_name"])) {
                                    $this->session->set_flashdata('error','Choose image file to upload');
                                        
                                }   
                                else if (! in_array($file_extension, $allowed_image_extension)) {
                                     $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                        

                                }    // Validate image file size
                                 // Validate image file dimension
                                else {
                                    if(!empty($doctor[0]->ic_pic))
                                    {
                                        $path = getcwd()."/upload/doctor/".$doctor[0]->ic_pic;
                                        unlink($path);                       
                                    }
                                    $ic_picture = $id.'_'.rand(0,999999).'.'.$file_extension;
                                    $target = getcwd()."/upload/doctor/" . $ic_picture;
                                    //$target = "upload/doctor/" . basename($_FILES["ic_pic"]["name"]);
                                    if (move_uploaded_file($_FILES["ic_pic"]["tmp_name"], $target)) {
                                         $ic_path = $ic_picture;
                                         $upload = array('ic_pic'=>$ic_path);
                                        $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                    } else {
                                         $this->session->set_flashdata('error','Problem in uploading ID/ passport Picture image files.');
                                        
                                       
                                    }
                                }
                        }
                        if(!empty($_FILES['education_pic']['name'])){
                           $fileinfo = @getimagesize($_FILES["education_pic"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["education_pic"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["education_pic"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                   
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                   

                            }    // Validate image file size
                              // Validate image file dimension
                            else {
                                
                                if(!empty($doctor[0]->education))
                                {
                                    $path = getcwd()."/upload/doctor/".$doctor[0]->education;
                                    unlink($path);
                                }
                                $education_picture = $id.'_'.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $education_picture;
                                if (move_uploaded_file($_FILES["education_pic"]["tmp_name"], $target)) {
                                     $edu_path = $education_picture;
                                     $upload = array('education'=>$edu_path);
                                    $$upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading Education Certificate image files.');
                                
                                   
                                }
                            }
                        }

                        if (!empty($_FILES['medical_license']['name'])) {
                            prx('lll');
                            $fileinfo = @getimagesize($_FILES["medical_license"]["tmp_name"]);
                            $file_extension = pathinfo($_FILES["medical_license"]["name"], PATHINFO_EXTENSION);
                            if (!file_exists($_FILES["medical_license"]["tmp_name"])) {
                                $this->session->set_flashdata('error', 'Choose image file to upload.');
                               
                            } elseif (!in_array($file_extension, ["png", "jpg", "jpeg"])) {
                                $this->session->set_flashdata('error', 'Upload valid images. Only PNG, JPEG, and JPG are allowed.');
                               
                            } else {
                                if (!empty($doctor[0]->medical_license)) {
                                    $path = getcwd() . "/upload/doctor/" . $doctor[0]->medical_license;
                                    unlink($path);
                                }
                                $medical_license_filename = $id . '_' . rand(0, 999999) . '.' . $file_extension;
                                $target = getcwd() . "/upload/doctor/" . $medical_license_filename;
                                if (move_uploaded_file($_FILES["medical_license"]["tmp_name"], $target)) {
                                    $upload = ['medical_license' => $medical_license_filename];
                                    $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                } else {
                                    $this->session->set_flashdata('error', 'Problem in uploading medical license image files.');
                                    
                                }
                            }
                        }
            // Process selected services
            $services = $this->input->post('service', TRUE) ?: [];

            $is_chat = in_array('chat_service', $services) ? 1 : 0;
            $is_video = in_array('video_service', $services) ? 1 : 0;
            $is_clinic = in_array('clinic_service', $services) ? 1 : 0;
            $is_home = in_array('home_service', $services) ? 1 : 0;
         
            $rcc_no = $this->input->post('rcc_no');
                        if(empty($rcc_no))
                        {
                          $rcc_no = '';
                        }
                        else
                        {
                          $rcc_no = AesCipher::encrypt($rcc_no);
                        }

                         $chat_first_time = $this->input->post('chatFT');
                        $chat_follow_up = $this->input->post('chatFU');
                        $video_first_time = $this->input->post('videoFT');
                        $video_follow_up = $this->input->post('videoFU');
                        $home_first_time = $this->input->post('homeFT');
                        $home_follow_up = $this->input->post('homeFU');
                        $clinic_first_time = $this->input->post('clinicFT');
                        $clinic_follow_up = $this->input->post('clinicFU');
            // Patient data array
            $patient_data = [
                'doctor_id' => $id,
                'first_name' => AesCipher::encrypt($this->input->post('first_name')),
                'last_name' => $this->input->post('first_name'),
                'mobile_no' => AesCipher::encrypt($this->input->post('phone_no')),
                'country_code' => AesCipher::encrypt('234'),
                'gender' => (int) $this->input->post('gender'),
                
                'birth_date' => date('Y-m-d', strtotime($this->input->post('birth_date'))),
                'present_address' => AesCipher::encrypt($this->input->post('present_address')),
                'permanent_address' => AesCipher::encrypt($this->input->post('permanent_address')),
                'country' => $this->input->post('country'),
               /* 'registeration_no' => AesCipher::encrypt($this->input->post('registration_no')),*/
                'rcc_no' => $rcc_no,
                'education_qualification' => AesCipher::encrypt($this->input->post('education')),
                'current_wokplace' => AesCipher::encrypt($this->input->post('current_workplace')),
                'about' => AesCipher::encrypt($this->input->post('aboutus')),
                'hospital_department_id' => $this->input->post('category'),
                'clicnic_intrest' => AesCipher::encrypt($this->input->post('clinic_intrest')),
                'appointment_description' => AesCipher::encrypt($this->input->post('appointment_description')),
                'is_online' => 0,
                'timezone' => $this->input->post('timezone'),
                'is_home' => $is_home,
                'is_clinic' => $is_clinic,
                'is_chat' => $is_chat,
                'is_video' => $is_video,
                'created_by' => $this->user_id,
                'created_time' => $this->created_time,
                'created_by_ip' => $this->user_ip,
                'chat_first_time' => $chat_first_time,
                'chat_follow_up' => $chat_follow_up,
                'video_first_time' => $video_first_time,
                'video_follow_up' => $video_follow_up,
                'home_fee' => $home_first_time,
                'home_follow_up' => $home_follow_up,
                'clinic_fee' => $clinic_first_time,
                'clinic_fllow_up' => $clinic_follow_up,
                'latitude' => $this->input->post('address_latitude'),
                'longitude' => $this->input->post('address_longitude')
            ];
         

            $user_data = [
                'user_type' => 2,
                'mobile_no' => AesCipher::encrypt($this->input->post('phone_no')),
                'country_code' => AesCipher::encrypt($this->input->post('country_code')),
                'created_by' => $this->user_id,
                'updated_time' => $this->created_time,
                'created_by_ip' => $this->user_ip,
                'timezone' => $this->input->post('timezone'),
                'admin_approve' => 1,
                'is_info' => 1
            ];

                        if(!empty($speciality)){
                            $delcatg = $this->doctors_model->deletedoctorspeciality(array('doc_id'=>$doc_id));
                            for($i=0;$i<count($speciality);$i++)
                            {
                                $insert_spec = array('doc_id'=>$doc_id,'spec_id'=>$speciality[$i]);
                                $insert_spec_id[] = $this->doctors_model->insertdocspeciality($insert_spec);
                            }
                        }
                         if ($create >0 && count($insert_catg_id) > 0 && count($insert_spec_id) > 0) 
                            {
                                $this->session->set_flashdata('success_message', 'New Doctor updated successfully');
                                redirect('doctor/doctors');
                            } 
                            else 
                            {
                               
                                $data['title'] = 'Doctors Update';
                                $data['page'] = 'create_doctor';
                                $data['active_url'] =  'doctor/doctors/create/'.$return_id;
                                $data['Department'] = $this->doctors_model->hospitaldepart(array('status'=>'active'));
                                $data['Designation'] = $this->doctors_model->getdocdesign(array('is_active'=>1));
                                $return_id = decrypt($return_id);
                                $data['doc'] = $this->doctors_model->get_doctors(array('u.user_id'=>$return_id));
                                $spec = $this->doctors_model->getspeciality(array('doc_id'=>$return_id));
                                $catg = $this->doctors_model->getcategory(array('doc_id'=>$return_id));
                                $speciality = [] ;
                                $category = [];
                                foreach($spec as $key)
                                {
                                    $speciality[] = $key->id;
                                }
                                foreach($catg as $key)
                                {
                                    $category[] = $key->id;
                                }
                                $data['speciality'] = $speciality;
                                $data['category'] = $category;    
                                 $data['doc'] = [];     
                                $this->load->view('template', $data);
                            }
                    }// end else doctor update form validation
                 } // end else $doc_id
       }// end if return_id
       
    }

    public function add_clinic($user_id)
    {

        $data['title'] = 'Create Doctor Clinic';
        $data['page'] =  'clinic';
        $data['active_url'] =  'doctor/doctors';
        $data['user_id'] = $user_id;
        $data['clinic'] = $this->doctors_model->getclinics(array('c.doctor_id'=>decrypt($user_id)));
       // prx($data['clinic']);
        $this->load->view('template', $data);
    }

    public function createclinic()
    {
            $clinic_name = $this->input->post('clinic_name');
            $clinic_address = $this->input->post('clinic_address');
            $time_slot = $this->input->post('select_time');
            $user_id = $this->input->post('user_id');
           
            $clinic_data = $this->input->post('exit_doctor');
            if($clinic_data == 0){
            $user_id = decrypt($user_id);
            // prx($user_id);
            $clinic_id = [];
            $time_id = [];
            $new_time = '';
            for($i=0;$i<count($clinic_name);$i++)
            {
                if($clinic_name[$i] != '')
                {
                    $insert = array('doctor_id'=>$user_id,'name'=>(string)AesCipher::encrypt($clinic_name[$i]),'address'=>(string)AesCipher::encrypt($clinic_address[$i]),'latitude'=>'','longitude'=>'','status'=>'active');
                    $clinic_id = $this->doctors_model->inertclinic($insert);
                    

                        $new_time = explode(',', $time_slot[$i]);
                        for($j=0;$j<count($new_time);$j++)
                        {
                           $ex_time = explode('#', $new_time[$j]);
                           $insert_time = array('doctor_id'=>$user_id,'clinic_id'=>$clinic_id,'day'=>$ex_time[0],'start_time'=>$ex_time[1],'end_time'=>$ex_time[2],'evening_start_time'=>$ex_time[3],'evening_end_time'=>$ex_time[4],'created_time'=>date('Y-m-d h:i:s'),'created_by'=>$user_id);  
                            $time_id[] = $this->doctors_model->inserttimeslot($insert_time);        
                        }    
                }                
            }
           
            if(count($clinic_id) >0 && count($time_slot)>0)
            {
                 $update = array('is_clinic'=>1,'is_doc'=>1);
                $up = $this->doctors_model->updateuser($update,$user_id);
               $this->session->set_flashdata('success_message', 'Clinic create successfully');
                    redirect('doctor/doctors/add_fees/'.encrypt($user_id));
            }
            else
            {
                 $this->session->set_flashdata('error_message', 'Clinic not create.Please try again later');
                    redirect('doctor/doctors/add_clinic/'.encrypt($user_id));
            }
        }
        else
        {
            $user_id = decrypt($user_id);
            
            $clinic_id = [];
            $time_id = [];
            $new_time = '';
            $dell = $this->doctors_model->deleteclinic(array('doctor_id'=>$user_id));
            $delete = $this->doctors_model->deletetimeslot(array('doctor_id'=>$user_id));
            for($i=0;$i<count($clinic_name);$i++)
            {
                if($clinic_name[$i] != '')
                {
                    $insert = array('doctor_id'=>$user_id,'name'=>(string)AesCipher::encrypt($clinic_name[$i]),'address'=>(string)AesCipher::encrypt($clinic_address[$i]),'latitude'=>'','longitude'=>'','status'=>'active');
                    $clinic_id = $this->doctors_model->inertclinic($insert);
                    

                        $new_time = explode(',', $time_slot[$i]);
                        for($j=0;$j<count($new_time);$j++)
                        {
                           $ex_time = explode('#', $new_time[$j]);
                           $insert_time = array('doctor_id'=>$user_id,'clinic_id'=>$clinic_id,'day'=>$ex_time[0],'start_time'=>$ex_time[1],'end_time'=>$ex_time[2],'evening_start_time'=>$ex_time[3],'evening_end_time'=>$ex_time[4],'created_time'=>date('Y-m-d h:i:s'),'created_by'=>$user_id);  
                            $time_id[] = $this->doctors_model->inserttimeslot($insert_time);        
                        }    
                }                
            }
           
            if(count($clinic_id) >0 && count($time_slot)>0)
            {
                 $update = array('is_clinic'=>1,'is_doc'=>1);
                $up = $this->doctors_model->updateuser($update,$user_id);
               $this->session->set_flashdata('success_message', 'Clinic Updated successfully');
                    redirect('doctor/doctors/add_fees/'.encrypt($user_id));
            }
            else
            {
                 $this->session->set_flashdata('error_message', 'Clinic not Updated.Please try again later');
                    redirect('doctor/doctors/add_clinic/'.encrypt($user_id));
            }
        }

    }
    public function add_fees($user_id)
    {
        $data['title'] = 'Doctors';
        $data['page'] =  'fees';
        $data['active_url'] =  'doctor/fees';
        $data['user_id'] = $user_id;
        $user_id = decrypt($user_id);
        $data['doc'] = $this->doctors_model->get_doctors(array('u.user_id'=>$user_id));
        $specialities = $this->doctors_model->getdoctorspecialitiesWithName(array('s.doc_id'=>$user_id));
        $data['specialities'] = $specialities;
        $this->load->view('template', $data);
    }

    public function savefees()
    {
         $data['title'] = 'Doctors';
        $data['page'] =  'fees';
        $data['active_url'] =  'doctor/fees';   
        
        $post = $this->input->post();
     
       

       
        if(!empty($post)){
        $user_id = decrypt($post['user_id']);
      
        $doctor = $this->doctors_model->saveCVOH($post); // CVOH -> Chat,video,online and home

       
        $specialities = $this->doctors_model->getdoctorspecialities(array('doc_id'=>$user_id));
       
        $specialities[0]->chat_first_time   = $post['chat_first_time'];
        $specialities[0]->chat_follow_up    = $post['chat_follow_up'];
        $specialities[0]->video_first_time  = $post['video_first_time'];
        $specialities[0]->video_follow_up   = $post['video_follow_up'];
        $specialities[0]->home_first_time   = $post['home_first_time'];
        $specialities[0]->home_follow_up    = $post['home_follow_up'];
        $specialities[0]->clinic_first_time = $post['clinic_first_time'];
        $specialities[0]->clinic_follow_up  = $post['clinic_follow_up'];


        foreach($specialities as $speciality){
            $price_first_time = $post['categoryFT'.$speciality->spec_id];
            $price_follow_up = $post['categoryFU'.$speciality->spec_id];
            $updateData = array('price_first_time'=>$price_first_time, 'price_follow_up'=>$price_follow_up);
            $updateSpec = $this->doctors_model->updateDoctorSpecility(array('doc_id'=>$user_id,'spec_id'=>$speciality->spec_id),$updateData);
        }
      
            $update = array('is_fees'=>1);
            $up = $this->doctors_model->updateuser($update,$user_id);
            $this->session->set_flashdata('success_message','Doctor Information saved successfully.');
           redirect('doctor/doctors/add_commission/'.encrypt($user_id));
        
       }
       else
       {
            $this->session->set_flashdata('success_message','Something went wrong. Please try again later');
            redirect('doctor/doctors/add_fees/'.$post['user_id']);
            
       }
            

    }

    public function view()
    {
        $data['title'] = 'Doctors';
        $data['page'] =  'view';
        $data['active_url'] =  'doctor/view';
        $user_id = $this->uri->segment(4);
        $user_id = decrypt($user_id);
       //prx($user_id);
        $doc = $this->doctors_model->get_doctors(array('u.user_id'=>$user_id));
       $data['doctor'] = $this->doctors_model->get_doctors(array('u.user_id'=>$user_id));
        $data['speciality'] = $this->doctors_model->getspeciality(array('doc_id'=>$doc[0]->user_id));
        $data['category'] = $this->doctors_model->getcategory(array('doc_id'=>$doc[0]->user_id));
        $data['category_name'] = $this->doctors_model->getcategories(array('id'=>$doc[0]->hospital_department_id));
       
        $clinic = $this->doctors_model->getclinic(array('c.doctor_id'=>$user_id));
        //prx($clinic);
        $orderr = [];
       foreach ($clinic as $key => $value) {
            $orderr[$value->id][] = $value;
        }
       $data['clinic'] = $orderr;
        $data['doc'] = $doc;
        $data['online'] = $this->doctors_model->getdoctorschedule(array('doctor_id'=>$user_id,'service'=>'online'));
        $data['home'] = $this->doctors_model->getdoctorschedule(array('doctor_id'=>$user_id,'service'=>'home'));
        $data['specialities'] = $this->doctors_model->getdoctorspecialitiesWithName(array('doc_id'=>$user_id));
        $data['bank_details'] = $this->doctors_model->getdoctoraccount(array('doctor_id'=>$user_id));
        
        $this->load->view('template', $data);
    }
    // check valid date
    public function valid_date($birth_date) {
        $valid = validateDate($birth_date);
        if($valid){
            return true;
        }
        else {
            $this->form_validation->set_message('valid_date', 'The Birth date is not valid');
            return false;
        }
    }

    // user email exist
    public function user_email_exist($email) {

        /*
         * email exist check based on user type like employee,doctor,patient
         * */
        $param = array('email'=>(string) AesCipher::encrypt($this->input->post('email')));
        $exist = $this->doctors_model->user_email_exist($param);
        if($exist) {
            $this->form_validation->set_message('user_email_exist', 'The Email address already exist');
            return false;
        }
        else {
            return true;
        }

    }
     public function user_phone_exist($email) {

        /*
         * email exist check based on user type like employee,doctor,patient
         * */
        $param = array('mobile_no'=>(string) AesCipher::encrypt($this->input->post('phone_no')));
        $exist = $this->doctors_model->user_email_exist($param);
        if($exist) {
            $this->form_validation->set_message('user_phone_exist', 'The Phone No. already exist');
            return false;
        }
        else {
            return true;
        }

    }


    // valid user picture
    public function valid_user_picture() {

        if (empty($_FILES['picture']['name'])) {
            $this->form_validation->set_message('valid_user_picture', 'The Picture field is empty');
            return false;
        }
        else {
            return true;
        }

    }

   public function update() {
    $id = (int) isset($_POST['id']) ? $this->input->post('id') : $this->uri->segment(4);
    $return_id = $this->uri->segment(4);

    $data['title'] = 'Doctor update';
    $data['page'] = 'update_doctor';
    $data['active_url'] = 'doctor/doctors';
    $data['data'] = $this->doctors_model->get_doctors(array('u.user_id' => $id));

    $data['Designation'] = $this->doctors_model->getdocdesign(array('is_active' => 1));
   // prx($_FILES);
    if (isset($_POST['submit'])) {
        $this->form_validation->set_rules('first_name', 'Full Name', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('phone_no', 'Phone No', 'trim|required|strip_tags|xss_clean|numeric');

        $this->form_validation->set_rules('country', 'Country', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|strip_tags|xss_clean|numeric');
        $this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|required|strip_tags|xss_clean|callback_valid_date');
        $this->form_validation->set_rules('present_address', 'Residential Address', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('permanent_address', 'Correspondence Address', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('registration_no', 'Registration No', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('education', 'Education', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('current_workplace', 'Current Workplace', 'trim|required|strip_tags|xss_clean');
        $this->form_validation->set_rules('aboutus', 'About Us', 'trim|required|strip_tags|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template',$data);
        } else {
           // prx($_FILES);
            // Handle image uploads
             if (!empty($_FILES['profile_image']['name']))
                        {
                            $fileinfo = @getimagesize($_FILES["profile_image"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["profile_image"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                  redirect('doctor/doctors');
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                   

                            }    // Validate image file size
                            else if (($_FILES["profile_image"]["size"] > 2000000)) {                   
                                 $this->session->set_flashdata('error','Image size exceeds 2MB');
                                  redirect('doctor/doctors');
                            }    // Validate image file dimension
                            else {
                                
                                $profile_name = $id.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $profile_name;
                                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target)) {
                                    $pic_path = $profile_name;
                                     $upload = array('profile_pic'=>$pic_path);
                                   $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading profile image.');
                                     redirect('doctor/doctors');
                                   
                                }
                            }
                        }
                    
                        if(!empty($_FILES['ic_pic']['name'])){
                               $fileinfo = @getimagesize($_FILES["ic_pic"]["tmp_name"]);
                                $width = $fileinfo[0];
                                $height = $fileinfo[1];    
                                $allowed_image_extension = array("png","jpg","jpeg");                
                                $file_extension = pathinfo($_FILES["ic_pic"]["name"], PATHINFO_EXTENSION);
                                if (! file_exists($_FILES["ic_pic"]["tmp_name"])) {
                                    $this->session->set_flashdata('error','Choose image file to upload');
                                        
                                }   
                                else if (! in_array($file_extension, $allowed_image_extension)) {
                                     $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                        

                                }    // Validate image file size
                                 // Validate image file dimension
                                else {
                                    if(!empty($doctor[0]->ic_pic))
                                    {
                                        $path = getcwd()."/upload/doctor/".$doctor[0]->ic_pic;
                                        unlink($path);                       
                                    }
                                    $ic_picture = $id.'_'.rand(0,999999).'.'.$file_extension;
                                    $target = getcwd()."/upload/doctor/" . $ic_picture;
                                    //$target = "upload/doctor/" . basename($_FILES["ic_pic"]["name"]);
                                    if (move_uploaded_file($_FILES["ic_pic"]["tmp_name"], $target)) {
                                         $ic_path = $ic_picture;
                                         $upload = array('ic_pic'=>$ic_path);
                                        $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                    } else {
                                         $this->session->set_flashdata('error','Problem in uploading ID/ passport Picture image files.');
                                        
                                       
                                    }
                                }
                        }
                        if(!empty($_FILES['education_pic']['name'])){
                           $fileinfo = @getimagesize($_FILES["education_pic"]["tmp_name"]);
                            $width = $fileinfo[0];
                            $height = $fileinfo[1];    
                            $allowed_image_extension = array("png","jpg","jpeg");                
                            $file_extension = pathinfo($_FILES["education_pic"]["name"], PATHINFO_EXTENSION);
                            if (! file_exists($_FILES["education_pic"]["tmp_name"])) {
                                $this->session->set_flashdata('error','Choose image file to upload');
                                   
                            }   
                            else if (! in_array($file_extension, $allowed_image_extension)) {
                                 $this->session->set_flashdata('error','Upload valid images. Only PNG and JPEG and JPG are allowed');
                                   

                            }    // Validate image file size
                              // Validate image file dimension
                            else {
                                
                                if(!empty($doctor[0]->education))
                                {
                                    $path = getcwd()."/upload/doctor/".$doctor[0]->education;
                                    unlink($path);
                                }
                                $education_picture = $id.'_'.rand(0,999999).'.'.$file_extension;
                                $target = getcwd()."/upload/doctor/" . $education_picture;
                                if (move_uploaded_file($_FILES["education_pic"]["tmp_name"], $target)) {
                                     $edu_path = $education_picture;
                                     $upload = array('education'=>$edu_path);
                                    $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                    
                                } else {
                                     $this->session->set_flashdata('error','Problem in uploading Education Certificate image files.');
                                
                                   
                                }
                            }
                        }

                        if (!empty($_FILES['medical_license']['name'])) {
                          
                            $fileinfo = @getimagesize($_FILES["medical_license"]["tmp_name"]);
                            $file_extension = pathinfo($_FILES["medical_license"]["name"], PATHINFO_EXTENSION);
                            if (!file_exists($_FILES["medical_license"]["tmp_name"])) {
                                $this->session->set_flashdata('error', 'Choose image file to upload.');
                               
                            } elseif (!in_array($file_extension, ["png", "jpg", "jpeg"])) {
                                $this->session->set_flashdata('error', 'Upload valid images. Only PNG, JPEG, and JPG are allowed.');
                               
                            } else {
                                if (!empty($doctor[0]->medical_license)) {
                                    $path = getcwd() . "/upload/doctor/" . $doctor[0]->medical_license;
                                    unlink($path);
                                }
                                $medical_license_filename = $id . '_' . rand(0, 999999) . '.' . $file_extension;
                                $target = getcwd() . "/upload/doctor/" . $medical_license_filename;
                                if (move_uploaded_file($_FILES["medical_license"]["tmp_name"], $target)) {
                                    $upload = ['medical_license' => $medical_license_filename];
                                    $upload_ic_profile = $this->doctors_model->updatedoctorinfo($upload,$id);
                                } else {
                                    $this->session->set_flashdata('error', 'Problem in uploading medical license image files.');
                                    
                                }
                            }
                        }
                    // Process selected services
                    $services = $this->input->post('service', TRUE) ?: [];

                    $is_chat = in_array('chat_service', $services) ? 1 : 0;
                    $is_video = in_array('video_service', $services) ? 1 : 0;
                    $is_clinic = in_array('clinic_service', $services) ? 1 : 0;
                    $is_home = in_array('home_service', $services) ? 1 : 0;
         
                    $rcc_no = $this->input->post('rcc_no');
                        if(empty($rcc_no))
                        {
                          $rcc_no = '';
                        }
                        else
                        {
                          $rcc_no = AesCipher::encrypt($rcc_no);
                        }

                        $chat_first_time = $is_chat ? $this->input->post('chatFT') : '0.00';
                        $chat_follow_up = $is_chat ? $this->input->post('chatFU') : '0.00';
                        $video_first_time = $is_video ? $this->input->post('videoFT') : '0.00';
                        $video_follow_up = $is_video ? $this->input->post('videoFU') : '0.00';
                        $home_first_time = $is_home ? $this->input->post('homeFT') : '0.00';
                        $home_follow_up = $is_home ? $this->input->post('homeFU') : '0.00';
                        $clinic_first_time = $is_clinic ? $this->input->post('clinicFT') : '0.00';
                        $clinic_follow_up = $is_clinic ? $this->input->post('clinicFU') : '0.00';
            // Patient data array
            $patient_data = [
                'doctor_id' => $id,
                'first_name' => AesCipher::encrypt($this->input->post('first_name')),
                'last_name' => $this->input->post('first_name'),
                'mobile_no' => AesCipher::encrypt($this->input->post('phone_no')),
                'country_code' => AesCipher::encrypt('234'),
                'gender' => (int) $this->input->post('gender'),
                
                'birth_date' => date('Y-m-d', strtotime($this->input->post('birth_date'))),
                'present_address' => AesCipher::encrypt($this->input->post('present_address')),
                'permanent_address' => AesCipher::encrypt($this->input->post('permanent_address')),
                'country' => $this->input->post('country'),
                'registeration_no' => AesCipher::encrypt($this->input->post('registration_no')),
                'rcc_no' => $rcc_no,
                'education_qualification' => AesCipher::encrypt($this->input->post('education')),
                'current_wokplace' => AesCipher::encrypt($this->input->post('current_workplace')),
                'about' => AesCipher::encrypt($this->input->post('aboutus')),
                'hospital_department_id' => $this->input->post('category'),
                'clicnic_intrest' => AesCipher::encrypt($this->input->post('clinic_intrest')),
                'appointment_description' => AesCipher::encrypt($this->input->post('appointment_description')),
                'is_online' => 0,
                'timezone' => $this->input->post('timezone'),
                'is_home' => $is_home,
                'is_clinic' => $is_clinic,
                'is_chat' => $is_chat,
                'is_video' => $is_video,
                'created_by' => $this->user_id,
                'created_time' => $this->created_time,
                'created_by_ip' => $this->user_ip,
                'chat_first_time' => $chat_first_time,
                'chat_follow_up' => $chat_follow_up,
                'video_first_time' => $video_first_time,
                'video_follow_up' => $video_follow_up,
                'home_fee' => $home_first_time,
                'home_follow_up' => $home_follow_up,
                'clinic_fee' => $clinic_first_time,
                'clinic_fllow_up' => $clinic_follow_up,
                'latitude' => $this->input->post('address_latitude'),
                'longitude' => $this->input->post('address_longitude')
            ];
          
            $user_data = [
                'user_type' => 2,
                'mobile_no' => AesCipher::encrypt($this->input->post('phone_no')),
                'country_code' => AesCipher::encrypt($this->input->post('country_code')),
                'created_by' => $this->user_id,
                'updated_time' => $this->created_time,
                'created_by_ip' => $this->user_ip,
                'timezone' => $this->input->post('timezone'),
                'admin_approve' => 1,
                'is_info' => 1
            ];

            $create = $this->doctors_model->updatedoctors($user_data, $patient_data,$id);
            $speciality = $this->input->post('speciality');
            if(!empty($speciality)){
            
            
                        
                            for($i=0;$i<count($speciality);$i++)
                            {
                                //$insert_spec = array('doc_id'=>$user_id,'spec_id'=>$speciality[$i]);
                               
                                 $updateData = array('doc_id'=>$id,'spec_id'=>$speciality[$i],'chat_first_time'=>$chat_first_time, 'chat_follow_up'=>$chat_follow_up,'video_first_time'=>$video_first_time, 'video_follow_up'=>$video_follow_up,'home_first_time'=>$home_first_time, 'home_follow_up'=>$home_follow_up,'clinic_first_time'=>$clinic_first_time, 'clinic_follow_up'=>$clinic_follow_up);
                                
                                  $insert_spec_id[] = $this->doctors_model->updatedocspeciality($updateData,$id);
                            }
                           // prx($insert_spec_id);
            }

            if ($create['status'] == 'success') {
                $this->session->set_flashdata('success_message', 'Doctor Information Update successfully');
                redirect('doctor/doctors');
            } else {
                $data['status'] = $create['status'];
                $data['message'] = $create['message'];
                $this->load->view('template', $data);
            }
        }
    } else {
        $return_id = $return_id;

        $doc = $this->doctors_model->get_doctors(array('u.user_id' => $return_id));
        $spec = $this->doctors_model->getspeciality(array('doc_id' => $return_id));
        $catg = $this->doctors_model->getcategory(array('doc_id' => $return_id));
        $data['categories'] = $this->doctors_model->getcategories(array('status' => 'active'));
        $data['specialities'] = $this->doctors_model->getdoctorspecialitiesWithName(array('s.doc_id' => $return_id));
        $data['Designation'] = $this->doctors_model->getdocdesign(array('category_id' => $doc[0]->hospital_department_id));
        $data['doc'] = $doc;

        $speciality = [];
        $category = [];
        foreach ($spec as $key) {
            $speciality[] = $key->id;
        }

        $data['speciality'] = $speciality;
        $data['category'] = $category;
        $this->load->view('template', $data);
    }
}

/**
 * Handle image upload and return the uploaded file path.
 * 
 * @param string $field_name
 * @param string $folder
 * @param int $user_id
 * @param string|null $old_file
 * @return string|null
 */
private function handle_image_upload($field_name, $folder, $user_id, $old_file = null) {
    if (!empty($_FILES[$field_name]['name'])) {
        $fileinfo = @getimagesize($_FILES[$field_name]["tmp_name"]);
        $file_extension = pathinfo($_FILES[$field_name]["name"], PATHINFO_EXTENSION);
        $allowed_image_extension = array("png", "jpg", "jpeg");

        if (!file_exists($_FILES[$field_name]["tmp_name"])) {
            $this->session->set_flashdata('error', 'Choose image file to upload');
            redirect('doctor/doctors');
        } elseif (!in_array($file_extension, $allowed_image_extension)) {
            $this->session->set_flashdata('error', 'Upload valid images. Only PNG and JPEG and JPG are allowed');
            redirect('doctor/doctors');
        } elseif ($_FILES[$field_name]["size"] > 2000000) {
            $this->session->set_flashdata('error', 'Image size exceeds 2MB');
            redirect('doctor/doctors');
        } else {
            if ($old_file) {
                $old_file_path = getcwd() . "/upload/$folder/$old_file";
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }

            $new_filename = $user_id . '_' . rand(0, 999999) . '.' . $file_extension;
            $target = getcwd() . "/upload/$folder/" . $new_filename;

            if (move_uploaded_file($_FILES[$field_name]["tmp_name"], $target)) {
                return $new_filename;
            } else {
                $this->session->set_flashdata('error', 'Problem in uploading image files.');
                redirect('doctor/doctors');
            }
        }
    }
    return null;
}


     public function sendmail($email,$title,$body)
    {

        $config = Array(
        'protocol' => SMTP_PROTOCOL,
        'smtp_host' => SMTP_HOST,
        'smtp_port' => SMTP_PORT,
        'smtp_user' => SMTP_USER,
        'smtp_pass' => SMTP_PASS,
        'mailtype'  => SMTP_MAILTYPE, 
        'charset'   => SMTP_CHARSET,
        'newline' => "\r\n"
    );

        /*$setting = appsetting();
        $support_email = $setting[0]->support_email;
        $application_name = $setting[0]->website_title;*/
        $this->load->library('email');
         $this->email->initialize($config);
        //$this->email->set_newline("\r\n");
        $mail_from = SMTP_USER;
        $mail_from_name = APP_TITLE;
        $this->email->from($mail_from, $mail_from_name);
        $this->email->to($email);
        $this->email->subject($title);
        $this->email->message($body);
        $this->email->send();
    //prx($this->email->print_debugger());
        //$this->Emaillibrary->sendEmail($email,$title,$body);
    
    }

    public function status()
    {

        $doctor_id = $this->uri->segment(4);
        $status = $this->uri->segment(5);
        if($status == 'rejectDoctor')
        {
            $update = array('admin_approve'=>0);
            $update_id = $this->doctors_model->updatedoctorsss($update,$doctor_id);
             $updates = array('is_active'=>2);
            $updated_doc = $this->doctors_model->updatedoctorstatus($updates,$doctor_id);
            if($update_id > 0 || $updated_doc > 0)
            {
                 $this->session->set_flashdata('success_message', 'Doctor Unapproved successfully');
                    redirect('doctor/doctors');
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Doctor not approved due to technical issue');
                    redirect('doctor/doctors');
            }
        }
        elseif($status == 'approve'){

            $update = array('admin_approve'=>1);
            $update_id = $this->doctors_model->updatedoctorsss($update,$doctor_id);
            $updates = array('is_active'=>1);
            $updated_doc = $this->doctors_model->updatedoctorstatus($updates,$doctor_id);
         
             if($update_id > 0 || $updated_doc > 0)
            {
                 $this->session->set_flashdata('success_message', 'Doctor approved successfully');
                    redirect('doctor/doctors/add_commission/'.encrypt($doctor_id));
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Doctor not approved due to technical issue');
                    redirect('doctor/doctors');
            }
        }
        else
        {
             $this->session->set_flashdata('error_message', 'Something Went Wrong. Please try again later');
                    redirect('doctor/doctors');
        }
    }

    public function add_commission()
    {
        $data['title'] = 'Doctors';
        $data['page'] =  'commission';       
        $user_id = $this->uri->segment(4);
        $data['active_url'] =  'doctor/add_commission/'.$user_id;
        $user_id = decrypt($user_id);

        $data['doctor'] = $this->doctors_model->get_doctors(array('u.user_id'=>$user_id));
        //prx($data);
         $this->load->view('template',$data);
    }

    public function savecommission()
    {
        $online_com = $this->input->post('online_commission');
        $home_com = $this->input->post('home_commission');
        $clinic_com = $this->input->post('clinic_commission');
        $doctor_id = decrypt($this->input->post('doctor_id'));
        if(!empty($online_com) && $online_com == 0)
        {
             $this->session->set_flashdata('error_message', 'Online Commission is required');
                    redirect('doctor/doctors/add_commission/'.encrypt($doctor_id));
        }
        elseif (!empty($home_com) && $home_com == 0) {
            $this->session->set_flashdata('error_message', 'Home Commission is required');
                    redirect('doctor/doctors/add_commission/'.encrypt($doctor_id));
        }
        elseif (!empty($clinic_com) && $clinic_com == 0) {
            $this->session->set_flashdata('error_message', 'Clinic Commission is required');
                    redirect('doctor/doctors/add_commission/'.encrypt($doctor_id));
        }
        else
        {
            $update = array('online_commission'=>$online_com,'clinic_commission'=>$clinic_com,'home_commission'=>$home_com);
            $updated_id = $this->doctors_model->savefees($update,$doctor_id);
            if($updated_id > 0)
            {
                 $this->session->set_flashdata('success_message', 'Admin commission added successfully');
                    redirect('doctor/doctors');
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Commission not added please try again later');
                    redirect('doctor/doctors/add_commission/'.encrypt($doctor_id));
            }
        }
    }

    public function clinic()
    {
        $doctor_id = decrypt($this->uri->segment(4));
        $data['title'] = 'Doctors Clinic';
        $data['page'] =  'clinic_list';
        $data['active_url'] =  'doctor/clinic';
        $data['datatable'] = true;
        $data['doctor_id'] = $doctor_id;
        $data['data'] = $this->doctors_model->get_doctor_clinic(array('doctor_id'=>$doctor_id));
        $this->load->view('template',$data);
    }

    public function create_clinic()
    {
        $doctor_id = decrypt($this->uri->segment(4));
        $data['title'] = 'Doctors Clinic';
        $data['page'] =  'create_clinics';
        $data['active_url'] =  'doctor/clinic/create_clinic/'.encrypt($doctor_id);
        $data['datatable'] = true;
         $data['doctor_id'] = $doctor_id;
        $this->load->view('template',$data);
    }

    public function getspeciality()
    {
         $service = $this->input->post('service');

         $cat_id = isset($service)&& !empty($service) ? $service : '';
        $productsubCatg = $this->doctors_model->getspecialities(array('category_id'=>$cat_id,'is_active'=>1));
      
        foreach($productsubCatg as $key =>$val){
            echo "<option value='".$val->id."'>".$val->name."</option>";
        }
    }

    public function userEmail_exist() {

        /*
         * email exist check based on user type like employee,doctor,patient
         * */
        $param = array('email'=>(string) AesCipher::encrypt($this->input->post('email')));
        $exist = $this->doctors_model->user_email_exist($param);
        if($exist) {
            echo "false";
        }
        else {
            echo "true";
        }

    }
    public function userPhone_exist() {

        $param = array('mobile_no'=>(string) AesCipher::encrypt($this->input->post('phone_no')));
        $exist = $this->doctors_model->user_email_exist($param);
        if($exist) {
            echo "false";
        }
        else {
            echo "true";
        }

    }

    public function rejectDoctor() {

        $requiredData['doctor_id']= $this->security->xss_clean($this->input->post('doctor_id'));
        $requiredData['reject_reason']= $this->security->xss_clean($this->input->post('reject_reason'));
        foreach ($requiredData as $key => $val) {
              if (trim($val) == '') {
                  $message = 'Please Specify ' . ucwords(str_replace("_", " ", $key));
                  $this->session->set_flashdata('error_message', $message);
                  redirect('doctor/doctors');
                  exit();
              }
          }

        $err = 0;
        $errType = 'success_message';
        
            $updateData = array();
            $updateData['admin_approve'] = 2;
            $updateData['reject_reason'] = $requiredData['reject_reason'];
            $update = $this->doctors_model->updateuser($updateData,$requiredData['doctor_id']);
            if($update)
            {
                $err = 0;
                $message = 'Account rejected';
                $errType = 'success_message';
                $this->sendNotification($requiredData['doctor_id'],$message,'Your Account has been rejected by Admin');
            }
            else
            {
                $err = 1;
                $message = 'error in reject doctor account';
                $errType = 'error_message';
            }

        $this->session->set_flashdata($errType, $message);
        redirect('doctor/doctors');
        
    }

    public function sendNotification($doctor_id,$title,$description)
    {
        $user = $this->doctors_model->getuserdetails(array('user_id'=>$doctor_id));

        if(!empty($user))
        {
            $insert_notification = array('doctor_id'=>$doctor_id,'title'=>$title,'description'=>$description,'create_by'=>$this->session->userdata('user_id'),'create_date'=>date('Y-m-d h:i:s'),'status'=>'active','is_view'=>0,'url'=>base_url('my-account'));
                $data = array('doctor_id'=>$doctor_id);
                $inserted_id = $this->doctors_model->addnotifications($insert_notification);
                $user_fcm = $user[0]->fcm_token;
            if($user[0]->device_type == 'android')
            {                    
                $tok = androidnotification($user_fcm,$title,$description,"account_reject",$data);
            }
            elseif($user[0]->device_type == 'ios')
            {
                $tok = iosNotification($user_fcm,$title,$description,"account_reject",$data);
            }
            else
            {
                $tok = sendwebPushNotification($user_fcm, $title, $description, $id = null,$icon = null);
            }
        }
    }



    public function deleteDoctor(){
        $user_id=$_POST['user_id'];
        // prx($user_id);
        $delete=$this->doctors_model->delete_doctor($user_id);
        if($delete)
        {
           $output['status']=true;
           $output['message']="Deleted Successfully";
        }
        else
        {
           $output['status']=false;
           $output['message']="Something went wrong";
        }
        echo json_encode($output);
    }

}
