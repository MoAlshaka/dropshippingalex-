@extends('layouts.master')


@section('title')
    {{ __('site.Order') }}
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

    <!-- Page CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Helpers -->
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ __('site.Dashboard') }} /</span>
            {{ __('site.Order') }}</h4>

        <!-- <div class="card">

                                                                                                </div> -->
        {{-- <div class="leed_container mx-4 grid md:grid-cols-12 gap-4 lg:mx-10 lg:gap-6 my-6">
            <!-- leed info  -->
            <div class="leed_info card_bg rounded-2xl p-6 shadow-md md:col-span-5">
                <div>
                    <h4 class="text-xl font-bold  capitalize mb-5">
                        {{ $order->lead->customer_name }}
                    </h4>
                </div>
                <hr />
                <div>
                    <h2 class="text-2xl font-bold  capitalize my-5">
                        lead information
                    </h2>
                    <div class="mobile flex items-center gap-1 ">
                        <span class="mdi mdi-phone-outline"></span>
                        <span class="text-sm"> {{ $order->lead->customer_phone }} </span>
                    </div>
                    <div class="adrdress">
                        <div class="adrdress_title flex items-center gap-1  text-md mt-4 mb-2">
                            <span class="mdi mdi-map-outline"></span>
                            <span class="font-bold  text-sm">Address</span>
                        </div>
                        <p class=" text-sm text-pretty">
                            {{ $order->lead->customer_addrress }}{{ $order->lead->customer_city }}
                        </p>
                    </div>
                    <div class="country">
                        <div class="country_title flex items-center gap-1  text-md mt-4 mb-2">
                            <span class="mdi mdi-map-marker-outline"></span>
                            <span class="font-bold  text-sm"> Country </span>
                        </div>
                        <div class=" text-md mt-2 mb-2 flex gap-2 items-center">
                            <span class="material-symbols-outlined relative top-[0px]">
                                <img src="{{ asset('assets/countries/flags/' . $country->flag) }}"
                                    alt="{{ $country->name }}" width="30" height="30">
                            </span>
                            <span class=" text-sm text-pretty">
                                @if ($order->lead->customer_country)
                                    {{ $order->lead->customer_country }}
                                @else
                                    {{ $order->lead->warehouse }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <hr />
                <div>
                    <h2 class="text-xl font-bold  capitalize my-2">
                        Store refrence
                    </h2>
                    <div>
                        <span class=" capitalize">store refrence:</span>
                        <span class=" text-sm"> {{ $order->lead->store_reference }} </span>
                    </div>
                </div>
            </div>
            <!-- product details -->
            <div class="product_details md:col-span-7 flex flex-col gap-6">
                <div class="details flex flex-col gap-6 lg:gap-4">
                    <div class="detail_nav card_bg rounded-t-lg px-6 py-4 shadow-sm">
                        <h4 class="uppercase text-sm md:text-md text-purple-600 font-bold">
                            details
                        </h4>
                    </div>
                    <div class="details_table_container card_bg rounded-2xl shadow-md p-6">
                        <div class="details_table_header">
                            <h4 class="text-sm uppercase  font-bold mb-4">
                                {{ __('site.OrderDetails') }}
                            </h4>
                            <hr />
                            <div class="overflow-auto">
                                <!-- but table here -->
                                <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th>{{ __('site.REF') }}</th>
                                                <th>{{ __('site.Warehouse') }}</th>
                                                <th>{{ __('site.Weight') }}</th>
                                                <th>{{ __('site.ShipmentStatus') }}</th>
                                                <th> {{ __('site.PaymentStatus') }}</th>
                                                <th> {{ __('site.Total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">

                                            <tr>
                                                <td>{{ $order->lead->store_reference }}</td>
                                                <td>{{ $order->lead->warehouse }}</td>
                                                <td>{{ $product->weight }}</td>
                                                <td>{{ $order->shipment_status }}</td>
                                                <td>{{ $order->payment_status }}</td>
                                                <td>{{ $order->lead->total }}</td>

                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="details flex flex-col gap-6">
                    <div class="details_table_container card_bg rounded-2xl shadow-md p-6">
                        <div class="details_table_header">
                            <h4 class="text-sm uppercase  font-bold mb-4">
                                Products
                            </h4>
                            <hr />
                            <div class="overflow-auto">
                                <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th>{{ __('site.Item') }}</th>
                                                <th>{{ __('site.Quantity') }}</th>
                                                <th>{{ __('site.Total') }}</th>

                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">

                                            <tr>
                                                <td>
                                                    @if ($product->commission)
                                                        <img src="{{ asset('assets/products/affiliateProduct/images/' . $product->image) }}"
                                                            alt="{{ $product->title }}" width="50" height="50">
                                                    @else
                                                        <img src="{{ asset('assets/products/sharedproduct/images/' . $product->image) }}"
                                                            alt="{{ $product->title }}" width="50" height="50">
                                                    @endif

                                                </td>
                                                <td>{{ $order->lead->quantity }}</td>
                                                <td>{{ $order->lead->total }}</td>


                                            </tr>


                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-8 gap-4 p-4">
            <div class="col-span-8">
                <div class="product-disc col-span-8 lg:col-span-5 card_bg rounded-md drop-shadow p-3">
                    <div>
                        <h4 class="text-xl font-bold  capitalize mb-5">
                            {{ $order->lead->customer_name }}
                        </h4>
                    </div>
                    <hr>
                    <div>
                        <h2 class="text-2xl font-bold  capitalize my-5">
                            {{ __('site.LeadInformation') }}
                        </h2>
                        <div class="mobile flex items-center gap-1 ">
                            <span class="mdi mdi-phone-outline"></span>
                            <span class="text-sm">{{ $order->lead->customer_phone }} </span>
                        </div>
                        <div class="adrdress">
                            <div class="adrdress_title flex items-center gap-1  text-md mt-4 mb-2">
                                <span class="mdi mdi-map-outline"></span>
                                <span class="font-bold  text-sm">{{ __('site.Address') }}</span>
                            </div>
                            <p class=" text-sm text-pretty">
                                {{ $order->lead->customer_addrress }}{{ $order->lead->customer_city }}
                            </p>
                        </div>
                        <div class="country">
                            <div class="country_title flex items-center gap-1  text-md mt-4 mb-2">
                                <span class="mdi mdi-map-marker-outline"></span>
                                <span class="font-bold  text-sm"> {{ __('site.Country') }} </span>
                            </div>
                            <div class=" text-md mt-2 mb-2 flex gap-2 items-center">
                                <span class="material-symbols-outlined relative top-[0px]">
                                    <img src="{{ asset('assets/countries/flags/' . $country->flag) }}"
                                        alt="{{ $country->name }}" width="30" height="30">
                                </span>
                                <span class=" text-sm text-pretty">
                                    @if ($order->lead->customer_country)
                                        {{ $order->lead->customer_country }}
                                    @else
                                        {{ $order->lead->warehouse }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <h2 class="text-xl font-bold  capitalize my-2">
                            {{ __('site.StoreReference') }}
                        </h2>
                        <div>
                            <span class=" capitalize">{{ __('site.StoreReference') }}:</span>
                            <span class=" text-sm"> {{ $order->lead->store_reference }} </span>
                        </div>
                    </div>
                </div>

                <div class="detail_nav mt-4 col-span-8 lg:col-span-5 card_bg rounded-md drop-shadow p-3">
                    <h4 class="uppercase text-sm md:text-md text-purple-600 font-bold">
                        {{ __('site.Details') }}
                    </h4>
                </div>
            </div>
            <!-- But Table hre -->
            <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4 ">
                <div>
                    <h4 class="text-sm uppercase  font-bold mb-4">
                        {{ __('site.OrderDetails') }}
                    </h4>
                </div>
                <div class="overflow-auto">
                    <table class="table">
                        <thead>
                            <tr class="text-nowrap">
                                <th>{{ __('site.REF') }}</th>
                                <th>{{ __('site.Warehouse') }}</th>
                                <th>{{ __('site.Weight') }}</th>
                                <th>{{ __('site.ShipmentStatus') }}</th>
                                <th> {{ __('site.PaymentStatus') }}</th>
                                <th> {{ __('site.Total') }}</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            <tr>
                                <td>{{ $order->lead->store_reference }}</td>
                                <td>{{ $order->lead->warehouse }}</td>
                                <td>{{ $product->weight }}</td>
                                <td>{{ $order->shipment_status }}</td>
                                <td>{{ $order->payment_status }}</td>
                                <td>{{ $order->lead->total }}</td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
            <!-- But Table hre -->

            <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4 ">
                <div>
                    <h4 class="text-sm uppercase  font-bold mb-4">
                        {{ __('site.Product') }}
                    </h4>
                </div>
                <div class="overflow-auto">
                    <table class="table">
                        <thead>
                            <tr class="text-nowrap">
                                <th>{{ __('site.Item') }}</th>
                                <th>{{ __('site.Quantity') }}</th>
                                <th>{{ __('site.Total') }}</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            <tr>
                                <td>
                                    @if ($product->commission)
                                        <img src="{{ asset('assets/products/affiliateProduct/images/' . $product->image) }}"
                                            alt="{{ $product->title }}" width="50" height="50">
                                    @else
                                        <img src="{{ asset('assets/products/sharedproduct/images/' . $product->image) }}"
                                            alt="{{ $product->title }}" width="50" height="50">
                                    @endif

                                </td>
                                <td>{{ $order->lead->quantity }}</td>
                                <td>{{ $order->lead->total }}</td>


                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>




    </div>
    <!-- / Content -->
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

    <script src="{{ asset('assets/js/main.js') }}"></script>
@endsection
