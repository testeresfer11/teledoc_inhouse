@extends('admin.layouts.app')
@section('title', 'View Patient')
@section('breadcrum')
    <div class="page-header">
        <h3 class="page-title">Patients</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.patient.list') }}">Patients</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Patient</li>
            </ol>
        </nav>
    </div>
@endsection
@section('content')
    <div>
        <h4 class="user-title">View User</h4>
        <div class="card">
            <div class="card-body">
                <form class="forms-sample">
                    <div class="form-group">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3">
                                <div class="view-user-details">
                                    <div class="text-center">
                                    <img class="user-image"
                              @if ($user->patientDetail->image != null) 
                                  src="{{ asset($user->patientDetail->image) }}"
                              @else
                                  src="{{ asset('images/user_dummy.png') }}" 
                              @endif
                              alt="User profile picture">

                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                <div class="response-data ml-4">
                                    <h6 class="f-14 mb-1">
                                        <span class="semi-bold qury">Name :</span> 
                                        <span class="text-muted">{{ $user->name ?? 'N/A' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                        <span class="semi-bold qury">Email :</span> 
                                        <span class="text-muted">{{ $user->email ?? 'N/A' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                        <span class="semi-bold qury">Gender :</span> 
                                        <span class="text-muted">
                                            @php
                                                $genderMap = [1 => 'Male', 2 => 'Female', 3 => 'Other'];
                                            @endphp
                                            {{ $genderMap[$user->patientDetail->gender ?? 0] ?? 'N/A' }}
                                        </span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                        <span class="semi-bold qury">Date Of Birth:</span> 
                                        <span class="text-muted">{{ $user->patientDetail->birth_date ?? 'N/A' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                        <span class="semi-bold qury">Phone Number :</span> 
                                        <span class="text-muted">
                                            {{ $user->country_code ? '+'.$user->country_code.' ' : '' }}{{ $user->mobile_no ?? 'N/A' }}
                                        </span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                        <span class="semi-bold qury">Present Address :</span> 
                                        <span class="text-muted">{{ $user->patientDetail->present_address ?? 'N/A' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                        <span class="semi-bold qury">Permanent Address :</span> 
                                        <span class="text-muted">{{ $user->patientDetail->permanent_address ?? 'N/A' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                        <span class="semi-bold qury">Lat / Long :</span> 
                                        <span class="text-muted">
                                            {{ $user->patientDetail->pat_lat ?? 'N/A' }} / {{ $user->patientDetail->pat_long ?? 'N/A' }}
                                        </span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                        <span class="semi-bold qury">ID Proof :</span> 
                                        <span class="text-muted">
                                            @if (!empty($user->patientDetail->id_proof))
                                                <a href="{{ asset($user->patientDetail->id_proof) }}" target="_blank">View</a>
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                        <span class="semi-bold qury">Date &amp; time :</span> 
                                        <span class="text-muted" id="userDateTime">{{ convertDate($user->created_at) }}</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
