@extends('layouts.seller.master')


@section('title')
    {{ __('site.Marketplace') }}
@endsection


@section('css')
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">{{ __('site.Seller') }} /</span> {{ __('site.Marketplace') }}
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
                        <th>{{ __('site.Fulfilled') }}</th>
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
                                <td>{{ $product['fulfilled'] }}</td>
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
