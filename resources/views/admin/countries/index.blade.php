@extends('layouts.master')


@section('title')
    {{ __('site.Countries') }}
@endsection


@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">{{ __('site.Dashboard') }}/</span>{{ __('site.Countries') }}
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
            <div class="row">
                <h5 class="card-header col-10"> {{ __('site.Countries') }}</h5>
                <div class="col-2 mt-3">
                    <a href="{{ route('countries.create') }}"
                        class="btn rounded btn-success waves-effect waves-light">{{ __('site.Add') }}</a>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th scope="col"
                                class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-100">
                                #</th>
                            <th scope="col"
                                class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-100">
                                {{ __('site.Country') }}</th>
                            <th scope="col"
                                class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-100">
                                {{ __('site.Flag') }}</th>
                            <th scope="col"
                                class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-100">
                                {{ __('site.ShippingCost') }}</th>
                            <th scope="col"
                                class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-100">
                                {{ __('site.Actions') }}</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody class="table-border-bottom-0">
                        @if ($countries->isEmpty())
                            <!-- No Data Row -->
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                    {{ __('site.NoData') }}

                                </td>
                            </tr>
                        @else
                            <!-- Data Rows -->
                            @php $i = 1; @endphp
                            @foreach ($countries as $country)
                                <tr>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $i++ }}</td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $country->name }} </td>

                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">
                                        <object type="image/svg+xml"
                                            data="{{ asset('assets/countries/flags/' . $country->flag) }}" width="40"
                                            height="40"></object>
                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $country->shipping_cost }}</td>

                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400"
                                        style="display: flex; gap: 6px;">
                                        <a class="  text-primary hover:bg-success hover:text-white"
                                            href="{{ route('countries.edit', $country->id) }}">
                                            <button type="button"
                                                class="btn btn-icon btn-primary waves-effect waves-light">
                                                <span class="tf-icons mdi mdi-tag-edit-outline"></span>

                                            </button>
                                        </a>
                                        <form action="{{ route('countries.destroy', $country->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-icon btn-danger waves-effect waves-light">
                                                <span class="tf-icons mdi mdi-trash-can-outline"></span>

                                            </button>
                                        </form>
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
@endsection
