@extends('layouts.seller.master')


@section('title')
    {{ __('site.AfillatePerConfirmed') }}
@endsection


@section('css')
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" --}}
    {{--        integrity="sha512-c5dyc+3ht10w+7s6OfBxHwZZkm5A+qLmLaB+pa3RFsKcOCme7/uBv2mtUfFjS+2b2q5j//BXJsW0sB2EhfaR6A==" --}}
    {{--        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}" />
    <link href="https://unpkg.com/tailwindcss@^2.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .accordion-button {
            width: 0% !important;
        }

        .ribbon {
            z-index: 999;
            width: 210px;
            top: 30px;
            right: -55px;
            height: 25px;
        }

        .top\-\[-18px\] {
            top: -18px !important;
        }

        .right\-\[-20px\] {
            right: -20px !important;
        }
    </style>
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ __('site.Dashboard') }} /</span>
            {{ __('site.AfillatePerConfirme') }}</h4>
        @if (session()->has('Add'))
            <div class="alert alert-success" role="alert">{{ session()->get('Add') }}</div>
        @endif
        @if (session()->has('Update'))
            <div class="alert alert-primary" role="alert">{{ session()->get('Update') }}</div>
        @endif
        @if (session()->has('Delete'))
            <div class="alert alert-danger" role="alert">{{ session()->get('Delete') }}</div>
        @endif
        @if (session()->has('Warning'))
            <div class="alert alert-warning" role="alert">{{ session()->get('Warning') }}</div>
        @endif
        <div class="flex flex-col gap-6">
            @isset($offer)
                @if ($offer->isNotEmpty())
                    <div class="bg-gray-200">
                        <div class="">
                            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                                {{-- <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active"
                                        aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1"
                                        aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2"
                                        aria-label="Slide 3"></button>
                                </div> --}}
                                <div class="carousel-inner" style="height:150px;">
                                    @foreach ($offer as $info)
                                        <div class="carousel-item active" style="max-height:150px;">
                                            <a href="{{ $info->url ?? '#' }}" target="_blank">
                                                <img class="d-block w-100"
                                                    src="{{ asset('assets/offers/images/' . $info->image) }}"
                                                    style="max-height: 150px;object-fit: cover;" alt="First slide" />
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endisset
            <div class="col-md mb-4 mb-md-2">
                <div class="accordion mt-3" id="accordionWithIcon">
                    <div class="accordion-item p-3">

                        <div>

                            <div class="flex flex-col lg:flex-row gap-3">
                                <a class="hover:border-b-4 hover:border-purple-700 flex gap-2 items-center justify-center"
                                    href="{{ route('seller.affiliate.per.confirmed') }}">
                                    <i class="mdi mdi-select-all"></i>
                                    {{ __('site.AllProducts') }}
                                </a>
                                <a class="hover:border-b-4 hover:border-purple-700 flex gap-2 items-center justify-center"
                                    href="{{ route('seller.new.affiliate.per.confirmed') }}">
                                    <i class="mdi mdi-new-box"></i>
                                    {{ __('site.NewProducts') }}
                                </a>
                                <a class="hover:border-b-4 hover:border-purple-700 flex gap-2 items-center justify-center"
                                    href="{{ route('seller.suggested.affiliate.per.confirmed') }}">
                                    <i class="mdi mdi-rocket-launch-outline"></i>
                                    {{ __('site.SuggestedProducts') }}
                                </a>


                                <button type="button" class="accordion-button collapsed m-auto" data-bs-toggle="collapse"
                                    data-bs-target="#accordionWithIcon-1" aria-expanded="false">
                                </button>
                            </div>

                        </div>

                        <div id="accordionWithIcon-1" class="accordion-collapse collapse" style="">
                            <div class="accordion-body">
                                <form id="formAuthentication" class="flex flex-col lg:flex-row gap-3"
                                    action="{{ route('seller.search.affiliate.per.confirmed') }}" method="post">
                                    @csrf
                                    <div class="form-floating form-floating-outline mb-3 col ">
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="Enter your product title" autofocus />
                                        <label for="title"> {{ __('site.Title') }}</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-3 col">
                                        <input type="text" class="form-control" id="sku" name="sku"
                                            placeholder="Enter your product sku" autofocus />
                                        <label for="sku"> {{ __('site.SKU') }}</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-3 col">
                                        <select class="form-select form-select-lg country" name="category_id">
                                            <option value="">{{ __('site.SelectCategory') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="country"> {{ __('site.Category') }}</label>
                                    </div>

                                    <button class="btn btn-primary mb-3 col" type="submit">
                                        {{ __('site.Search') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="card_bg drop-shadow h-full p-4 rounded-md flex gap-6">
                <a class="hover:border-b-4 hover:border-purple-700 flex gap-2 items-center justify-center"
                    href="{{ route('seller.affiliate.per.confirmed') }}">
                    <i class="menu-icon tf-icons mdi mdi-earth"></i>
                    {{ __('site.AllCountries') }}
                </a>


                @isset($countries)
                    @foreach ($countries as $country)
                        <a class="hover:border-b-4 hover:border-purple-700 flex gap-2 items-center justify-center"
                            href="{{ route('seller.affiliate.per.confirmed.country.filter', $country->id) }}">
                            <img src="{{ asset('assets/countries/flags/' . $country->flag) }}" alt="{{ $country->name }}"
                                width="40" height="40">
                            <span>{{ $country->name }}</span></a>
                    @endforeach
                @endisset
            </div>
            <div
                class="card_bg drop-shadow h-full p-4 rounded-md grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 justify-items-center">

                @if ($products->isEmpty())
                    <div class="px-4 py-4 text-center ">{{ __('site.NoProducts') }}</div>
                @endif
                @isset($products)
                    @foreach ($products as $product)
                        <div
                            class="flex flex-col group rounded-md bg-gray-50 drop-shadow hover:border-2 hover:border-purple-700 relative overflow-hidden">
                            <div class="absolute right-[-20px] top-[-18px] h-16 w-16">
                                <div
                                    class="absolute transform rotate-45 bg-purple-700 text-xs text-center text-white font-semibold py-1 ribbon capitalize">
                                    confirmed
                                </div>
                            </div>

                            <div class="relative grow">
                                <div
                                    class="absolute w-full h-full bg-black opacity-0 ease-in-out duration-300 group-hover:opacity-40">
                                </div>
                                <img class="w-full h-full object-cover"
                                    src="{{ asset('assets/products/affiliateproduct/images/' . $product->image) }}"
                                    alt="..."
                                    onerror="this.onerror=null;this.src='https://app.codpartner.com/images/no_image_found.jpg';" />
                            </div>

                            <div class="relative">
                                <a href="{{ route('seller.affiliateproduct.show', $product->id) }}"
                                    class="absolute opacity-0 top-[-60px] left-[-50%] group-hover:left-0 group-hover:!opacity-100 bg-purple-700 text-white p-2 rounded-tr-xl rounded-br-xl ease-out duration-100"
                                    target="_blank">
                                    <i class="far fa-eye"></i> <b> {{ __('site.ViewDetails') }} </b>
                                </a>
                            </div>

                            <div class="p-2">
                                <a href="{{ route('seller.affiliateproduct.show', $product->id) }}" target="_blank">
                                    <h6 class="text-purple-900 line-clamp-1">{{ $product->title }}</h6>
                                </a>
                                <div class="d-flex gap-2 my-2" style="grid-row-gap: 0.3rem; grid-column-gap: 0.3rem">
                                    @foreach ($product->affiliatecountries as $country)
                                        <span class="rounded-md font-bold text-sm">
                                            <img src="{{ asset('assets/countries/flags/' . $country->flag) }}" width="35"
                                                height="35">
                                        </span>
                                    @endforeach
                                </div>
                                <div>
                                    <div class="text-primary">
                                        <b>${{ $product->commission }}</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
            {{ $products->links() }}
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
