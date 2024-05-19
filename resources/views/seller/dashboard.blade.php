@extends('layouts.seller.master')


@section('title')
    {{ __('site.Dashboard') }}
@endsection


@section('css')
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
          rel="stylesheet"/>

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/materialdesignicons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}"/>

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css') }}"/>

    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-chat.css') }}"/>

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
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ __('site.Seller') }} /</span>
            {{ __('site.Dashboard') }}</h4>

        <div class="card_chart_cont  lg:flex ">
            <div class="chart_container mt-4 mx-4 md:mx-6 ">
                <div class="card">
                    <div class="card-header header-elements">
                        <div>
                            <h5 class="card-title mb-0">Statistics</h5>
                            <small class="text-muted">Commercial networks and enterprises</small>
                        </div>
                        <div class="card-header-elements ms-auto py-0">
                            <h5 class="mb-0 me-4">$ 78,000</h5>
                            <span class="badge bg-label-secondary rounded-pill">
                                <i class='ri-arrow-up-line ri-14px text-success'></i>
                                <span class="align-middle">37%</span>
                              </span>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <canvas id="lineChart" class="chartjs" data-height="700"
                                data-chart="{{json_encode($leads_count)}}"></canvas>
                    </div>
                </div>
            </div>
            <div
                class="card_container mt-4 mx-auto md:mx-6 grid grid-cols-7 md:grid-cols-8 gap-6  w-full"
            >
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            {{__('site.TotalLeads')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-green-700 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-currency-usd mdi-20px">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$leads}}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            {{__('site.ConfirmedLeads')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-yellow-300 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-bus-school mdi-20px">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$approvedLeadsCount}}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            {{__('site.DeliveredLeads')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-red-500 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                                <span class="mdi mdi-phone-outline"></span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$deliveredLeadsCount}}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            {{__('site.PendingLeads')}}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-purple-700 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-source-fork mdi-20px">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{$revenue}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rank_chat_cont lg:grid xl:grid-cols-4 mt-12 mb-6">
            <div class="chat_container mt-4 mx-4 md:mx-6 xl:col-span-3 mx-4">
                <div
                    class="chat max-h-[600px] min-h-[600px] bg-white rounded-xl shadow-md flex justify-center items-center"
                >
                    <span class="text-gray-600 text-3xl"> {{__('site.Chat')}} </span>
                </div>
            </div>
            <div class="ranks_container mt-4 mx-4 md:mx-6 xl:col-span-1 mx-4">
                <div class="sticky top-0 bg-white rounded-t-xl px-4 py-2">
                    <h4 class="text-xl font-bold text-gray-600 capitalize">{{__('site.Ranking')}}</h4>
                    <hr class="mt-2"/>
                </div>

                <div
                    class="rank bg-white rounded-b-xl px-4 pb-4 overflow-y-scroll min-h-[550px]"
                >
                    @foreach($sellers as $seller)
                        <div class="rank_memeber flex py-2 border-b-2">
                            <div class="img_wrapper">
                                <img
                                    src="{{asset('assets/sellers/images/'.$seller->image)}}"
                                    alt="avatar"
                                    class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                                />
                            </div>
                            <div class="member_info">
                                <h4 class="text-sm font-bold text-gray-600 capitalize">
                                    {{$seller->first_name}} {{$seller->last_name}}
                                </h4>
                                <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  {{ $seller->transactions->sum('amount') }}
                </span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
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

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/app-chat.js') }}"></script>
@endsection
