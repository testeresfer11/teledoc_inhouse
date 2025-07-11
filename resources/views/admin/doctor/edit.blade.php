@extends('admin.layouts.app')
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.6.1/build/css/intlTelInput.css">
@endsection
@section('title', 'Edit Doctor')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title"> Doctors</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item " aria-current="page">User Management</li>
        <li class="breadcrumb-item"><a href="{{route('admin.doctor.list')}}">Doctors</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Doctor</li>
      </ol>
    </nav>
</div>
@endsection
@section('content')
<div>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Edit Doctor</h4>
             
            <form class="forms-sample" action="{{route('admin.doctor.edit',['id' => $user->id])}}" method="POST" enctype="multipart/form-data">
              @csrf
              <h5 class="mt-3 mb-3">Doctor Details</h5>
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputFirstName">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputFirstName" placeholder="Full Name" name="name" value="{{$user->name ?? ''}}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Email" name="email" value="{{$user->email ?? ''}}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-6 select_country_code">
                        <label for="exampleInputPhone">Phone Number</label>
                        <input type="tel" class="form-control @error('mobile_no') is-invalid @enderror" id="phone" placeholder="Phone Number" name="mobile_no" value="{{$user->mobile_no ?? ''}}">
                        <input type="hidden" name="country_code" value="">
                        <!--<input type="hidden" name="country_short_code" value="ghs">-->
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputGender">Gender</label>
                        <select name="gender" id="exampleInputGender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            <option value="1" {{ $user->doctorDetail->gender == '1' ? 'selected' : '' }}>Male</option>
                            <option value="2" {{ $user->doctorDetail->gender == '2' ? 'selected' : '' }}>Female</option>
                            <option value="3" {{ $user->doctorDetail->gender == '3' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputGender">Category</label>
                        <select name="" id="exampleInputGender" class="form-control  @error('gender') is-invalid @enderror" >
                            <option value="">Select Category</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputGender">Speciality</label>
                        <select name="" id="exampleInputGender" class="form-control  @error('gender') is-invalid @enderror" >
                            <option value="">Select Speciality</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                
                </div> 
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="birth_date">Date Of Birth</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"  name ="birth_date" max="{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}" value="{{ old('birth_date', isset($user->doctorDetail->birth_date) ? \Carbon\Carbon::parse($user->doctorDetail->birth_date)->format('Y-m-d') : '') }}">
                        @error('birth_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="address">Residential Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Residential Address" name = "address" value="{{$user->doctorDetail->present_address ?? ''}}">
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> 
              </div>

              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="address">Correspondence Address</label>
                        <textarea class="form-control @error('alt_address') is-invalid @enderror" id="alt_address" placeholder="Correspondence Address" name = "alt_address" rows="3" cols="3">{{$user->doctorDetail->permanent_address ?? ''}}</textarea>
                        @error('alt_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputCountry">Country</label>
                        <input type="text" class="form-control @error('country') is-invalid @enderror" id="exampleInputCountry" placeholder="Country" name="country" value="{{$user->country ?? ''}}">
                        @error('country')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="education-qualification">Education</label>
                        <textarea class="form-control @error('education_qualification') is-invalid @enderror" id="education_qualification" placeholder="Education" name = "education_qualification" cols="3" rows="3">{{ $user->doctorDetail->education_qualification ?? ''}}</textarea>
                        @error('education_qualification')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputworkplace">Current Workplace</label>
                        <textarea class="form-control @error('current_workplace') is-invalid @enderror" id="exampleInputworkplace" placeholder="Current Workplace" name="current_workplace" cols="3" rows="3">{{ $user->doctorDetail->current_wokplace ?? '' }}</textarea>
                        @error('current_workplace')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="about">About Dr.</label>
                        <textarea class="form-control @error('about') is-invalid @enderror" id="about" placeholder="About Dr." name = "about" cols="3" rows="3">{{ $user->doctorDetail->about ?? '' }}</textarea>
                        @error('about')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputMedical">Medical Certificate Number</label>
                        <input type="text" class="form-control @error('medical_certificate') is-invalid @enderror" id="exampleInputMedical" placeholder="Medical Certificate Number" name="medical_certificate" value="{{ $user->doctorDetail->medical_certificate ?? '' }}">
                        @error('medical_certificate')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="clinicInterest">Clinic Interest</label>
                        <textarea class="form-control @error('clinic_interest') is-invalid @enderror" id="clinic_interest" placeholder="Clinic Interest" name = "clinic_interest" cols="3" rows="3">{{ $user->doctorDetail->clinic_interest ?? '' }}</textarea>
                        @error('clinic_interest')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputAppointment">Appointment Description</label>
                        <textarea class="form-control @error('appointment_description') is-invalid @enderror" id="exampleInputAppointment" placeholder="Appointment Description" name="appointment_description" cols="3" rows="3">{{ $user->doctorDetail->appointment_description ?? '' }}</textarea>
                        @error('appointment_description')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label>Profile Photo</label>
                          <input type="file" name="profile_pic" class="form-control file-upload-info" placeholder="Upload Image" accept="image/*">
                    </div>
                    <div class="col-6">
                        <label for="timezone">Timezone</label>
                        <select name="timezone" id="exampleInputtimezone" class="form-control  @error('timezone') is-invalid @enderror" >
                            <option value="">Select Timezone</option>
                            <option value="Africa/Accra">Africa/Accra</option>
                            <option value="Asia/Kolkata">Asia/Kolkata</option>
                        </select>
                        @error('timezone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
              </div>

              <h5 class="mt-3 mb-3">Doctor Documents</h5>
              <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label>ID/Passport Picture</label>
                          <input type="file" name="ic_pic" class="form-control file-upload-info" placeholder="Upload Image" accept="image/*">
                    </div>
                    <div class="col-4">
                        <label>Education Certificate of Speciality</label>
                          <input type="file" name="education" class="form-control file-upload-info" placeholder="Upload Image" accept="image/*">
                    </div>
                    <div class="col-4">
                        <label>Medical License</label>
                          <input type="file" name="medical_license" class="form-control file-upload-info" placeholder="Upload Image" accept="image/*">
                    </div>
                </div>
              </div>

              <h5 class="mt-3 mb-3">Bank Account Details</h5>
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label>Bank Name</label>
                          <input type="text" name="" class="form-control" placeholder="Enter Bank Name" >
                    </div>
                    <div class="col-6">
                        <label>Account Name</label>
                          <input type="text" name="" class="form-control" placeholder="Enter Account Name" >
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label>Account Number</label>
                          <input type="text" name="" class="form-control" placeholder="Enter Account Number" >
                    </div>
                    <div class="col-6">
                        <label>IFSC Code</label>
                          <input type="text" name="" class="form-control" placeholder="Enter IFSC code" >
                    </div>
                </div>
              </div>

              <h5 class="mt-3 mb-3">Select Services:</h5>
              <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <input type="checkbox" name="is_chat" id="is_chat" {{ old('is_chat', $user->doctorDetail->is_chat ?? false) ? 'checked' : '' }}><label class="service-label" for="chat">Chat Service</label>
                    </div>
                    <div class="col-2">
                        <input type="checkbox" name="is_video" id="is_video" {{ old('is_video', $user->doctorDetail->is_video ?? false) ? 'checked' : '' }}><label class="service-label" for="video">Video Service</label>
                    </div>
                    <div class="col-2">
                        <input type="checkbox" name="is_clinic" id="is_clinic" {{ old('is_clinic', $user->doctorDetail->is_clinic ?? false) ? 'checked' : '' }}><label class="service-label" for="clinic">Clinic Service</label>
                    </div>
                </div>

                <h4 class="mt-3 mb-3">Fees Configuration</h4>
                <div id="chat_fees" class="fees">
                    <div class="form-group">
                        <div class="row">                    
                            <div class="col-6 chat-fees">
                                <h5 class="mt-3 mb-3">Chat</h5>
                                <label for="first-time">First Time</label>
                                <input type="number" name="chat_first_time" step="0.01" class="form-control" placeholder="GHS" value="{{ $user->doctorDetail->chat_first_time ?? '' }}"><br>
                                <label for="follow-up">Follow Up</label>
                                <input type="number" name="chat_follow_up" step="0.01" class="form-control" placeholder="GHS" value="{{ $user->doctorDetail->chat_follow_up ?? '' }}">
                            </div>
                            <div class="col-6 video-fees">
                                <h5 class="mt-3 mb-3">Video</h5>
                                <label for="first-time">First Time</label>
                                <input type="number" name="video_first_time" step="0.01" class="form-control" placeholder="GHS" value="{{ $user->doctorDetail->video_first_time ?? '' }}"><br>
                                <label for="follow-up">Follow Up</label>
                                <input type="number" name="video_follow_up" step="0.01" class="form-control" placeholder="GHS" value="{{ $user->doctorDetail->video_follow_up ?? '' }}">
                            </div>
                            <div class="col-6 clinic-fees">
                                <h5 class="mt-3 mb-3">Clinic</h5>
                                <label for="first-time">First Time</label>
                                <input type="number" name="clinic_fee" step="0.01" class="form-control" placeholder="GHS" value="{{ $user->doctorDetail->clinic_fee ?? '' }}"><br>
                                <label for="follow-up">Follow Up</label>
                                <input type="number" name="clinic_follow_up" step="0.01" class="form-control" placeholder="GHS" value="{{ $user->doctorDetail->clinic_follow_up ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
              </div>

              <button type="submit" class="btn btn-primary mr-2">Update</button>
              {{-- <button class="btn btn-dark">Cancel</button> --}}
            </form>
          </div>
        </div>
      </div>
    </div>
</div>    
@endsection
@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZ09dtOd8YHF_ZCbfbaaMHJKiOr26noY8&libraries=places" ></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.6.1/build/js/intlTelInput.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.querySelector("#phone");
        const iti = window.intlTelInput(input, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.6.1/build/js/utils.js",
            initialCountry: "IN",
            preferredCountries: ["in", "us"],
            formatOnDisplay: false,  
            nationalMode: false,    
        });

        
        document.querySelector("#phone").addEventListener("change", function(event) {
            // Get the selected country data
            const countryData = iti.getSelectedCountryData();
            
            // Get the raw phone number
            let phoneNumber = iti.getNumber("e164");
            phoneNumber = phoneNumber.replace(/\D/g, '');
           
            // Set hidden fields with country code and short code
            document.querySelector("input[name='country_code']").value = countryData.dialCode;
            document.querySelector("input[name='country_short_code']").value = countryData.iso2;

            input.value = phoneNumber;
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
      const isChat = document.getElementById("is_chat");
      const isVideo = document.getElementById("is_video");
      const isClinic = document.getElementById("is_clinic");
  
      const chatFees = document.querySelectorAll(".chat-fees");
      const videoFees = document.querySelectorAll(".video-fees");
      const clinicFees = document.querySelectorAll(".clinic-fees");
  
      function toggleFees() {
        chatFees.forEach(el => el.style.display = isChat.checked ? "block" : "none");
        videoFees.forEach(el => el.style.display = isVideo.checked ? "block" : "none");
        clinicFees.forEach(el => el.style.display = isClinic.checked ? "block" : "none");
      }
  
      // Add listeners
      [isChat, isVideo, isClinic].forEach(checkbox => {
        checkbox.addEventListener("change", toggleFees);
      });
  
      // Initial state
      toggleFees();
    });
  </script>

<script>
  $(document).ready(function() {

    var err = false;
    var autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('address'), {
            types: ['geocode']
        }
    );
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        var postalCode = '';
        if (place.address_components) {
            for (var i = 0; i < place.address_components.length; i++) {
                var component = place.address_components[i];
                if (component.types.includes('postal_code')) {
                    postalCode = component.long_name;
                    break;
                }
            }
            $('#exampleInputPinCode').val(postalCode);
        }
    });

    $("#add-user").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            first_name: {
                required: true,
                noSpace: true,
                minlength: 3,
                maxlength:25,
            },
            last_name: {
                required: true,
                noSpace: true,
                minlength: 3,
                maxlength:25
            },
            email: {
                required: true,
                email: true,
                noSpace: true,
            },
            phone_number: {
                number: true,
                // minlength:10,
                maxlength: 12,
            },
            gender: {
                required: true,
            },
            password: {
                minlength: 6,
            },
        },
        messages: {
            first_name: {
                required: "First name is required",
                minlength: "First name must consist of at least 3 characters",
                maxlength: "First name must not contains more then 25 characters."
            },
            last_name: {
                required: "Last name is required",
                minlength: "Last name must consist of at least 3 characters",
                maxlength: "Last name must not contains more then 25 characters."
            },
            email: {
                required: 'Email is required.',
                email: "Please enter a valid email address"
            },
            phone_number: {
                number: 'Only numeric value is acceptable',
                minlength:  'Phone number must be 10 digits',
                maxlength:  'Phone number must be 10 digits'
            },
            gender: {
                required: 'Please select gender.',
            },
            password: {
                minlength: "Password must consist of at least 6 characters"
            },
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
  });
  </script>
@stop