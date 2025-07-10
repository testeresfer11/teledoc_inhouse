@extends('admin.layouts.app')
@section('title', 'Add Patient')

@section('content')
<div class="container">
    <h2 class="mb-4">Add Patient</h2>
    <form action="{{ route('admin.patient.add') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Basic Info -->
        <div class="row">
            <div class="col-md-6">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-6">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-6 mt-3">
                <label>Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" required>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-6 mt-3">
                <label>Mobile No</label>
                <input type="text" name="mobile_no" class="form-control" value="{{ old('mobile_no') }}">
            </div>
            @error('mobile_no')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-6 mt-3">
                <label>Country Code</label>
                <input type="text" name="country_code" class="form-control" value="{{ old('country_code') }}">
            </div>
            @error('country_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-6 mt-3">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Male</option>
                    <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>Female</option>
                    <option value="3" {{ old('gender') == 3 ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            @error('gender')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-6 mt-3">
                <label>Birth Date</label>
                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
            </div>
            @error('birth_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-6 mt-3">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-6 mt-3">
                <label>ID Proof</label>
                <input type="file" name="id_proof" class="form-control">
            </div>
            @error('id_proof')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-12 mt-3">
                <label>Present Address</label>
                <textarea name="present_address" class="form-control">{{ old('present_address') }}</textarea>
            </div>

            @error('present_address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-12 mt-3">
                <label>Permanent Address</label>
                <textarea name="permanent_address" class="form-control">{{ old('permanent_address') }}</textarea>
            </div>
            @error('permanent_address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <!-- Submit -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Add Patient</button>
        </div>
    </form>
</div>
@endsection