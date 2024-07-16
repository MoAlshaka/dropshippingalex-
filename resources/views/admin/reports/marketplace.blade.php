@extends('layouts.master')


@section('title')
    {{ __('site.Marketplace') }}
@endsection


@section('css')
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 d-flex justify-content-between">
            <div>
                <span class="text-muted fw-light">{{ __('site.Admin') }} /</span>
                {{ __('site.Marketplace') }}
            </div>
            <div>
                <button class="btn btn-outline-primary waves-effect waves-light" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <span class="tf-icons mdi mdi-filter-check-outline me-1"></span>
                    Filter
                </button>
                {{--                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas</button> --}}
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                    aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ __('site.FliterOrders') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form action="{{ route('admin.reports.marketplace.filter.date') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <div class="mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="bs-rangepicker-range" class="form-control" name="date">
                                        <label for="bs-rangepicker-range">{{ __('site.Date') }}</label>
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">filter</button>
                            <button type="reset" class="btn btn-outline-danger waves-effect">reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </h4>

        <div class="table-responsive text-nowrap">
            <table class="table" id="em_data">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>{{ __('site.Product') }}</th>
                        <th>{{ __('site.Leads') }}</th>
                        <th>{{ __('site.Confirmed') }}</th>
                        <th>{{ __('site.Canceled') }}</th>
                        <th>{{ __('site.ConfirmedRate') }}</th>
                        <th>{{ __('site.balance') }}</th>
                        <th>{{ __('site.Shipped') }}</th>
                        <th>{{ __('site.Delivered') }}</th>
                        <th>{{ __('site.Returned') }}</th>
                        <th>{{ __('site.DeliveredRate') }}</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if (isset($products))
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td>
                                    @if ($product['type'] == 'affiliate')
                                        <img src="{{ asset('assets/products/affiliateproduct/images/' . $product['product']->image) }}"
                                            alt="image" width="40" height="40">
                                    @else
                                        <img src="{{ asset('assets/products/sharedproduct/images/' . $product['product']->image) }}"
                                            alt="image" width="40" height="40">
                                    @endif

                                    {{ $product['product']->title }}
                                </td>
                                <td>{{ $product['leads'] }}</td>
                                <td>{{ $product['confirmed'] }}</td>
                                <td>{{ $product['cancelled'] }}</td>
                                <td>{{ $product['confirmed_rate'] }}%</td>
                                <td>{{ $product['balance'] }}</td>
                                <td> {{ $product['shipped'] }}</td>
                                <td> {{ $product['delivered'] }}</td>
                                <td> {{ $product['returned'] }}</td>
                                <td>{{ $product['delivered_rate'] }}%</td>
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

        </div>
    </div>
@endsection




@section('js')
    <!-- Core JS -->
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
