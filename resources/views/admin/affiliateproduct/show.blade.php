@extends('layouts.master')


@section('title')
    {{ $product->title }}
@endsection


@section('css')
    <script src="https://cdn.tailwindcss.com"></script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">{{ __('site.Dashboard') }} /</span> {{ __('site.Show') }}</h4>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-8 gap-4 p-4">
            <div class="product-card col-span-8 lg:col-span-3 py-2 px-4 rounded-md drop-shadow card_bg">
                <div class="product-img flex mb-4">
                    <img src="{{ asset('assets/products/affiliateproduct/images/' . $product->image) }}" alt=""
                        class="w-full h-full object-cover" />
                </div>
                <div style="display: flex; gap: 6px;">
                    @can('Edit Affiliate Product')
                        <a href="{{ route('affiliate-products.edit', $product->id) }}"
                            class="btn btn-primary waves-effect waves-light">

                            {{ __('site.Edit') }}</a>
                    @endcan
                    @can('Delete Affiliate Product')
                        <form action="{{ route('affiliate-products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger waves-effect waves-light">
                                {{ __('site.Delete') }}
                            </button>
                        </form>
                    @endcan

                </div>
            </div>
            {{-- <div class="product-disc col-span-8 lg:col-span-5 card_bg rounded-md drop-shadow">
                <div class="py-8 px-4">
                    <h3 class="text-2xl font-bold">{{ $product->title }}</h3>
                </div>
                <hr />
                <div class="px-2">
                    <div class="py-6 px-2 flex flex-col lg:flex-row gap-2 lg:gap-12 lg:items-center ">
                        <div class="flex items-center">
                            <h3 class="text-md  lg:text-xl font-bold mr-1">
                                {{ __('site.minimumsellingprice') }}:
                            </h3>
                            <span class="text-green-600">{{ $product->minimum_selling_price }}$</span>
                        </div>
                        <div class="flex items-center">
                            <h3 class="text-md  lg:text-xl font-bold mr-1">
                                {{ __('site.Commission') }}:
                            </h3>
                            <span class="text-green-600">{{ $product->commission }}$</span>
                        </div>
                    </div>
                    <hr />
                    <div class="py-6 px-2">
                        <h3 class="text-md font-bold mb-4">{{ __('site.Specifications') }}:</h3>
                        <div class="flex flex-col gap-2 lg:items-start">
                            <div class="flex items-center">
                                <h3 class="text-md  lg:text-xl font-bold mr-6 lg:mr-2">
                                    {{ __('site.SKU') }}:
                                </h3>
                                <span class="text-white bg-violet-500 px-3 py-1 rounded hover:bg-violet-600"
                                    id="sku">{{ $product->sku }}
                                    <i class="mdi mdi-content-copy ml-2 cursor-pointer text-white text-xl "
                                        id="copySku"></i>
                                </span>
                            </div>
                            <div class="flex items-center">
                                <h3 class="text-md  lg:text-xl font-bold mr-6 lg:mr-2">
                                    {{ __('site.Brand') }}:
                                </h3>
                                <span class="">{{ $product->brand }}</span>
                            </div>
                            <div class="flex items-center">
                                <h3 class="text-md  lg:text-xl font-bold mr-6 lg:mr-2">
                                    {{ __('site.Weight') }}:
                                </h3>
                                <span class="">{{ $product->weight }} KG</span>
                            </div>
                        </div>
                    </div>
                    <hr />
                </div>
            </div> --}}

            <div class="product-disc col-span-8 lg:col-span-5 card_bg rounded-md drop-shadow">
                <div class="py-8 px-4">
                    <h3 class="text-2xl font-bold">{{ $product->title }}</h3>
                </div>
                <hr />
                <div class="px-2">
                    <div class="py-6 px-2 flex flex-col lg:flex-row gap-2 lg:gap-12 lg:items-center">
                        <div class="flex items-center">
                            <h3 class="text-md  lg:text-xl font-bold mr-1">
                                {{ __('site.minimumsellingprice') }}:
                            </h3>
                            <span class="text-green-600 text-xl">{{ $product->minimum_selling_price }}$</span>
                        </div>
                        <div class="flex items-center">
                            <h3 class="text-md  lg:text-xl font-bold mr-1">
                                {{ __('site.Commission') }}:
                            </h3>
                            <span class="text-green-600 text-xl">{{ $product->commission }}$</span>
                        </div>
                    </div>
                    <hr />
                    <div class="py-6 px-2">
                        <h3 class="text-md font-bold mb-4"> {{ __('site.Specifications') }}:</h3>
                        <div class="flex flex-col gap-2 lg:items-start">
                            <div class="flex items-center">
                                <h3 class="text-md  lg:text-xl font-bold mr-6 lg:mr-2">
                                    {{ __('site.SKU') }}:
                                </h3>
                                <span class="text-white bg-violet-500 px-3 py-1 rounded hover:bg-violet-600"
                                    id="sku">{{ $product->sku }}
                                    <i class="mdi mdi-content-copy ml-2 cursor-pointer text-white text-xl "
                                        id="copySku"></i>
                                </span>
                            </div>
                            <div class="flex items-center">
                                <h3 class="text-md  lg:text-xl font-bold mr-6 lg:mr-2">
                                    {{ __('site.Brand') }}:
                                </h3>
                                <span class="">{{ $product->brand }}</span>
                            </div>
                            <div class="flex items-center">
                                <h3 class="text-md  lg:text-xl font-bold mr-6 lg:mr-2">
                                    {{ __('site.Weight') }}:
                                </h3>
                                <span class="">{{ $product->weight }} KG</span>
                            </div>
                        </div>
                    </div>
                    <hr />
                </div>
            </div>
            <!-- But Table hre -->
            <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>{{ __('site.Warehouse') }}</th>
                            <th>{{ __('site.minimumsellingprice') }}</th>
                            <th>{{ __('site.Commission') }}</th>

                            <th> {{ __('site.Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($product->affiliatecountries as $country)
                            <tr>

                                <td><img src="{{ asset('assets/countries/flags/' . $country->flag) }}" width="50"
                                        height="50"></td>
                                <td>${{ $product->minimum_selling_price }}</td>
                                <td>${{ $product->commission }}</td>

                                <td>

                                    @if ($country->pivot->stock >= 20)
                                        <span class="badge rounded-pill bg-success"> {{ __('site.AvailableNow') }} </span>
                                    @elseif ($country->pivot->stock < 20 && $country->pivot->stock >= 10)
                                        <span class="badge rounded-pill bg-primary"> {{ __('site.MediumStock') }} </span>
                                    @elseif($country->pivot->stock < 10 && $country->pivot->stock >= 1)
                                        <span class="badge rounded-pill bg-warning"> {{ __('site.LowStock') }} </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger"> {{ __('site.OutOfStock') }} </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- But Table hre -->

            <div class="col-span-8 card_bg drop-shadow rounded-md px-4 py-4">
                <h3 class="text-xl font-bold mb-4"> {{ __('site.Description') }}</h3>
                <p class=" text-pretty">
                    {!! $product->description !!}
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
