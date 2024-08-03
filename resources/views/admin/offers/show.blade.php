@extends('layouts.master')


@section('title')
    {{ $offer->title }}
@endsection


@section('css')
    <script src="https://cdn.tailwindcss.com"></script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">{{ __('site.Dashboard') }} /</span> {{ __('site.Show') }}</h4>

        {{--        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-8 gap-4 p-4"> --}}
        {{--            <div class="product-card col-span-8 lg:col-span-3 py-2 px-4 rounded-md drop-shadow card_bg"> --}}
        {{--                <div class="product-img flex mb-4"> --}}
        {{--                    <img src="{{ asset('assets/offers/images/' . $offer->image) }}" alt="offerImage" --}}
        {{--                        class="w-full h-full object-cover" /> --}}
        {{--                </div> --}}
        {{--                <div style="display: flex; gap: 6px;"> --}}
        {{--                    <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-primary waves-effect waves-light"> --}}

        {{--                        {{ __('site.Edit') }}</a> --}}
        {{--                    <form action="{{ route('offers.destroy', $offer->id) }}" method="POST"> --}}
        {{--                        @csrf --}}
        {{--                        @method('DELETE') --}}
        {{--                        <button type="submit" class="btn btn-danger waves-effect waves-light"> --}}
        {{--                            {{ __('site.Delete') }} --}}
        {{--                        </button> --}}
        {{--                    </form> --}}
        {{--                </div> --}}
        {{--            </div> --}}
        {{--            <div class="product-disc col-span-8 lg:col-span-5 card_bg rounded-md drop-shadow"> --}}
        {{--                <div class="py-8 px-4"> --}}
        {{--                    <h3 class="text-2xl font-bold">{{ $offer->title }}</h3> --}}
        {{--                </div> --}}
        {{--                <hr /> --}}
        {{--                <div class="px-2"> --}}

        {{--                    <div class="py-6 px-2"> --}}
        {{--                        <h3 class="text-md font-bold mb-4">{{ __('site.Details') }}:</h3> --}}
        {{--                        <div class="flex flex-col gap-2 lg:items-start"> --}}

        {{--                            <div class="flex items-center"> --}}
        {{--                                <h3 class="text-md  lg:text-xl font-bold mr-6 lg:mr-2"> --}}
        {{--                                    {{ __('site.StartDate') }}: --}}
        {{--                                </h3> --}}
        {{--                                <span class="text-black">{{ $offer->start_date }}</span> --}}
        {{--                            </div> --}}
        {{--                            <div class="flex items-center"> --}}
        {{--                                <h3 class="text-md  lg:text-xl font-bold mr-6 lg:mr-2"> --}}
        {{--                                    {{ __('site.EndDate') }}: --}}
        {{--                                </h3> --}}
        {{--                                <span class="text-black">{{ $offer->end_date }}</span> --}}
        {{--                            </div> --}}
        {{--                        </div> --}}
        {{--                    </div> --}}
        {{--                    <hr /> --}}
        {{--                </div> --}}
        {{--            </div> --}}

        {{--            <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4"> --}}
        {{--                <h3 class="text-xl font-bold mb-4"> {{ __('site.Description') }}</h3> --}}
        {{--                <p class=" text-pretty"> --}}
        {{--                    {{ $offer->description }} --}}
        {{--                </p> --}}
        {{--            </div> --}}
        {{--        </div> --}}

        <div class="w-full">
            <div class="p-4 sm:p-6 lg:p-8 rounded-xl overflow-hidden drop-shadow-md">
                <div style="background-image: url({{ asset('assets/offers/images/' . $offer->image) }})"
                    class="rounded-xl relative aspect-square md:aspect-[2.4/1] overflow-hidden bg-cover">
                    <div
                        class="h-full w-full flex flex-col justify-center items-center text-center gap-y-8 rounded-xl bg-black/5 backdrop-filter backdrop-blur-sm">
                        <div class="font-bold text-3xl sm:text-5xl lg:text-6xl sm:max-w-xl max-w-xs capitalize text-white">
                            {{ $offer->title }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 sm:m-6 lg:m-8 card_bg rounded-xl drop-shadow-md">
                <h2 class="my-2 text-2xl font-bold">{{ __('site.Description') }}</h2>
                <hr class="bg-black mb-4 h-[1px]" />
                <p class="text-pretty">
                    {{ $offer->description }}
                </p>
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
    <script>
        function confirmDelete() {
            return confirm("This product is related to other fields. Are you sure you want to delete this product?");
        }
    </script>
    <script>
        document.getElementById("copySku").addEventListener("click", function() {
            const copyText = document.getElementById("sku").innerText;
            navigator.clipboard.writeText(copyText);
            alert("SKU Copied");
        })
    </script>
@endsection
