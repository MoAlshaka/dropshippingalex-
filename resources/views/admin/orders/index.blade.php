@extends('layouts.master')


@section('title')
    {{ __('site.Orders') }}
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
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
        <h4 class="py-3 mb-4 d-flex justify-content-between">
            <div>
                <span class="text-muted fw-light"> {{ __('site.Dashboard') }} /</span>
                {{ __('site.Orders') }}
            </div>
            <div>
                <button class="btn btn-outline-primary waves-effect waves-light" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <span class="tf-icons mdi mdi-filter-check-outline me-1"></span>
                    {{ __('site.Filter') }}
                </button>
                {{--                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas</button> --}}
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                    aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ __('site.FliterOrders') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form action="{{ route('admin.orders.filter') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <div class="mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="bs-rangepicker-range" class="form-control"
                                            name="created_at">
                                        <label for="bs-rangepicker-range">{{ __('site.CreatedAt') }}</label>
                                    </div>
                                </div>
                                <div class=" mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select name="warehouse[]" id="warehouse" class="selectpicker w-100"
                                            data-style="btn-default" multiple data-actions-box="true">
                                            @isset($countries)
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <label for="warehouse">{{ __('site.Warehouse') }}</label>
                                    </div>
                                </div>
                                <div class=" mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select name="country[]" id="country" class="selectpicker w-100"
                                            data-style="btn-default" multiple data-actions-box="true">
                                            @isset($countries)
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <label for="country">{{ __('site.Country') }}</label>
                                    </div>
                                </div>

                                <div class=" mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select name="type[]" id="type" class="selectpicker w-100"
                                            data-style="btn-default" multiple data-actions-box="true">
                                            @isset($types)
                                                @foreach ($types as $info)
                                                    <option value="{{ $info }}">{{ $info }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <label for="type">{{ __('site.Type') }}</label>
                                    </div>
                                </div>
                                <div class=" mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select name="shipment_status[]" id="shipment_status" class="selectpicker w-100"
                                            data-style="btn-default" multiple data-actions-box="true">
                                            @isset($shipment_status)
                                                @foreach ($shipment_status as $info)
                                                    <option value="{{ $info }}">{{ $info }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <label for="type">{{ __('site.ShipmentStatus') }}</label>
                                    </div>
                                </div>
                                <div class=" mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select name="payment_status[]" id="payment_status" class="selectpicker w-100"
                                            data-style="btn-default" multiple data-actions-box="true">
                                            @isset($payment_status)
                                                @foreach ($payment_status as $info)
                                                    <option value="{{ $info }}">{{ $info }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <label for="type">{{ __('site.PaymentStatus') }}</label>
                                    </div>
                                </div>


                            </div>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light">{{ __('site.Filter') }}</button>
                            <button type="reset"
                                class="btn btn-outline-danger waves-effect">{{ __('site.Reset') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </h4>
        @if (session()->has('Add'))
            <div class="alert alert-success" role="alert">{{ session()->get('Add') }}</div>
        @endif
        @if (session()->has('Update'))
            <div class="alert alert-primary" role="alert">{{ session()->get('Update') }}</div>
        @endif
        @if (session()->has('Delete'))
            <div class="alert alert-danger" role="alert">{{ session()->get('Delete') }}</div>
        @endif
        @if (session()->has('Warning'))
            <div class="alert alert-warning" role="alert">{{ session()->get('Warning') }}</div>
        @endif
        <div class="card p-4">
            <div class="row">
                <h5 class="card-header col-7"> {{ __('site.Orders') }}</h5>
                <div class="col-5">
                    <form action="{{ route('admin.orders.search') }}" method="post">
                        @csrf
                        <div class="form-floating form-floating-outline  d-flex ms-4 mb-4">
                            <input type="text" id="ref" name="ref" class="form-control"
                                placeholder="{{ __('site.REF') }}" />
                            <label for="ref"> {{ __('site.REF') }}</label>
                            <button type="submit" class="btn btn-primary btn-next btn-submit ms-2">
                                {{ __('site.Search') }}</button>
                        </div>
                        @error('ref')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                    </form>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>{{ __('site.REF') }}</th>
                            <th>{{ __('site.CreatedAt') }}</th>
                            <th>{{ __('site.Customer') }}</th>
                            <th>{{ __('site.Total') }}</th>
                            <th>{{ __('site.Warehouse') }}</th>
                            {{--                        <th>{{ __('site.ShippingDetails') }}</th> --}}
                            <th>{{ __('site.Type') }}</th>
                            <th>{{ __('site.ShipmentStatus') }}</th>
                            <th>{{ __('site.PaymentStatus') }}</th>
                            <th>{{ __('site.PaymentType') }}</th>
                            <th>{{ __('site.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if (isset($orders))
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($orders as $order)
                                <tr>
                                    <th scope="row">{{ $i++ }}</th>
                                    <td>{{ $order->lead->store_reference }}</td>
                                    <td>{{ $order->lead->order_date }}</td>
                                    <td>{{ $order->lead->customer_name }}</td>
                                    <td>{{ $order->lead->total }}</td>
                                    <td>{{ $order->lead->warehouse }}</td>
                                    {{--                                <td> @foreach ($order->shippingdetails as $shippingdetail) --}}
                                    {{--                                    {{ $shippingdetail->details }} --}}
                                    {{--                                    @endforeach</td> --}}
                                    <td> {{ $order->lead->type }}</td>
                                    <td>{{ $order->shipment_status }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td> {{ $order->payment_type }}</td>

                                    <td style="display: flex;
                                        gap: 6px;">
                                        @can('Show Orders')
                                            <a class="  text-primary hover:bg-success hover:text-white"
                                                href="{{ route('orders.show', $order->id) }}">
                                                <button type="button" class="btn btn-icon btn-info waves-effect waves-light">
                                                    <span class="tf-icons mdi mdi-information-outline"></span>

                                                </button>
                                            </a>
                                        @endcan
                                        @can('Edit Order')
                                            <a class="  text-primary hover:bg-success hover:text-white"
                                                href="{{ route('orders.edit', $order->id) }}">
                                                <button type="button"
                                                    class="btn btn-icon btn-primary waves-effect waves-light">
                                                    <span class="tf-icons mdi mdi-tag-edit-outline"></span>

                                                </button>
                                            </a>
                                        @endcan
                                        @can('Delete Orders')
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="btn btn-icon btn-danger waves-effect waves-light">
                                                    <span class="tf-icons mdi mdi-trash-can-outline"></span>

                                                </button>
                                            </form>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">No data
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection



@section('js')
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-pickers.js') }}"></script>
@endsection
