@extends('layouts.master')


@section('title')
    {{ __('site.Report') }}
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
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span
                class="text-muted fw-light">{{ __('site.Dashboard') }} /</span> {{ __('site.Report') }}
        </h4>
        <div class="bg-white drop-shadow p-4 rounded-md flex flex-col md:flex-row gap-6">
            <a class="hover:border-b-4 hover:border-purple-700 flex gap-2 items-center justify-center"
               href="{{ route('admin.reports.index') }}">
                <i class="menu-icon tf-icons mdi mdi-earth"></i>
                {{ __('site.AllCountries') }}
            </a>


            @isset($countries)
                @foreach ($countries as $country)
                    <a class="hover:border-b-4 hover:border-purple-700 flex gap-2 items-center justify-center"
                       href="{{ route('admin.report.country.filter', $country->id) }}">
                        <img src="{{ asset('assets/countries/flags/' . $country->flag) }}" alt="{{ $country->name }}"
                             width="40" height="40">
                        <span>{{ $country->name }}</span></a>
                @endforeach
            @endisset
        </div>
        <div class="card_chart_cont  lg:flex ">

            <div
                class="card_container mt-4 mx-auto md:mx-6 grid grid-cols-12  gap-6  w-full"
            >
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[20px] lg:text-[18px] text-gray-800 font-bold uppercase">
                            {{__('site.TotalLeads')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-blue-700 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="menu-icon tf-icons mdi mdi-view-list-outline">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$leads}}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[20px] lg:text-[18px] text-gray-800 font-bold uppercase">
                            {{__('site.UnderProcesses')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-yellow-300 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-phone-outline">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$under_process}}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[20px] lg:text-[18px] text-gray-800 font-bold uppercase">
                            {{__('site.Confirmed')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-green-500 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                                <span class="mdi mdi-check-circle-outline"></span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$confirmed}}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[20px] lg:text-[18px] text-gray-800 font-bold uppercase">
                            {{__('site.Canceled')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-red-700 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-cancel">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$canceled}}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[20px] lg:text-[18px] text-gray-800 font-bold uppercase">
                            {{__('site.Fulfilled')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-orange-500 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-package-variant-closed">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$fulfilled}}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[20px] lg:text-[18px] text-gray-800 font-bold uppercase">
                            {{__('site.Shipped')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-pink-600 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-bus-school mdi-20px">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$shipped}}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[20px] lg:text-[18px] text-gray-800 font-bold uppercase">
                            {{__('site.Delivered')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-green-500 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                                <span class="mdi mdi-package-check"></span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$delivered}}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-12 md:col-span-6 lg:col-span-3 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-[15px] lg:text-[25px] text-gray-800 font-bold uppercase">
                            {{__('site.Returned')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-red-500 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-keyboard-return">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$returned}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="persentage_cont  min-h-[300px] grid lg:grid-cols-6 p-4 rounded-md  gap-6">
            <div
                class="value_container pt-[15px] bg-white flex flex-col rounded-xl lg:flex-row drop-shadow-lg lg:col-span-3">
                <div class="relative min-w-[250px]">
      <span
          class="text-gray-600 text-5xl absolute top-[50%] right-[50%] translate-x-[50%] translate-y-[-50%] font-bold"
      >{{$delivered_rate}} %</span
      >
                    <svg viewBox="0 0 36 36" class="circular-chart orange">
                        <path
                            class="circle-bg"
                            d="M18 2.0845
            a 15.9155 15.9155 0 0 1 0 31.831
            a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <!-- place the 60 in the stroke-dasharray with the persentage -->
                        <path
                            class="circle"
                            stroke-dasharray="{{$delivered_rate}}, 100"
                            d="M18 2.0845
            a 15.9155 15.9155 0 0 1 0 31.831
            a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                    </svg>
                </div>
                <div class="flex flex-col justify-center px-4 ">
                    <h3 class="text-gray-600 font-bold capitalize">
                        DELIVERED RATE
                    </h3>
                    <p class="text-pretty">
                        Delivered rate is the number of delivered shipments out of the total shipments
                    </p>
                </div>
            </div>
            <div
                class="value_container pt-[15px] bg-white flex flex-col rounded-xl lg:flex-row drop-shadow-lg lg:col-span-3">
                <div class="relative min-w-[250px]">
      <span
          class="text-gray-600 text-5xl absolute top-[50%] right-[50%] translate-x-[50%] translate-y-[-50%] font-bold"
      >{{$confirmed_rate}} %</span
      >
                    <svg viewBox="0 0 36 36" class="circular-chart green">
                        <path
                            class="circle-bg"
                            d="M18 2.0845
            a 15.9155 15.9155 0 0 1 0 31.831
            a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <!-- place the 60 in the stroke-dasharray with the persentage -->
                        <path
                            class="circle"
                            stroke-dasharray="{{$confirmed_rate}}, 100"
                            d="M18 2.0845
            a 15.9155 15.9155 0 0 1 0 31.831
            a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                    </svg>
                </div>
                <div class="flex flex-col justify-center px-4 ">
                    <h3 class="text-gray-600 font-bold capitalize">
                        Confirmation Rate
                    </h3>
                    <p class="text-pretty">
                        Confirmation rate is the number of confirmed leads out of the total processed leads (excluding
                        duplicate & wrong leads)
                    </p>
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

    <!-- Page JS -->
    <script src="{{ asset('assets/js/app-logistics-dashboard.js') }}"></script>
@endsection
