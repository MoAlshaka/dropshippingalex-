@extends('layouts.master')


@section('title')
    {{ __('site.EditleadStatus') }}
@endsection


@section('css')
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">{{ __('site.Dashboard') }} /</span>
            {{ __('site.EditleadStatus') }} </h4>
        <div class="row">
            <div class="card-body">

                <div class="col-12">
                    <div class="card mb-4">
                        <h5 class="card-header"> {{ __('site.Status') }}</h5>
                        <div class="card-body">
                            <div class="row">
                                <form class="flex flex-col gap-6" action="{{ route('admin.leads.update', $lead->id) }}"
                                    method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <select id="select2Basic" class="select2 form-select form-select-lg"
                                                data-allow-clear="true" name="status">


                                                <option value="pending" @if ($lead->status == 'pending') selected @endif>
                                                    {{ __('site.Pending') }}</option>
                                                <option value="confirmed" @if ($lead->status == 'confirmed') selected @endif>
                                                    {{ __('site.Confirmed') }}</option>
                                                <option value="in_process"
                                                    @if ($lead->status == 'in_process') selected @endif>
                                                    {{ __('site.InProcess') }}</option>
                                                <option value="no_reply" @if ($lead->status == 'no_reply') selected @endif>
                                                    {{ __('site.NoReply') }}</option>
                                                <option value="wrong" @if ($lead->status == 'wrong') selected @endif>
                                                    {{ __('site.Wrong') }}</option>
                                                <option value="call_later"
                                                    @if ($lead->status == 'call_later') selected @endif>
                                                    {{ __('site.CallLater') }}</option>
                                                <option value="scheduled" @if ($lead->status == 'scheduled') selected @endif>
                                                    {{ __('site.Scheduled') }}</option>
                                                <option value="canceled" @if ($lead->status == 'canceled') selected @endif>
                                                    {{ __('site.Canceled') }}</option>
                                                <option value="expired" @if ($lead->status == 'expired') selected @endif>
                                                    {{ __('site.Expired') }}</option>
                                                <option value="duplicate" @if ($lead->status == 'duplicate') selected @endif>
                                                    {{ __('site.Duplicate') }}</option>
                                                <option value="taken" @if ($lead->status == 'taken') selected @endif>
                                                    {{ __('site.Taken') }}</option>
                                                <option value="wait_for_stock"
                                                    @if ($lead->status == 'wait_for_stock') selected @endif>
                                                    {{ __('site.WaitForStock') }}</option>
                                                <option value="reassigned"
                                                    @if ($lead->status == 'reassigned') selected @endif>
                                                    {{ __('site.ReAssigned') }}</option>

                                            </select>
                                            <label for="select2Basic">{{ __('site.Status') }}</label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <input class="form-control" type="text" name="notes" id="notes"
                                                value="{{ old('notes', $lead->notes) }}">
                                            <label for="notes">{{ __('site.Notes') }}</label>
                                        </div>
                                    </div>


                                    <div>
                                        <button type="submit" class="btn btn-primary">{{ __('site.Update') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-tagify.js') }}"></script>
    <script src="{{ asset('assets/js/forms-typeahead.js') }}"></script>
@endsection
