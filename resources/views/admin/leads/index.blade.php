@extends('layouts.master')


@section('title')
    {{ __('site.Leads') }}
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
                {{ __('site.Leads') }}
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
                        <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ __('site.FilterLeads') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form action="{{ route('admin.leads.filter') }}" method="post">
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
                                        <select name="status[]" id="status" class="selectpicker w-100"
                                            data-style="btn-default" multiple data-actions-box="true">
                                            @isset($status)
                                                @foreach ($status as $info)
                                                    <option value="{{ $info }}">{{ $info }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <label for="status">{{ __('site.Status') }}</label>
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
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                {{ __('site.Filter') }}</button>
                            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-danger waves-effect">
                                {{ __('site.Back') }}</a>
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
                <h5 class="card-header col-5"> {{ __('site.Leads') }}</h5>

                <form action="{{ route('admin.leads.search') }}" method="post" class="col-7">
                    @csrf

                    <div class="form-floating form-floating-outline d-flex">
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
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table table-bordered">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>{{ __('site.REF') }}</th>
                            <th>{{ __('site.CreatedAt') }}</th>
                            <th>{{ __('site.Customer') }}</th>
                            <th>{{ __('site.Phone') }}</th>
                            <th>{{ __('site.SKU') }}</th>
                            <th>{{ __('site.Total') }}</th>
                            <th>{{ __('site.Type') }}</th>
                            <th>{{ __('site.Status') }}</th>
                            <th>{{ __('site.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if (isset($leads))
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($leads as $lead)
                                <tr>
                                    <th scope="row">{{ $i++ }}</th>
                                    <td>{{ $lead->store_reference }}</td>
                                    <td>{{ $lead->order_date }}</td>
                                    <td>{{ $lead->customer_name }}</td>
                                    <td>{{ $lead->customer_phone }}</td>
                                    <td>{{ $lead->item_sku }}</td>
                                    <td>{{ $lead->total }}</td>
                                    <td> {{ $lead->type }}
                                        @if ($lead->type == 'commission')
                                            @if ($lead->affiliateproduct->type == 'delivered')
                                                {{ __('site.PerDelivered') }}
                                            @else
                                                {{ __('site.PerConfirmed') }}
                                            @endif
                                        @endif
                                    </td>
                                    <td> {{ $lead->status }}</td>
                                    <td style="display: flex;
                                        gap: 6px;">
                                        @can('Show Lead')
                                            <a class="  text-primary hover:bg-success hover:text-white"
                                                href="{{ route('admin.lead.show', $lead->id) }}">
                                                <button type="button" class="btn btn-icon btn-info waves-effect waves-light">
                                                    <span class="tf-icons mdi mdi-eye-outline"></span>

                                                </button>
                                            </a>
                                        @endcan
                                        @can('Edit Lead')
                                            <a class="  text-primary hover:bg-success hover:text-white"
                                                href="{{ route('admin.leads.edit', $lead->id) }}">
                                                <button type="button"
                                                    class="btn btn-icon btn-primary waves-effect waves-light">
                                                    <span class="tf-icons mdi mdi-tools"></span>

                                                </button>
                                            </a>
                                        @endcan
                                        @can('Delete Lead')
                                            <form action="{{ route('admin.leads.delete', $lead->id) }}" method="post">
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
                                <td colspan="11" class="px-4 py-4 text-center ">{{ __('site.NoData') }}</td>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $leads->links() }}
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
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
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

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

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

    <script src="{{ asset('assets/js/forms-pickers.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
@endsection
