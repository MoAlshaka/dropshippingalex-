@extends('layouts.master')
@section('content')
    <!-- Bootstrap Validation -->
    <div class="col-md">
        <div class="card">
            <h5 class="card-header">Edit Admin</h5>
            <div class="card-body">
                <form action="{{ route('admins.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-name">Name <span class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" placeholder="User name"
                            value="{{ $user->name ?? '' }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-email">Email <span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" placeholder="Enter user email"
                            value="{{ $user->email ?? '' }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-email">Username <span
                                class="text-danger">*</span></label>
                        <input name="username" type="text" class="form-control" placeholder="Enter username"
                            value="{{ $user->username ?? '' }}">
                        @if ($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-team">Status<span class="text-danger">*</span></label>
                        <select name="status" class="select2 form-control" id="select2_status">
                            <option value="" disabled>Select Status</option>
                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>



                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="bs-validation-password">Password <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input name="password" id="bs-validation-password" type="password" class="form-control"
                                placeholder="Enter password"
                                @if (!$errors->has('password')) value="{{ old('password') }}" @endif>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                            <span class="input-group-text cursor-pointer" id="basic-default-password4">
                                <i class="ti ti-eye-off"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-role">Role<span class="text-danger">*</span></label>
                        <select name="roles_name" class="select2 form-control" id="select2_role">
                            <option value="" selected disabled></option>
                            @foreach ($roles as $role)
                                @if ($role !== 'Owner')
                                    <option value="{{ $role }}"
                                        {{ in_array($role, $userRole) ? 'selected' : '' }}>{{ $role }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update User</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Bootstrap Validation -->
@endsection
