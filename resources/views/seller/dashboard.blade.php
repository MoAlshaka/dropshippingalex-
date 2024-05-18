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

        {{--        <div class="container-xxl flex-grow-1 container-p-y">--}}

        {{--            <div class="row gy-4">--}}
        {{--                <div class="col-sm-6 col-lg-3">--}}
        {{--                    <div class="card card-border-shadow-primary h-100">--}}
        {{--                        <div class="card-body">--}}
        {{--                            <div class="d-flex align-items-center mb-2 pb-1">--}}
        {{--                                <div class="avatar me-2">--}}
        {{--                                    <span class="avatar-initial rounded bg-label-primary"><i--}}
        {{--                                            class="mdi mdi-source-fork mdi-20px"></i></span>--}}
        {{--                                </div>--}}
        {{--                                <h4 class="ms-1 mb-0 display-6">--}}
        {{--                                    @isset($leads)--}}
        {{--                                        {{ $leads }}--}}
        {{--                                    @endisset--}}
        {{--                                </h4>--}}
        {{--                            </div>--}}
        {{--                            <p class="mb-0 text-heading"> {{ __('site.Totalleads') }} </p>--}}

        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="col-sm-6 col-lg-3">--}}
        {{--                    <div class="card card-border-shadow-warning h-100">--}}
        {{--                        <div class="card-body">--}}
        {{--                            <div class="d-flex align-items-center mb-2 pb-1">--}}
        {{--                                <div class="avatar me-2">--}}
        {{--                                    <span class="avatar-initial rounded bg-label-warning">--}}
        {{--                                        <i class="mdi mdi-phone mdi-20px"></i></span>--}}
        {{--                                </div>--}}
        {{--                                <h4 class="ms-1 mb-0 display-6">--}}
        {{--                                    @isset($approvedLeadsCount)--}}
        {{--                                        {{ $approvedLeadsCount }}--}}
        {{--                                    @endisset--}}
        {{--                                </h4>--}}
        {{--                            </div>--}}
        {{--                            <p class="mb-0 text-heading"> {{ __('site.ConfirmedLeads') }}</p>--}}

        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="col-sm-6 col-lg-3">--}}
        {{--                    <div class="card card-border-shadow-danger h-100">--}}
        {{--                        <div class="card-body">--}}
        {{--                            <div class="d-flex align-items-center mb-2 pb-1">--}}
        {{--                                <div class="avatar me-2">--}}
        {{--                                    <span class="avatar-initial rounded bg-label-danger">--}}

        {{--                                        <i class="mdi mdi-bus-school mdi-20px"></i>--}}
        {{--                                    </span>--}}
        {{--                                </div>--}}
        {{--                                <h4 class="ms-1 mb-0 display-6">--}}
        {{--                                    @isset($deliveredLeadsCount)--}}
        {{--                                        {{ $deliveredLeadsCount }}--}}
        {{--                                    @endisset--}}
        {{--                                </h4>--}}
        {{--                            </div>--}}
        {{--                            <p class="mb-0 text-heading"> {{ __('site.DeliveredLeads') }}</p>--}}

        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="col-sm-6 col-lg-3">--}}
        {{--                    <div class="card card-border-shadow-info h-100">--}}
        {{--                        <div class="card-body">--}}
        {{--                            <div class="d-flex align-items-center mb-2 pb-1">--}}
        {{--                                <div class="avatar me-2">--}}
        {{--                                    <span class="avatar-initial rounded bg-label-info"><i--}}
        {{--                                            class="mdi mdi-currency-usd mdi-20px"></i></span>--}}
        {{--                                </div>--}}
        {{--                                <h4 class="ms-1 mb-0 display-6">{{$revenue}} $</h4>--}}
        {{--                            </div>--}}
        {{--                            <p class="mb-0 text-heading"> {{ __('site.TotalRevenue') }} </p>--}}

        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--        <div class="row mb-4 g-4">--}}
        {{--            <div class="col-12 col-xl-8">--}}
        {{--                <div class="app-chat card-body overflow-hidden">--}}
        {{--                    <div class="row g-0">--}}
        {{--                        <!-- Sidebar Left -->--}}
        {{--                        <div class="col app-chat-sidebar-left app-sidebar overflow-hidden">--}}

        {{--                        </div>--}}
        {{--                        <!-- /Sidebar Left-->--}}

        {{--                        <!-- Chat & Contacts -->--}}
        {{--                        <div class="  col app-sidebar flex-grow-0 overflow-hidden border-end">--}}

        {{--                        </div>--}}
        {{--                        <!-- /Chat contacts -->--}}

        {{--                        <!-- Chat History -->--}}
        {{--                        <div class="col card-body">--}}

        {{--                        </div>--}}
        {{--                        <!-- /Chat History -->--}}

        {{--                        <!-- Sidebar Right -->--}}

        {{--                        <!-- /Sidebar Right -->--}}

        {{--                        <div class="app-overlay"></div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        {{--            <div class="col-12 col-xl-4 col-md-6">--}}
        {{--                <div class="card h-100">--}}
        {{--                    <div class="card-header d-flex align-items-center justify-content-between">--}}
        {{--                        <div class="card-title mb-0">--}}
        {{--                            <h5 class="m-0 me-2"> {{ __('site.TopSellers') }}</h5>--}}
        {{--                        </div>--}}

        {{--                    </div>--}}
        {{--                    <div class="table-responsive">--}}
        {{--                        <table class="table table-borderless border-top">--}}
        {{--                            <thead class="border-bottom">--}}
        {{--                            <tr>--}}
        {{--                                <th> {{ __('site.Sellers') }}</th>--}}
        {{--                                <th class="text-end"> {{ __('site.RankPoints') }}</th>--}}
        {{--                            </tr>--}}
        {{--                            </thead>--}}
        {{--                            <tbody>--}}
        {{--                            <tr>--}}
        {{--                                <td>--}}
        {{--                                    <div class="d-flex justify-content-start align-items-center mt-lg-4">--}}
        {{--                                        <div class="avatar avatar-sm me-3">--}}
        {{--                                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar"--}}
        {{--                                                 class="rounded-circle"/>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="d-flex flex-column">--}}
        {{--                                            <h6 class="mb-1 text-truncate">Maven Analytics</h6>--}}
        {{--                                            <small class="text-truncate">Business Intelligence</small>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                                <td class="text-end">--}}
        {{--                                    <div class="user-progress mt-lg-4">--}}
        {{--                                        <h6 class="mb-0">33</h6>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <td>--}}
        {{--                                    <div class="d-flex justify-content-start align-items-center">--}}
        {{--                                        <div class="avatar avatar-sm me-3">--}}
        {{--                                            <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar"--}}
        {{--                                                 class="rounded-circle"/>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="d-flex flex-column">--}}
        {{--                                            <h6 class="mb-1 text-truncate">Zsazsa McCleverty</h6>--}}
        {{--                                            <small class="text-truncate">Digital Marketing</small>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                                <td class="text-end">--}}
        {{--                                    <div class="user-progress">--}}
        {{--                                        <h6 class="mb-0">52</h6>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <td>--}}
        {{--                                    <div class="d-flex justify-content-start align-items-center">--}}
        {{--                                        <div class="avatar avatar-sm me-3">--}}
        {{--                                            <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Avatar"--}}
        {{--                                                 class="rounded-circle"/>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="d-flex flex-column">--}}
        {{--                                            <h6 class="mb-1 text-truncate">Nathan Wagner</h6>--}}
        {{--                                            <small class="text-truncate">UI/UX Design</small>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                                <td class="text-end">--}}
        {{--                                    <div class="user-progress">--}}
        {{--                                        <h6 class="mb-0">12</h6>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <td>--}}
        {{--                                    <div class="d-flex justify-content-start align-items-center">--}}
        {{--                                        <div class="avatar avatar-sm me-3">--}}
        {{--                                            <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Avatar"--}}
        {{--                                                 class="rounded-circle"/>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="d-flex flex-column">--}}
        {{--                                            <h6 class="mb-1 text-truncate">Emma Bowen</h6>--}}
        {{--                                            <small class="text-truncate">React Native</small>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                                <td class="text-end">--}}
        {{--                                    <div class="user-progress">--}}
        {{--                                        <h6 class="mb-0">8</h6>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                            </tr>--}}
        {{--                            </tbody>--}}
        {{--                        </table>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        {{--        </div>--}}
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
