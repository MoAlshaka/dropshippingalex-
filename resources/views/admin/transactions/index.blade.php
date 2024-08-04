@extends('layouts.master')


@section('title')
    {{ __('site.Transactions') }}
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
                {{ __('site.Transactions') }}
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
                        <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ __('site.Filter') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form action="{{ route('admin.transaction.filter') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <div class="mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="bs-rangepicker-range" class="form-control" name="date"
                                            value="">
                                        <label for="bs-rangepicker-range">{{ __('site.Date') }}</label>
                                    </div>
                                </div>

                                <div class=" mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select name="seller_id[]" id="seller_id" class="selectpicker w-100"
                                            data-style="btn-default" multiple data-actions-box="true">
                                            @isset($sellers)
                                                @foreach ($sellers as $seller)
                                                    <option value="{{ $seller->id }}">
                                                        {{ $seller->first_name . ' ' . $seller->last_name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <label for="seller_id">{{ __('site.Seller') }}</label>
                                    </div>
                                </div>

                                <div class=" mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select name="status[]" id="status" class="selectpicker w-100"
                                            data-style="btn-default" multiple data-actions-box="true">
                                            <option value="paid">{{ __('site.Paid') }}</option>
                                            <option value="unpaid">{{ __('site.Unpaid') }}</option>

                                        </select>
                                        <label for="type">{{ __('site.PaymentStatus') }}</label>
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                {{ __('site.Filter') }}</button>
                            <button type="reset" class="btn btn-outline-danger waves-effect">
                                {{ __('site.Reset') }}</button>
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

        <div class="card">
            <div class="d-flex">
                <h5 class="card-header col-10"> {{ __('site.Transactions') }}</h5>

                <a href="{{ route('transactions.create') }}"
                    class="btn rounded btn-success waves-effect waves-light col-2 mt-3">{{ __('site.Add') }}</a>

            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>{{ __('site.Seller') }}</th>
                            <th>{{ __('site.PaymentMethod') }}</th>
                            <th>{{ __('site.AccountNumber') }}</th>
                            <th>{{ __('site.Amount') }}</th>
                            <th>{{ __('site.Status') }}</th>
                            <th>{{ __('site.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if ($transactions->isEmpty())
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center ">
                                    {{ __('site.NoData') }}</td>
                            </tr>
                        @else
                            @php $i = 1; @endphp
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <th scope="row">{{ $i++ }}</th>
                                    <td>{{ $transaction->seller->first_name . ' ' . $transaction->seller->last_name }}</td>
                                    <td>{{ $transaction->seller->payment_method }}</td>
                                    <td>{{ $transaction->seller->account }}</td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->status }}</td>
                                    <td style="display: flex;
                                            gap: 6px;">

                                        @can('Edit Transaction')
                                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                class="btn bg-primary text-white ">
                                                {{ __('site.Edit') }}
                                            </a>
                                        @endcan
                                        @can('Delete Transaction')
                                            <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn bg-danger text-white">{{ __('site.Delete') }}</button>
                                            </form>
                                        @endcan


                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>




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
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/app-logistics-dashboard.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>


    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>

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

    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-pickers.js') }}"></script>
@endsection
