@extends('layouts.master')


@section('title')
    {{ __('site.EditOrderStatus') }}
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
            {{ __('site.EditOrderStatus') }} </h4>
        <div class="row">
            <div class="card-body">

                <div class="col-12">
                    <div class="card mb-4">
                        <h5 class="card-header"> {{ __('site.Details') }}</h5>
                        <div class="card-body">
                            <div class="row">
                                <form class="flex flex-col gap-6" action="{{ route('orders.update', $order->id) }}"
                                      method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <select id="shipment_status" class="select2 form-select form-select-lg"
                                                    data-allow-clear="true" name="shipment_status">

                                                <option value="{{ $order->shipment_status }}" selected>
                                                    {{ $order->shipment_status }}</option>
                                                <option value="pending">{{ __('site.Pending') }}</option>
                                                <option value="approved">{{ __('site.Approved') }}</option>
                                                <option value="shipping">{{ __('site.Shipping') }}</option>
                                                <option value="delivered">{{ __('site.Delivered') }}</option>

                                            </select>
                                            <label for="shipment_status">{{ __('site.ShipmentStatus') }}</label>


                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <select id="payment_type" class="select2 form-select form-select-lg"
                                                    data-allow-clear="true" name="payment_type">

                                                <option value="{{ $order->payment_type }}" selected>
                                                    {{ $order->payment_type }}</option>
                                                <option value="pending">{{ __('site.Pending') }}</option>
                                                <option value="approved">{{ __('site.Approved') }}</option>
                                                <option value="shipping">{{ __('site.Shipping') }}</option>
                                                <option value="delivered">{{ __('site.Delivered') }}</option>

                                            </select>
                                            <label for="payment_type">{{ __('site.PaymentType') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <select id="payment_status" class="select2 form-select form-select-lg"
                                                    data-allow-clear="true" name="payment_status">

                                                <option value="{{ $order->payment_status }}" selected>
                                                    {{ $order->payment_status }}</option>
                                                <option value="pending">{{ __('site.Pending') }}</option>
                                                <option value="approved">{{ __('site.Approved') }}</option>
                                                <option value="shipping">{{ __('site.Shipping') }}</option>
                                                <option value="delivered">{{ __('site.Delivered') }}</option>

                                            </select>
                                            <label for="payment_status">{{ __('site.PaymentStatus') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <select id="shipping_details" class="select2 form-select form-select-lg"
                                                    data-allow-clear="true" name="shipping_details">

                                                <option value="{{ $order->shipping_details }}" selected>
                                                    {{ $order->shipping_details }}</option>
                                                <option value="pending">{{ __('site.Pending') }}</option>
                                                <option value="approved">{{ __('site.Approved') }}</option>
                                                <option value="shipping">{{ __('site.Shipping') }}</option>
                                                <option value="delivered">{{ __('site.Delivered') }}</option>

                                            </select>
                                            <label for="shipping_details">{{ __('site.ShippingDetails') }}</label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="number" name="calls" id="calls">
                                                <label for="calls">{{ __('site.Calls') }}</label>
                                            </div>
                                        </div>
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
