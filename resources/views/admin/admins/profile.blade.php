@extends('layouts.master')
@section('content')
    <!-- Bootstrap Validation -->
    <div class="col-md">
        <div class="card">
            <h5 class="card-header">Edit Profile</h5>
            <div class="card-body">
                <form action="{{ route('users.updateProfile', $users->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-name">Name <span class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" placeholder="Your name" value="{{ $users->name ?? '' }}">
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-email">Email <span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" placeholder="Enter Your email" value="{{ $users->email ?? '' }}">
                        @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-username">Username <span class="text-danger">*</span></label>
                        <input name="username" type="text" class="form-control" value="{{ $users->username ?? '' }}" disabled>
                        @if($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="bs-validation-password">Password <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input name="password" id="bs-validation-password" type="password" class="form-control" placeholder="Enter password"
                                   @if(!$errors->has('password')) value="{{ old('password') }}" @endif>
                            @if($errors->has('password'))
                                <span  class="text-danger">{{$errors->first('password')}}</span>
                            @endif
                            <span class="input-group-text cursor-pointer" id="basic-default-password4">
            <i class="ti ti-eye-off"></i>
        </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-phone">Phone <span class="text-danger">*</span></label>
                        <input name="phone" type="text" class="form-control" placeholder="Enter Your phone" value="{{ $users->phone ?? '' }}">
                        @if($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-title">Title <span class="text-danger">*</span></label>
                        <input name="title" type="text" class="form-control" value="{{ $users->title ?? '' }}" disabled>
                        @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-address">Address <span class="text-danger">*</span></label>
                        <input name="address" type="text" class="form-control" placeholder="Enter Your address" value="{{ $users->address ?? '' }}">
                        @if($errors->has('address'))
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-commission">Commission </label>
                        <input name="commission" type="text" class="form-control" value="{{ $users->commission ?? '' }}" disabled>
                        @if($errors->has('commission'))
                            <span class="text-danger">{{ $errors->first('commission') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-salary">Salary </label>
                        <input name="salary" type="text" class="form-control" value="{{ $users->salary ?? '' }}" disabled>
                        @if($errors->has('salary'))
                            <span class="text-danger">{{ $errors->first('salary') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-created_at">Start Date </label>
                        <input name="created_at" type="text" class="form-control" value="{{ $users->created_at->format('Y-m-d') ?? '' }}" disabled>
                        @if($errors->has('created_at'))
                            <span class="text-danger">{{ $errors->first('created_at') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-upload-file">Profile pic</label>
                        <input type="file" name="image" class="form-control" id="bs-validation-upload-file">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Bootstrap Validation -->

@endsection
