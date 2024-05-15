@extends('layouts.master')


@section('title')
    {{ __('site.Dashboard') }}
@endsection


@section('css')
    <script src="https://cdn.tailwindcss.com"></script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">{{ __('site.Admin') }} /</span> {{ __('site.Dashboard') }}
        </h4>
        <div class="card_chart_cont  lg:grid xl:grid-cols-4">
            <div class="chart_container mt-4 mx-4 md:mx-6 xl:col-span-2">
                <div
                    class="chart h-[400px] w-full lg:min-w-[600px] bg-white rounded-xl shadow-md flex justify-center items-center"
                >
                    <span class="text-gray-600 text-3xl">chart.js placeholder</span>
                </div>
            </div>
            <div
                class="card_container mt-4 mx-auto md:mx-6 grid grid-cols-7 md:grid-cols-8 gap-6 xl:col-span-2 w-full"
            >
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            Total Leads
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-green-700 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-currency-usd mdi-20px">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">12</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            Total Leads
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-yellow-300 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-bus-school mdi-20px">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">12</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            Total Leads
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-red-500 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                                <span class="mdi mdi-phone-outline"></span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">12</span>
                        </div>
                    </div>
                </div>
                <div
                    class="card bg-white px-6 py-8 rounded-xl col-span-5 md:col-span-4 col-start-2 shadow-md"
                >
                    <div class="flex flex-col gap-10 h-full">
                        <h2 class="text-md text-gray-800 font-bold uppercase">
                            Total Leads
                        </h2>
                        <div class="flex justify-between items-center">
                            <div
                                class="bg-purple-700 rounded-full text-white px-4 py-2 flex justify-center items-center"
                            >
                <span class="mdi mdi-source-fork mdi-20px">

                </span>
                            </div>
                            <span class="text-gray-600 text-3xl font-bold">12</span>
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
                    <span class="text-gray-600 text-3xl"> Chat placeholder </span>
                </div>
            </div>
            <div class="ranks_container mt-4 mx-4 md:mx-6 xl:col-span-1 mx-4">
                <div class="sticky top-0 bg-white rounded-t-xl px-4 py-2">
                    <h4 class="text-xl font-bold text-gray-600 capitalize">Ranking</h4>
                    <hr class="mt-2" />
                </div>
                <div
                    class="rank bg-white rounded-b-xl px-4 pb-4 overflow-y-scroll max-h-[550px]"
                >
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
                    <div class="rank_memeber flex py-2 border-b-2">
                        <div class="img_wrapper">
                            <img
                                src="./images/mega_sale.jpg"
                                alt="avatar"
                                class="w-12 h-12 rounded-full object-cover mr-4 mt-2 shadow"
                            />
                        </div>
                        <div class="member_info">
                            <h4 class="text-sm font-bold text-gray-600 capitalize">
                                Member Name
                            </h4>
                            <div class="mt-2">
                <span
                    class="text-gray-600 text-sm bg-green-400 rounded-md text-white px-2 py-1"
                >
                  Rank
                </span>
                            </div>
                        </div>
                    </div>
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
