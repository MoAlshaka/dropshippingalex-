@extends('layouts.master')

@section('title')
    {{ __('site.Admins') }}
@endsection
@section('content')
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Admins</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="em_data" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Start At</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($users)
                                    @foreach ($users as $key => $user)
                                        {{-- Skip users with the role "Owner" --}}
                                        {{-- @if ($user->roles_name !== 'Owner') --}}
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name ?? '' }}</td>
                                            <td>{{ $user->username ?? '' }}@if (auth()->id() == $user->id)
                                                    (You)
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn rounded-pill btn-primary waves-effect waves-light">{{ $user->roles_name ?? '' }}</button>
                                            </td>

                                            <td>{{ $user->created_at->format('Y-m-d') ?? '' }}</td>
                                            <td>
                                                @if ($user->status == 1)
                                                    <button type="button"
                                                        class="btn rounded-pill btn-success waves-effect waves-light">Enabled</button>
                                                @else
                                                    <button type="button"
                                                        class="btn rounded-pill btn-danger waves-effect waves-light">Disabled</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @can('Edit Admin')
                                                    <a href="{{ route('admins.edit', $user->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                @endcan
                                                @can('Delete Admin')
                                                    @if (auth()->id() != $user->id)
                                                        <a href="javascript:;" class="btn btn-sm btn-danger sa-delete"
                                                            data-from-id="user-delete-{{ $user->id }}">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                        <form id="user-delete-{{ $user->id }}"
                                                            action="{{ route('admins.destroy', $user->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endcan
                                                @endif

                                            </td>

                                        </tr>
                                        {{-- @endif --}}
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->
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

@endsection
