@extends('layouts.master')


@section('title')
    {{ __('site.Edit') }}-{{ $offer->title }}
@endsection


@section('css')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">{{ __('site.Dashboard') }}/</span>
            {{ __('site.EditOffer') }} </h4>
        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0"> {{ __('site.Offer') }}</h5>
                    </div>
                    <div class="card-body">
                        <form class="flex flex-col gap-6" action="{{ route('offers.update', $offer->id) }} "
                            enctype="multipart/form-data" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label"
                                    for="basic-default-name">{{ __('site.Title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="basic-default-name" name="title"
                                        placeholder="{{ __('site.Title') }}" value="{{ old('title', $offer->title) }}" />
                                </div>
                            </div>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">
                                    {{ __('site.Image') }}</label>
                                <div class="col-sm-10">
                                    <input type="file" step="0.01" class="form-control" id="basic-default-company"
                                        name="image" placeholder="{{ __('site.Image') }}" />
                                </div>
                            </div>
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">
                                    {{ __('site.StartDate') }}</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="basic-default-name" name="start_date"
                                        placeholder="{{ __('site.StartDate') }}"
                                        value="{{ old('start_date', $offer->start_date) }}" />
                                </div>
                                @error('start_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">
                                    {{ __('site.EndDate') }}</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="basic-default-name" name="end_date"
                                        placeholder="{{ __('site.EndDate') }}"
                                        value="{{ old('end_date', $offer->end_date) }}" />
                                </div>
                                @error('end_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="url">
                                    {{ __('site.Url') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" id="url" class="form-control" name="url"
                                        placeholder="{{ __('site.Url') }}" value="{{ old('url', $offer->url) }}" />
                                </div>
                                @error('url')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary"> {{ __('site.Update') }}</button>
                                </div>
                            </div>
                        </form>
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
