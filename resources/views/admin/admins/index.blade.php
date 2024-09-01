@extends('layouts.master')

@section('title')
    {{ __('site.Admins') }}
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Admins</h5>
                </div>
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="em_data" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#{{ __('site.ID') }}</th>
                                    <th>{{ __('site.Name') }}</th>
                                    <th>{{ __('site.UserName') }}</th>
                                    <th>{{ __('site.Roles') }}</th>
                                    <th>{{ __('site.CreatedAt') }}</th>
                                    <th class="text-center">{{ __('site.Actions') }}</th>

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

                                            <td class="text-center">
                                                @can('Edit Admin')
                                                    <a href="{{ route('admins.edit', $user->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fa fa-edit"></i> {{ __('site.Edit') }}
                                                    </a>
                                                @endcan
                                                @can('Delete Admin')
                                                    @if (auth()->id() != $user->id)
                                                        <form id="user-delete-{{ $user->id }}"
                                                            action="{{ route('admins.destroy', $user->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger sa-delete">
                                                                <i class="fa fa-trash"></i> {{ __('site.Delete') }}
                                                            </button>
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
