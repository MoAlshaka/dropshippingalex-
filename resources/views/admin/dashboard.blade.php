@extends('layouts.master')


@section('title')
    {{ __('site.Dashboard') }}
@endsection


@section('css')
    <script src="https://cdn.tailwindcss.com"></script>
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
    <style>
        .top-\[67px\] {
            top: 67px;
        }

        .left-\[36px\] {
            left: 36px;
        }

        .rank_icon {
            z-index: 9999 !important;
            position: relative;
        }

        .img_avtr_size {
            width: 60px !important;
            height: 60px !important;
            left: 10px !important;
            top: 10px !important;
        }
    </style>
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
                <span class="text-muted fw-light"> {{ __('site.Admin') }} /</span>
                {{ __('site.Dashboard') }}
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
                        <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ __('site.Filter') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form action="{{ route('admin.dashboard.filter') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <div class="mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="bs-rangepicker-range" class="form-control" name="date">
                                        <label for="bs-rangepicker-range">{{ __('site.Date') }}</label>
                                    </div>
                                </div>
                                <div class=" mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select name="admin_id" id="admin_id" class="selectpicker w-100"
                                            data-style="btn-default" multiple data-actions-box="true">
                                            @isset($admins)
                                                @foreach ($admins as $admin)
                                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <label for="admin_id">{{ __('site.Manger') }}</label>
                                    </div>
                                </div>
                                <div class=" mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select name="seller_id" id="seller_id" class="selectpicker w-100"
                                            data-style="btn-default" multiple data-actions-box="true">
                                            @isset($allSellers)
                                                @foreach ($allSellers as $seller)
                                                    <option value="{{ $seller->id }}">
                                                        {{ $seller->first_name . ' ' . $seller->last_name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <label for="seller_id">{{ __('site.Seller') }}</label>
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
        <div class="card_chart_cont  lg:flex ">
            <div class="chart_container mt-4 mx-4 md:mx-6 ">
                <div class="card">
                    <div class="card-header header-elements">
                        <div>
                            <h5 class="card-title mb-0">{{ __('site.Statistics') }}</h5>
                            {{-- <small class="text-muted">Commercial networks and enterprises</small> --}}
                        </div>

                    </div>
                    <div class="card-body pt-2">
                        <canvas id="lineChart" class="lg:w-[500px]" data-height="700"
                            data-chart-leads="{{ json_encode($leads_count) }}"
                            data-chart-orders="{{ json_encode($orders_count) }}"></canvas>
                    </div>
                </div>
            </div>
            <div class="card_container mt-4 mx-auto md:mx-6 grid grid-cols-7 md:grid-cols-8 gap-6  w-full">
                <div class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md">
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            {{ __('site.TotalLeads') }}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div class="bg-green-700 rounded-full text-white px-4 py-2 flex justify-center items-center">
                                <span class="mdi mdi-currency-usd mdi-20px">

                                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{ $leads }}</span>
                        </div>
                    </div>
                </div>
                <div class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md">
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            {{ __('site.ConfirmedLeads') }}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div class="bg-yellow-300 rounded-full text-white px-4 py-2 flex justify-center items-center">
                                <span class="mdi mdi-bus-school mdi-20px">

                                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{ $approvedLeadsCount }}</span>
                        </div>
                    </div>
                </div>
                <div class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md">
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            {{ __('site.DeliveredLeads') }}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div class="bg-red-500 rounded-full text-white px-4 py-2 flex justify-center items-center">
                                <span class="mdi mdi-phone-outline"></span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{ $deliveredLeadsCount }}</span>
                        </div>
                    </div>
                </div>
                <div class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md">
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            {{ __('site.PendingLeads') }}
                        </h2>
                        <div class="flex justify-between items-center">
                            <div class="bg-purple-700 rounded-full text-white px-4 py-2 flex justify-center items-center">
                                <span class="mdi mdi-source-fork mdi-20px">

                                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">{{ $revenue }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rank_chat_cont lg:grid xl:grid-cols-4 mt-12 mb-6">
            <div class="chat_container mt-4 mx-4 md:mx-6 xl:col-span-3 mx-4">
                <div
                    class="chat max-h-[600px] min-h-[600px] bg-white rounded-xl shadow-md flex justify-center items-center">
                    <span class="text-gray-600 text-3xl"> {{ __('site.Chat') }} </span>
                </div>
            </div>
            <div class="ranks_container mt-4 mx-4 md:mx-6 xl:col-span-1 mx-4">
                <div class="sticky top-0 bg-white rounded-t-xl px-4 py-2">
                    <h4 class="text-xl font-bold text-gray-600 capitalize">{{ __('site.Ranking') }}</h4>
                    <hr class="mt-2" />
                </div>

                <div class="rank bg-white rounded-b-xl px-4 pb-4 overflow-y-scroll min-h-[550px]">
                    @foreach ($sellers as $seller)
                        <div class="rank_memeber flex py-2 border-b-2">
                            <div class="img_wrapper ">
                                @if ($seller->revenue > 150000 && $seller->revenue > 75000)
                                    <div class="rank_Avatar relative ">
                                        <!-- rank icon -->
                                        <img src="{{ asset('assets/ranks/Angel-removebg-preview.png') }}" alt="rank_Icon"
                                            class="rank_icon w-20" />
                                        <div class="overflow-hidden rounded-full w-20 h-20 absolute top-0 left-0">
                                            <!-- avatar image -->
                                            <img src="{{ asset('assets/sellers/images/' . $seller->image) }}"
                                                alt="rank_avatar" class="w-full rounded" />
                                        </div>
                                    </div>
                                @elseif($seller->revenue <= 75000 && $seller->revenue > 50000)
                                    <div class="rank_Avatar relative ">
                                        <!-- rank icon -->
                                        <img src="{{ asset('assets/ranks/Wizard.png') }}Wizard.png" alt="rank_Icon"
                                            class="rank_icon w-20" />
                                        <div
                                            class="overflow-hidden rounded-full w-20 h-20 absolute top-0 left-0 img_avtr_size">
                                            <!-- avatar image -->
                                            <img src="{{ asset('assets/sellers/images/' . $seller->image) }}"
                                                alt="rank_avatar" class="w-full h-full object-cover rounded" />
                                        </div>
                                    </div>
                                @elseif($seller->revenue <= 50000 && $seller->revenue > 25000)
                                    <div class="rank_Avatar relative ">
                                        <!-- rank icon -->
                                        <img src="{{ asset('assets/ranks/Knight.png') }}" alt="rank_Icon"
                                            class="rank_icon w-20" />
                                        <div class="overflow-hidden rounded-full w-20 h-20 absolute top-0 left-0"
                                            style="    width: 60px;
                                        height: 60px;
                                        left: 10px;
                                        top: 10px;">
                                            <!-- avatar image -->
                                            <img src="{{ asset('assets/sellers/images/' . $seller->image) }}"
                                                alt="rank_avatar" class="w-full rounded" />
                                        </div>
                                    </div>
                                @elseif($seller->revenue <= 25000 && $seller->revenue > 15000)
                                    <div class="rank_Avatar relative ">
                                        <!-- rank icon -->
                                        <img src="{{ asset('assets/ranks/Villain.png ') }}" alt="rank_Icon"
                                            class="rank_icon w-20" />
                                        <div class="overflow-hidden rounded-full w-20 h-20 absolute top-0 left-0"
                                            style="    width: 60px; height: 60px; left: 10px;  top: 10px;">
                                            <!-- avatar image -->
                                            <img src="{{ asset('assets/sellers/images/' . $seller->image) }}"
                                                alt="rank_avatar" class="w-full rounded" />
                                        </div>
                                    </div>
                                @elseif($seller->revenue <= 15000 && $seller->revenue > 10000)
                                    <div class="rank_Avatar relative ">
                                        <!-- rank icon -->
                                        <img src="{{ asset('assets/ranks/Master.png ') }}" alt="rank_Icon"
                                            class="rank_icon w-20" />
                                        <div
                                            class="overflow-hidden rounded-full w-20 h-20 absolute top-0 left-0 img_avtr_size">
                                            <!-- avatar image -->
                                            <img src="{{ asset('assets/sellers/images/' . $seller->image) }}"
                                                alt="rank_avatar" class="w-full rounded" />
                                        </div>
                                    </div>
                                @elseif($seller->revenue <= 10000 && $seller->revenue > 5000)
                                    <div class="rank_Avatar relative ">
                                        <!-- rank icon -->
                                        <img src=" {{ asset('assets/ranks/Expert.png ') }}" alt="rank_Icon"
                                            class="rank_icon w-20" />
                                        <div class="overflow-hidden rounded-full w-20 h-20 absolute top-0 left-0"
                                            style="width: 70px;
                                                height: 70px;
                                                left: 8px;
                                                top: 3px;">
                                            <!-- avatar image -->
                                            <img src="{{ asset('assets/sellers/images/' . $seller->image) }}"
                                                alt="rank_avatar" class="w-full rounded" />
                                        </div>
                                    </div>
                                @elseif($seller->revenue <= 5000 && $seller->revenue > 2000)
                                    <div class="rank_Avatar relative ">
                                        <!-- rank icon -->
                                        <img src="{{ asset('assets/rank/Elite.png ') }}" alt="rank_Icon"
                                            class="rank_icon w-20" />
                                        <div class="overflow-hidden rounded-full w-20 h-20 absolute top-0 left-0">
                                            <!-- avatar image -->
                                            <img src="{{ asset('assets/sellers/images/' . $seller->image) }}"
                                                alt="rank_avatar" class="w-full rounded" />
                                        </div>
                                    </div>
                                @elseif($seller->revenue <= 2000 && $seller->revenue > 1000)
                                    <div class="rank_Avatar relative ">
                                        <!-- rank icon -->
                                        <img src="{{ asset('assets/rank/Advanced.png ') }}" alt="rank_Icon"
                                            class="rank_icon w-20" />
                                        <div class="overflow-hidden rounded-full w-20 h-20 absolute top-0 left-0">
                                            <!-- avatar image -->
                                            <img src="{{ asset('assets/sellers/images/' . $seller->image) }}"
                                                alt="rank_avatar" class="w-full rounded" />
                                        </div>
                                    </div>
                                @elseif($seller->revenue <= 1000 && $seller->revenue > 500)
                                    <div class="rank_Avatar relative ">
                                        <!-- rank icon -->
                                        <img src="{{ asset('assets/rank/Work.png') }}" alt="rank_Icon"
                                            class="rank_icon w-20" />
                                        <div class="overflow-hidden rounded-full w-20 h-20 absolute top-0 left-0">
                                            <!-- avatar image -->
                                            <img src="{{ asset('assets/sellers/images/' . $seller->image) }}"
                                                alt="rank_avatar" class="w-full rounded" />
                                        </div>
                                    </div>
                                @elseif($seller->revenue <= 500)
                                    <div class="rank_Avatar relative ">
                                        <!-- rank icon -->
                                        <img src="{{ asset('assets/rank/Novice.png') }}" alt="rank_Icon"
                                            class="rank_icon w-20" />
                                        <div class="overflow-hidden rounded-full w-20  h-full absolute top-0 left-0">
                                            <!-- avatar image -->
                                            <img src="{{ asset('assets/sellers/images/' . $seller->image) }}"
                                                alt="rank_avatar" class="w-full h-full object-cover rounded" />
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="member_info">


                                <h4 class="text-sm font-bold text-gray-600 capitalize inline-block">
                                    {{ $seller->first_name }} {{ $seller->last_name }}
                                </h4>

                                <div class="mt-2">
                                    <span class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1">
                                        @if ($seller->revenue > 150000)
                                            ???
                                        @elseif($seller->revenue <= 150000 && $seller->revenue > 75000)
                                            Angel
                                        @elseif($seller->revenue <= 75000 && $seller->revenue > 50000)
                                            Wizard
                                        @elseif($seller->revenue <= 50000 && $seller->revenue > 25000)
                                            Knight
                                        @elseif($seller->revenue <= 25000 && $seller->revenue > 15000)
                                            Villain
                                        @elseif($seller->revenue <= 15000 && $seller->revenue > 10000)
                                            Master
                                        @elseif($seller->revenue <= 10000 && $seller->revenue > 5000)
                                            Expert
                                        @elseif($seller->revenue <= 5000 && $seller->revenue > 2000)
                                            Elite
                                        @elseif($seller->revenue <= 2000 && $seller->revenue > 1000)
                                            Advanced
                                        @elseif($seller->revenue <= 1000 && $seller->revenue > 500)
                                            Worker
                                        @elseif($seller->revenue <= 500 && $seller->revenue > 100)
                                            Novice
                                        @endif

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

    <!-- Page JS -->
    <script src="{{ asset('assets/js/app-chat.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/chartjs/chartjs.js') }}"></script>

    <!-- ********************** -->

    <!-- build:js assets/vendor/js/core.js -->


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

    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/forms-pickers.js') }}"></script>
    <script>
        // Color Variables
        const yellowColor = '#ffe800'
        const cardColor = '#fff'
        const headingColor = '#696969'
        const textColor = '#999'
        const labelColor = '#b5b5b5'
        const legendColor = '#b5b5b5'

        let borderColor, gridColor, tickColor;
        if (isDarkStyle) {
            borderColor = 'rgba(100, 100, 100, 1)';
            gridColor = 'rgba(100, 100, 100, 1)';
            tickColor = 'rgba(255, 255, 255, 0.75)'; // x & y axis tick color
        } else {
            borderColor = '#f0f0f0';
            gridColor = '#f0f0f0';
            tickColor = 'rgba(0, 0, 0, 0.75)'; // x & y axis tick color
        }
        const lineChart = document.getElementById('lineChart');
        const dataChartLeads = document.getElementById("lineChart").getAttribute("data-chart-leads")
        const dataChartOrder = document.getElementById("lineChart").getAttribute("data-chart-orders")
        const dataLeads = JSON.parse(dataChartLeads);
        const dataOrders = JSON.parse(dataChartOrder);

        if (lineChart) {
            const lineChartVar = new Chart(lineChart, {
                type: 'line',
                data: {
                    labels: dataLeads.map(row => row.date),
                    datasets: [{
                            label: 'Leads',
                            data: dataLeads.map(row => row.count)
                        },
                        {
                            label: 'Orders',
                            data: dataOrders.map(row => row.count)
                        }
                    ]
                }

            });
        }
    </script>
@endsection
