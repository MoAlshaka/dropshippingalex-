@extends('layouts.master')

@section('title')
    {{ __('site.EditAdmin') }}
@endsection
@section('css')
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/materialdesignicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/excel/ejexcelMaster.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>



    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
@endsection
@section('content')
    <!-- Bootstrap Validation -->
    <div class="col-md">
        <div class="card">
            <h5 class="card-header">{{ __('site.EditAdmin') }}</h5>
            <div class="card-body">
                <form action="{{ route('admins.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-name"> {{ __('site.Name') }} <span
                                class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" placeholder="{{ __('site.Name') }}"
                            value="{{ $user->name ?? '' }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-email">{{ __('site.Username') }} <span
                                class="text-danger">*</span></label>
                        <input name="username" type="text" class="form-control" placeholder="{{ __('site.UserName') }}"
                            value="{{ $user->username ?? '' }}">
                        @if ($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>


                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="bs-validation-password">{{ __('site.Password') }} <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input name="password" id="bs-validation-password" type="password" class="form-control"
                                placeholder="{{ __('site.Password') }}"
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
                        <label class="form-label" for="bs-validation-role">{{ __('site.Role') }} <span
                                class="text-danger">*</span></label>
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
                            <button type="submit" class="btn btn-primary">{{ __('site.Update') }}</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Bootstrap Validation -->
@endsection
@section('js')
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>
    <script src="{{ asset('assets/addProduct/affiliateProduct.js') }}"></script>
    {{--    <script src="{{ asset('assets/productjs/stock.js') }}"></script> --}}

    {{--    <script src="{{asset('assets/js/forms-extras.js')}}"></script> --}}
@endsection
