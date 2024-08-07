@extends('layouts.master')


@section('title')
    {{ __('site.EditSharedProduct') }}
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/excel/ejexcelMaster.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/desc/summernote.min.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>



    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
@endsection
@section('popup')
    <div id="overlay"></div>
    <div id="customPopup">
        <div class="x-error">
            <span>x</span>
        </div>
        <h3> {{ __('site.Error') }}!</h3>
        <p id="popupContent"></p>
        <button id="closePopup"> {{ __('site.Close') }}</button>
    </div>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"> {{ __('site.Dashboard') }} /</span>
            {{ __('site.CreateSharedProduct') }}</h4>
        <div class="app-ecommerce">
            <!-- Add Product -->
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1 mt-3">{{ __('site.AddanewProduct') }}</h4>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-3">

                    <button type="submit" class="btn btn-primary" id="route"
                        data-route="{{ route('admin.sharedproducts.update', $product->id) }}">
                        {{ __('site.PublishProduct') }}</button>
                </div>
            </div>
            <div class="row">
                <!-- First column-->
                <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">{{ __('site.ProductInformation') }}</h5>
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" name="title" class="form-control" id="ecommerce-product-name"
                                    placeholder="Product title" name="productTitle" aria-label="Product title"
                                    value="{{ $product->title }}" />
                                <label for="ecommerce-product-name"> {{ __('site.Title') }}</label>
                            </div>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="ecommerce-product-sku"
                                            placeholder="00000" name="sku" aria-label="Product SKU"
                                            value="{{ $product->sku }}" />
                                        <label for="ecommerce-product-sku"> {{ __('site.SKU') }}</label>
                                    </div>
                                </div>
                                @error('sku')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                                <div class="col">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="brand" placeholder="0123-4567"
                                            name="brand" aria-label="Product brand" value="{{ $product->brand }}" />
                                        <label for="brand"> {{ __('site.Brand') }}</label>
                                    </div>
                                </div>
                                @error('brand')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="file" name="image" id="image" class="form-control" />
                                <label for="image"> {{ __('site.Image') }}</label>

                            </div>
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <!-- Comment -->

                            <div id="summernote">{!! $product->description !!}</div>
                            {{-- <div>
                                <label class="form-label"> {{ __('site.Description') }}</label>
                                <div class="form-control p-0 pt-1" id="data-desc"
                                    data-desc="{{ $product->description }}">
                                    <div class="comment-toolbar border-0 border-bottom">
                                        <div class="d-flex justify-content-start">
                                            <span class="ql-formats me-0">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                                <button class="ql-list" value="ordered"></button>
                                                <button class="ql-list" value="bullet"></button>
                                                <button class="ql-link"></button>
                                                <button class="ql-image"></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="comment-editor border-0 pb-1" id="ecommerce-category-description"></div>
                                </div>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            {{--                            @foreach ($product->sharedcountries as $sharedCountry) --}}
                            {{--                                <div id="stock_container" data-country="{{ $countries }}"> --}}
                            {{--                                    <div class="row mb-4 mt-4"> --}}
                            {{--                                        <div class="col"> --}}
                            {{--                                            <div class="form-floating form-floating-outline"> --}}
                            {{--                                                <select class="form-select form-select-lg country" name="country[]"> --}}
                            {{--                                                    <option value="{{ $sharedCountry->pivot->country_id }}"> --}}
                            {{--                                                        {{ $sharedCountry->name }}</option> --}}
                            {{--                                                    @foreach ($countries as $country) --}}
                            {{--                                                        <option value="{{ $country->id }}">{{ $country->name }}</option> --}}
                            {{--                                                    @endforeach --}}
                            {{--                                                    <!-- Accessing the name of the country via pivot --> --}}
                            {{--                                                </select> --}}
                            {{--                                                <label for="country"> {{ __('site.Country') }}</label> --}}
                            {{--                                            </div> --}}
                            {{--                                        </div> --}}
                            {{--                                        <div class="col"> --}}
                            {{--                                            <div class="form-floating form-floating-outline mb-4"> --}}
                            {{--                                                <input type="number" class="form-control" id="Stock" --}}
                            {{--                                                    placeholder="Stock" name="stock[]" --}}
                            {{--                                                    aria-label="Product discounted price" --}}
                            {{--                                                    value="{{ $sharedCountry->pivot->stock }}" /> --}}
                            {{--                                                <label for="Stock"> {{ __('site.Stock') }}</label> --}}
                            {{--                                            </div> --}}
                            {{--                                        </div> --}}
                            {{--                                    </div> --}}
                            {{--                                </div> --}}
                            {{--                            @endforeach --}}


                            {{--                            <button id="addstock" class="btn rounded-pill btn-outline-primary waves-effect"> --}}
                            {{--                                {{ __('site.Add') }}</button> --}}

                            <!-- Form Repeater -->
                            <div class="col-12">
                                <div class="card">
                                    <h5 class="card-header">{{ __('site.Country') }}</h5>
                                    <div class="card-body">
                                        <form class="form-repeater">
                                            <div data-repeater-list="group-a">
                                                @foreach ($product->sharedcountries as $sharedCountry)
                                                    <div data-repeater-item>
                                                        <div class="row">
                                                            <div class="mb-3 col-lg-6 col-xl-4 col-12 mb-0">
                                                                <div class="form-floating form-floating-outline">
                                                                    <select id="form-repeater-1-4"
                                                                        class="form-select country" name="country[]">
                                                                        <option
                                                                            value="{{ $sharedCountry->pivot->country_id }}">
                                                                            {{ $sharedCountry->name }}</option>
                                                                        @foreach ($countries as $country)
                                                                            <option value="{{ $country->id }}">
                                                                                {{ $country->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label
                                                                        for="form-repeater-1-4">{{ __('site.Country') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 col-lg-6 col-xl-4 col-12 mb-0">
                                                                <div class="form-floating form-floating-outline">
                                                                    <input type="number" name="stock[]"
                                                                        class="form-control stock"
                                                                        placeholder="{{ __('site.Stock') }}"
                                                                        value="{{ $sharedCountry->pivot->stock }}" />
                                                                    <label for="Stock">{{ __('site.Stock') }}</label>
                                                                </div>
                                                            </div>


                                                            <div
                                                                class="mb-3 col-lg-12 col-xl-2 col-12 d-flex align-items-center mb-0">
                                                                <button class="btn btn-outline-danger"
                                                                    data-repeater-delete>
                                                                    <i class="mdi mdi-close me-1"></i>
                                                                    <span class="align-middle">Delete</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mb-0">
                                                <button class="btn btn-primary" data-repeater-create>
                                                    <i class="mdi mdi-plus me-1"></i>
                                                    <span class="align-middle">Add</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /Form Repeater -->
                        </div>
                    </div>
                    <!-- /Product Information -->


                </div>
                <!-- /Second column -->

                <!-- Second column -->
                <div class="col-12 col-lg-4">
                    <!-- Pricing Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"> {{ __('site.Pricing') }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Unit Cost -->
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" step="0.01" class="form-control" id="Unit Cost"
                                    placeholder="Unit Cost" name="unit_cost" aria-label="Product Unit Cost"
                                    value="{{ $product->unit_cost }}" />
                                <label for="Unit Cost">{{ __('site.UnitCost') }}</label>
                            </div>
                            @error('unit_cost')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <!-- Recommended Pricee -->
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" step="0.01" class="form-control" id="Recommended Price"
                                    placeholder="Recommended Price" name="recommended_price"
                                    aria-label="Product discounted price" value="{{ $product->recommended_price }}" />
                                <label for="Recommended Price">{{ __('site.RecommendedPrice') }}</label>
                            </div>
                            @error('recommended_price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <!-- Weight -->
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" step="0.001" class="form-control" id="weight"
                                    placeholder="weight" name="weight" aria-label="Product weight"
                                    value="{{ $product->weight }}" />
                                <label for="weight"> {{ __('site.Weight') }}</label>
                            </div>
                            @error('weight')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror


                        </div>
                    </div>
                    <!-- /Pricing Card -->
                    <!-- Organize Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"> {{ __('site.Organize') }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Category -->
                            <div class="mb-4 col ecommerce-select2-dropdown">
                                <div class="form-floating form-floating-outline w-100 me-3">
                                    <select id="category-org" class="select2 form-select" name="category_id"
                                        data-placeholder="Select Category">
                                        <option value="{{ $product->shared_category->id }}">
                                            {{ $product->shared_category->name }}</option>
                                        </option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="category-org"> {{ __('site.Category') }}</label>
                                </div>
                            </div>

                            @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- /Organize Card -->
                </div>
                <!-- /Second column -->
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
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/app-ecommerce-product-add.js') }}"></script>
    <script src="{{ asset('assets/addProduct/sharedProductEdit.js') }}"></script>
    <script src="{{ asset('assets/productjs/stock.js') }}"></script>
    <script src="{{ asset('assets/desc/summernote.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection
