@extends('layouts.master')

@section('title')
    {{ __('site.Roles') }}
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="bs-toast toast toast-ex animate__animated my-2 fade animate__tada hide" role="alert"
            aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
            <div class="toast-header">
                <i class="ti ti-bell ti-xs me-2 text-primary"></i>
                <div class="me-auto fw-medium">Alert</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">{{ $message }}</div>
        </div>
    @endif
    <!-- Multilingual -->
    <div class="card">
        <h5 class="card-header">{{ __('site.Roles') }}</h5>
        <div class="card-body">
            <div class="table-responsive">
                <table id="em_data" class="display table table-bordered" style="width:100%">

                    <thead>
                        <tr>
                            <th>#{{ __('site.ID') }}</th>
                            <th> {{ __('site.Name') }}</th>
                            <th class="text-center">{{ __('site.Actions') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                            @if ($role->name !== 'Owner')
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $role->name }}</td>

                                    <td class="text-center">
                                        @can('Show Role')
                                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> {{ __('site.Show') }}
                                            </a>
                                        @endcan
                                        @can('Edit Role')
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-edit"></i> {{ __('site.Edit') }}
                                            </a>
                                        @endcan
                                        @can('Delete Role')
                                            <a href="javascript:;" class="btn btn-sm btn-danger sa-delete"
                                                data-from-id="role-delete-{{ $role->id }}">
                                                <i class="fa fa-trash"></i> {{ __('site.Delete') }}
                                            </a>
                                        @endcan


                                        <form id="role-delete-{{ $role->id }}"
                                            action="{{ route('roles.destroy', $role->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </td>

                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Multilingual -->
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
    <script src="{{ asset('assets/addProduct/affiliateProduct.js') }}"></script>
    {{--    <script src="{{ asset('assets/productjs/stock.js') }}"></script> --}}

    {{--    <script src="{{asset('assets/js/forms-extras.js')}}"></script> --}}
@endsection


@endsection
