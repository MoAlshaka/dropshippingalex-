@extends('layouts.master')


@section('title')
    {{ __('site.Affiliate') }}
@endsection


@section('css')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .accordion-button {
            width: 0% !important;
        }
    </style>
    <style>
        .flex-wrapper {
            display: flex;
            flex-flow: row nowrap;
        }

        .single-chart {
            width: 33%;
            justify-content: space-around;
        }

        .circular-chart {
            display: block;
            margin: 10px auto;
            max-width: 80%;
            max-height: 250px;
        }

        .circle-bg {
            fill: none;
            stroke: #eee;
            stroke-width: 3.8;
        }

        .circle {
            fill: none;
            stroke-width: 2.8;
            stroke-linecap: round;
            animation: progress 1s ease-out forwards;
        }

        @keyframes progress {
            0% {
                stroke-dasharray: 0 100;
            }
        }

        .circular-chart.orange .circle {
            stroke: #ff9f00;
        }

        .circular-chart.green .circle {
            stroke: #4cc790;
        }

        .circular-chart.blue .circle {
            stroke: #3c9ee5;
        }

        .percentage {
            fill: #666;
            font-family: sans-serif;
            font-size: 0.5em;
            text-anchor: middle;
        }
    </style>
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
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4 d-flex justify-content-between">
            <div>
                <span class="text-muted fw-light"> {{ __('site.Admin') }} /</span>
                {{ __('site.Affiliate') }}
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
                        <form action="{{ route('admin.reports.affiliate.filter.date') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <div class="mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="bs-rangepicker-range" class="form-control" name="date">
                                        <label for="bs-rangepicker-range">{{ __('site.Date') }}</label>
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                {{ __('site.Filter') }}</button>
                            <a href="{{ route('admin.reports.affiliate.filter') }}"
                                class="btn btn-outline-danger waves-effect">
                                {{ __('site.Back') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </h4>

        <div class="card_chart_cont  lg:flex ">

            <div class="card_container mt-4 mx-auto md:mx-6 grid grid-cols-12  gap-6  w-full">
                <div
                    class="card card_bg px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md">
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[20px] lg:text-[18px]  font-bold uppercase">
                            {{ __('site.TotalLeads') }}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div class="bg-blue-700 rounded-full text-white px-4 py-2 flex justify-center items-center">
                                <span class="menu-icon tf-icons mdi mdi-view-list-outline">

                                </span>
                            </div>
                            <span class=" text-3xl font-bold">{{ $leads }}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card card_bg px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md">
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[20px] lg:text-[18px]  font-bold uppercase">
                            {{ __('site.UnderProcesses') }}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div class="bg-yellow-300 rounded-full text-white px-4 py-2 flex justify-center items-center">
                                <span class="mdi mdi-phone-outline">

                                </span>
                            </div>
                            <span class=" text-3xl font-bold">{{ $under_process }}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card card_bg px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md">
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[20px] lg:text-[18px]  font-bold uppercase">
                            {{ __('site.Confirmed') }}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div class="bg-green-500 rounded-full text-white px-4 py-2 flex justify-center items-center">
                                <span class="mdi mdi-check-circle-outline"></span>
                            </div>
                            <span class=" text-3xl font-bold">{{ $confirmed }}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card card_bg px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md">
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[25px]  font-bold uppercase">
                            {{ __('site.Delivered') }}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div class="bg-green-500 rounded-full text-white px-4 py-2 flex justify-center items-center">
                                <span class="mdi mdi-package-check"></span>
                            </div>
                            <span class=" text-3xl font-bold">{{ $delivered }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="persentage_cont  min-h-[300px] grid lg:grid-cols-6 mt-4 rounded-md  gap-6">
            <div class="general_Info grid grid-cols-12 gap-6 lg:col-span-6">
                <div
                    class="card_info col-span-12 md:col-span-6 lg:col-span-4  p-6 card_bg flex flex-col rounded-xl lg:flex-row drop-shadow-lg ">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-bold">{{ __('site.Totalcommisoins') }}</h3>
                            <span class="price  text-2xl font-bold">
                                {{ $total_commission }} $
                            </span>
                            <p class=" text-sm font-bold capitalize">over {{ $leads }} leads</p>
                        </div>
                        <div>
                            <img class="object-cover w-[120px]"
                                src="{{ asset('assets/img/reportImages/commission.png') }}" alt="">
                        </div>
                    </div>
                </div>

                <div
                    class="card_info col-span-12 md:col-span-6 lg:col-span-4 p-6 card_bg flex flex-col rounded-xl lg:flex-row drop-shadow-lg ">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-bold">{{ __('site.Averagecommission') }}</h3>
                            <span class="price  text-2xl font-bold">
                                {{ $average_commission }} $
                            </span>
                            <p class=" text-sm font-bold capitalize">over {{ $leads }} leads</p>
                        </div>
                        <div>
                            <img class="object-cover w-[120px]" src="{{ asset('assets/img/reportImages/discount.png') }}"
                                alt="">
                        </div>
                    </div>
                </div>
                <div
                    class="card_info col-span-12 md:col-span-6 lg:col-span-4 p-6 card_bg flex flex-col rounded-xl lg:flex-row drop-shadow-lg ">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-bold">{{ __('site.Highestcommission') }}</h3>
                            <span class="price  text-2xl font-bold">
                                {{ $highest_commission->commission ?? 0 }} $
                            </span>
                            <p class=" text-sm font-bold capitalize">{{ $highest_commission->title ?? '' }}
                            </p>
                        </div>
                        <div>
                            <img class="object-cover w-[120px]" src="{{ asset('assets/img/reportImages/profits.png') }}"
                                alt="">
                        </div>
                    </div>
                </div>

            </div>


            <div
                class="value_container pt-[15px] card_bg flex flex-col rounded-xl lg:flex-row drop-shadow-lg lg:col-span-3">
                <div class="relative min-w-[250px]">
                    <span
                        class=" text-5xl absolute top-[50%] right-[50%] translate-x-[50%] translate-y-[-50%] font-bold">{{ $confirmed_rate ?? 0 }}
                        %</span>
                    <svg viewBox="0 0 36 36" class="circular-chart green">
                        <path class="circle-bg"
                            d="M18 2.0845
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <!-- place the 60 in the stroke-dasharray with the persentage -->
                        <path class="circle" stroke-dasharray="{{ $confirmed_rate }}, 100"
                            d="M18 2.0845
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                </div>
                <div class="flex flex-col justify-center px-4 ">
                    <h3 class=" font-bold capitalize">
                        {{ __('site.ConfirmationRate') }}
                    </h3>
                    <p class="text-pretty">
                        {{ __('site.ConfirmationRateDesc') }}
                    </p>
                </div>
            </div>

            <div class="hightest_prod p-6 card_bg flex flex-col rounded-xl  drop-shadow-lg lg:col-span-3">
                <div class="mb-4">
                    <h3 class="text-md font-bold  capitalize"> {{ __('site.HiestProducts') }}</h3>
                    <p class=" text-sm capitalize"> {{ __('site.HiestRanking') }}</p>
                </div>
                <div class="flex flex-col gap-2 overflow-x-auto h-[120px] ">

                    @foreach ($highestCommissions as $highestCommission)
                        <div
                            class="top_product flex items-center border border-gray-200 rounded-xl p-2 flex gap-2 justify-between">
                            <div class=" rounded-full text-white px-2 py-2 flex justify-center items-center">
                                {{-- <span class="mdi mdi-chart-line-stacked">
                                </span> --}}
                                <img src="{{ asset('assets/products/affiliateProduct/images/' . $highestCommission['highest_commission']->image) }}"
                                    alt="{{ $highestCommission['highest_commission']->title }}" width="50"
                                    height="50">
                            </div>
                            <h3 class="text-md font-bold  capitalize ">
                                {{ $highestCommission['highest_commission']->title }}</h3>
                            <span class=" text-md font-bold">{{ $highestCommission['amount'] }} $</span>
                        </div>
                    @endforeach

                </div>
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

    <!-- build:js assets/vendor/js/core.js -->

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


    <script src="{{ asset('assets/js/forms-pickers.js') }}"></script>


    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
@endsection
