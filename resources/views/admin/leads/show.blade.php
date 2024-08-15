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
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />

    <!-- Page CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Helpers -->
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ __('site.Dashboard') }} /</span>
            {{ __('site.Leads') }}</h4>

        <div class="leed_container mx-4 grid md:grid-cols-12 gap-4 lg:mx-10 lg:gap-6 my-6">
            <!-- leed info  -->
            <div class="leed_info card_bg rounded-2xl p-6 shadow-md md:col-span-5">
                <div>
                    <h4 class="text-xl font-bold  capitalize mb-5">
                        {{ $lead->customer_name }}
                    </h4>
                </div>
                <hr />
                <div>
                    <h2 class="text-2xl font-bold  capitalize my-5">
                        {{ __('site.LeadInformation') }}
                    </h2>
                    <div class="mobile flex items-center gap-1 ">
                        <span class="mdi mdi-phone-outline"></span>
                        <span class="text-sm"> {{ $lead->customer_phone }} </span>
                    </div>
                    <div class="adrdress">
                        <div class="adrdress_title flex items-center gap-1  text-md mt-4 mb-2">
                            <span class="mdi mdi-map-outline"></span>
                            <span class="font-bold  text-sm"> {{ __('site.Address') }}</span>
                        </div>
                        <p class=" text-sm text-pretty">
                            {{ $lead->customer_addrress }}{{ $lead->customer_city }}
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
                                @if ($lead->customer_country)
                                    {{ $lead->customer_country }}
                                @else
                                    {{ $lead->warehouse }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <hr />
                <div>
                    <h2 class="text-xl font-bold  capitalize my-2">
                        {{ __('site.StoreReference') }}
                    </h2>
                    <div>
                        <span class=" capitalize">{{ __('site.StoreReference') }}:</span>
                        <span class=" text-sm"> {{ $lead->store_reference }} </span>
                    </div>
                </div>
            </div>
            <!-- product details -->
            <div class="product_details md:col-span-7 flex flex-col gap-6">
                {{-- <div class="details flex flex-col gap-6 lg:gap-4">
                        <div class="detail_nav card_bg rounded-t-lg px-6 py-4 shadow-sm">
                            <h4 class="uppercase text-sm md:text-md text-purple-600 font-bold">
                                {{ __('site.Details') }}
                            </h4>
                        </div>
                        <div class="details_table_container card_bg rounded-2xl shadow-md p-6">
                            <div class="details_table_header">
                                <h4 class="text-sm uppercase  font-bold mb-4">
                                    {{ __('site.LeadDetails') }}
                                </h4>
                                <hr />
                                <div class="overflow-auto">
                                    <!-- but table here -->
                                    <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-nowrap">
                                                    <th>{{ __('site.REF') }}</th>
                                                    <th>{{ __('site.CreatedAt') }}</th>
                                                    <th>{{ __('site.Status') }}</th>
                                                    <th> {{ __('site.Type') }}</th>
                                                    <th> {{ __('site.Total') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">

                                                <tr>
                                                    <td>{{ $lead->store_reference }}</td>
                                                    <td>{{ $lead->created_at }}</td>
                                                    <td>{{ $lead->status }}</td>
                                                    <td>{{ $lead->type }}
                                                        @if ($lead->type == 'commission')
                                                            @if ($lead->affiliateproduct->type == 'delivered')
                                                                {{ __('site.PerDelivered') }}
                                                            @else
                                                                {{ __('site.PerConfirmed') }}
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>{{ $lead->total . ' ' . $lead->currency }}</td>

                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                <div class="row">
                    <div class="details flex flex-col gap-6 lg:gap-4">

                        <div class="card mb-4">
                            <div class="card-header p-0">
                                <div class="nav-align-top">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" role="tab"
                                                data-bs-toggle="tab" data-bs-target="#navs-top-home"
                                                aria-controls="navs-top-home" aria-selected="true">
                                                {{ __('site.Details') }}
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#navs-top-profile" aria-controls="navs-top-profile"
                                                aria-selected="false">
                                                {{ __('site.History') }}
                                            </button>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content p-0">
                                    <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                                        <div class="details flex flex-col gap-6 lg:gap-4 mb-4">
                                            <div class="details_table_container card_bg rounded-2xl">
                                                <div class="details_table_header">
                                                    <h4 class="text-sm uppercase  font-bold mb-4">
                                                        {{ __('site.LeadDetails') }}
                                                    </h4>
                                                    <hr />
                                                    <div class="overflow-auto">
                                                        <!-- but table here -->
                                                        <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr class="text-nowrap">
                                                                        <th>{{ __('site.REF') }}</th>
                                                                        <th>{{ __('site.CreatedAt') }}</th>
                                                                        <th>{{ __('site.Status') }}</th>
                                                                        <th> {{ __('site.Type') }}</th>
                                                                        <th> {{ __('site.Total') }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table-border-bottom-0">

                                                                    <tr>
                                                                        <td>{{ $lead->store_reference }}</td>
                                                                        <td>{{ $lead->created_at }}</td>
                                                                        <td>{{ $lead->status }}</td>
                                                                        <td>{{ $lead->type }}
                                                                            @if ($lead->type == 'commission')
                                                                                @if ($lead->affiliateproduct->type == 'delivered')
                                                                                    {{ __('site.PerDelivered') }}
                                                                                @else
                                                                                    {{ __('site.PerConfirmed') }}
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $lead->total . ' ' . $lead->currency }}</td>

                                                                    </tr>


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="border-xl">
                                        <div class="details flex flex-col gap-6 lg:gap-4 mt-4">
                                            <div class="details_table_container card_bg rounded-2xl">
                                                <div class="details_table_header">
                                                    <h4 class="text-sm uppercase  font-bold mb-4">
                                                        {{ __('site.Product') }}
                                                    </h4>
                                                    <hr />
                                                    <div class="overflow-auto">
                                                        <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr class="text-nowrap">
                                                                        <th>{{ __('site.Item') }}</th>
                                                                        <th>{{ __('site.SKU') }}</th>
                                                                        <th>{{ __('site.Quantity') }}</th>
                                                                        <th>{{ __('site.Total') }}</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table-border-bottom-0">

                                                                    <tr>
                                                                        <td>
                                                                            @if ($affiliateproduct)
                                                                                <img src="{{ asset('assets/products/affiliateProduct/images/' . $affiliateproduct->image) }}"
                                                                                    alt="{{ $affiliateproduct->title }}"
                                                                                    width="50" height="50">
                                                                            @else
                                                                                <img src="{{ asset('assets/products/sharedproduct/images/' . $sharedproduct->image) }}"
                                                                                    alt="{{ $sharedproduct->title }}"
                                                                                    width="50" height="50">
                                                                            @endif

                                                                        </td>
                                                                        <td>{{ $lead->item_sku }}</td>
                                                                        <td>{{ $lead->quantity }}</td>
                                                                        <td>{{ $lead->total . ' ' . $lead->currency }}</td>


                                                                    </tr>


                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade min-h-[400px]" id="navs-top-profile" role="tabpanel">
                                        @foreach ($lead->notes as $note)
                                            <p>
                                                {{ $note->created_at->format('Y-m-d') . ' => ' . $note->title }}
                                            </p>
                                        @endforeach

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{-- <div class="leed_container mx-4 grid md:grid-cols-12 gap-4 lg:mx-10 lg:gap-6 my-6">
            <!-- leed info  -->
            <div class="leed_info card_bg rounded-2xl p-6 shadow-md md:col-span-5">
                <div>
                    <h4 class="text-xl font-bold  capitalize mb-5">
                        {{ $lead->customer_name }}
                    </h4>
                </div>
                <hr />
                <div>
                    <h2 class="text-2xl font-bold  capitalize my-5">
                        {{ __('site.LeadInformation') }}
                    </h2>
                    <div class="mobile flex items-center gap-1 ">
                        <span class="mdi mdi-phone-outline"></span>
                        <span class="text-sm"> {{ $lead->customer_phone }} </span>
                    </div>
                    <div class="adrdress">
                        <div class="adrdress_title flex items-center gap-1  text-md mt-4 mb-2">
                            <span class="mdi mdi-map-outline"></span>
                            <span class="font-bold  text-sm"> {{ __('site.Address') }}</span>
                        </div>
                        <p class=" text-sm text-pretty">
                            {{ $lead->customer_addrress }}{{ $lead->customer_city }}
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
                                @if ($lead->customer_country)
                                    {{ $lead->customer_country }}
                                @else
                                    {{ $lead->warehouse }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <hr />
                <div>
                    <h2 class="text-xl font-bold  capitalize my-2">
                        {{ __('site.StoreReference') }}
                    </h2>
                    <div>
                        <span class=" capitalize">{{ __('site.StoreReference') }}:</span>
                        <span class=" text-sm"> {{ $lead->store_reference }} </span>
                    </div>
                </div>
            </div>
            <!-- product details -->
            <div class="product_details md:col-span-7 flex flex-col gap-6">
                <div class="details flex flex-col gap-6 lg:gap-4">
                    <div class="detail_nav card_bg rounded-t-lg px-6 py-4 shadow-sm">
                        <h4 class="uppercase text-sm md:text-md text-purple-600 font-bold">
                            {{ __('site.Details') }}
                        </h4>
                    </div>
                    <div class="details_table_container card_bg rounded-2xl shadow-md p-6">
                        <div class="details_table_header">
                            <h4 class="text-sm uppercase  font-bold mb-4">
                                {{ __('site.LeadDetails') }}
                            </h4>
                            <hr />
                            <div class="overflow-auto">
                                <!-- but table here -->
                                <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th>{{ __('site.REF') }}</th>
                                                <th>{{ __('site.CreatedAt') }}</th>
                                                <th>{{ __('site.Status') }}</th>
                                                <th> {{ __('site.Type') }}</th>
                                                <th> {{ __('site.Total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">

                                            <tr>
                                                <td>{{ $lead->store_reference }}</td>
                                                <td>{{ $lead->created_at }}</td>
                                                <td>{{ $lead->status }}</td>
                                                <td>{{ $lead->type }}
                                                    @if ($lead->type == 'commission')
                                                        @if ($lead->affiliateproduct->type == 'delivered')
                                                            {{ __('site.PerDelivered') }}
                                                        @else
                                                            {{ __('site.PerConfirmed') }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $lead->total . ' ' . $lead->currency }}</td>

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
                                {{ __('site.Product') }}
                            </h4>
                            <hr />
                            <div class="overflow-auto">
                                <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th>{{ __('site.Item') }}</th>
                                                <th>{{ __('site.SKU') }}</th>
                                                <th>{{ __('site.Quantity') }}</th>
                                                <th>{{ __('site.Total') }}</th>

                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">

                                            <tr>
                                                <td>
                                                    @if ($affiliateproduct)
                                                        <img src="{{ asset('assets/products/affiliateProduct/images/' . $affiliateproduct->image) }}"
                                                            alt="{{ $affiliateproduct->title }}" width="50"
                                                            height="50">
                                                    @else
                                                        <img src="{{ asset('assets/products/sharedproduct/images/' . $sharedproduct->image) }}"
                                                            alt="{{ $sharedproduct->title }}" width="50"
                                                            height="50">
                                                    @endif

                                                </td>
                                                <td>{{ $lead->item_sku }}</td>
                                                <td>{{ $lead->quantity }}</td>
                                                <td>{{ $lead->total . ' ' . $lead->currency }}</td>


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
