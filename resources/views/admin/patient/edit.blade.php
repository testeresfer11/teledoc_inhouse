@extends('admin.layouts.app')
@section('title', 'Edit Patient')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Patient</h2>
    <form action="{{ route('admin.patient.edit', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
            </div>
            @error('name') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror

            <div class="col-md-6">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
            </div>
            @error('email') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror

            <div class="col-md-6 mt-3">
                <label>Mobile No</label>
                <input type="text" name="mobile_no" class="form-control" value="{{ old('mobile_no', $user->mobile_no) }}">
            </div>
            @error('mobile_no') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror

            <div class="col-md-6 mt-3">
                <label>Country Code</label>
                <input type="text" name="country_code" class="form-control" value="{{ old('country_code', $user->country_code) }}">
            </div>
            @error('country_code') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror

            <div class="col-md-6 mt-3">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <option value="1" {{ old('gender', $user->patientDetail->gender ?? '') == 1 ? 'selected' : '' }}>Male</option>
                    <option value="2" {{ old('gender', $user->patientDetail->gender ?? '') == 2 ? 'selected' : '' }}>Female</option>
                    <option value="3" {{ old('gender', $user->patientDetail->gender ?? '') == 3 ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            @error('gender') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror

            <div class="col-md-6 mt-3">
                <label>Birth Date</label>
                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $user->patientDetail->birth_date ?? '') }}">
            </div>
            @error('birth_date') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror

            <div class="col-md-6 mt-3">
                <label>Profile Image</label>
                <input type="file" name="profile_pic" class="form-control">
                @if (!empty($user->patientDetail->image))
                    <small>Current: <a href="{{ asset($user->patientDetail->image) }}" target="_blank">View</a></small>
                @endif
            </div>
            @error('profile_pic') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror

            <div class="col-md-6 mt-3">
                <label>ID Proof</label>
                <input type="file" name="id_proof" class="form-control">
                @if (!empty($user->patientDetail->id_proof))
                    <small>Current: <a href="{{ asset($user->patientDetail->id_proof) }}" target="_blank">View</a></small>
                @endif
            </div>
            @error('id_proof') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror

            <div class="col-md-12 mt-3">
                <label>Present Address</label>
                <input type="text" id="present_address" name="present_address" class="form-control" value="{{ old('present_address', $user->patientDetail->present_address ?? '') }}">
            </div>
            <input type="hidden" name="pat_lat" id="pat_lat" value="{{ old('pat_lat', $user->patientDetail->pat_lat ?? '') }}">
            <input type="hidden" name="pat_long" id="pat_long" value="{{ old('pat_long', $user->patientDetail->pat_long ?? '') }}">
            @error('present_address') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror

            <div class="col-md-12 mt-3">
                <label>Permanent Address</label>
                <input type="text" id="permanent_address" name="permanent_address" class="form-control" value="{{ old('permanent_address', $user->patientDetail->permanent_address ?? '') }}">
            </div>
            @error('permanent_address') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update Patient</button>
        </div>
    </form>
</div>
@endsection
