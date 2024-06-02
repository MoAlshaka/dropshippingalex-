@extends('layouts.master')

@section('content')
    <!-- User Filter -->
    <div class="card mb-3">
        <h5 class="card-header">Filter Users</h5>
        <div class="card-body">
            <form action="{{ route('users.statics') }}" method="GET">
                <div class="form-group">
                    <label for="selected_users">Select Users:</label>
                    <select name="selected_users[]" id="selected_users" class="form-control" multiple>
                        @foreach ($users as $user)
                                @if($user['roles_name'] !== 'Owner')
                                <option value="{{ $user->id }}" {{ in_array($user->id, $selectedUserIds) ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endif
                            @endforeach
                    </select>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Apply Filter</button>
            </form>
        </div>
    </div>
    <!--/ User Filter -->

    <!-- User Statistics -->
    @if (!empty($selectedUserIds))
        <div class="card">
            <h5 class="card-header">User Statistics</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="em_data" class="display table table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Team</th>
                            @foreach ($leadStatuses as $status)
                                <th>{{ $status->name }}</th>
                            @endforeach
                            <th>Total Leads</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($userStatistics as $userStat)
                                <tr>
                                    <td>{{ $userStat['user_name'] }}</td>
                                    <td>{{ $userStat['team_name'] }}</td>
                                    @foreach ($leadStatuses as $status)
                                        <td>{{ $userStat['lead_counts'][$status->name] }}</td>
                                    @endforeach
                                    <td>{{ $userStat['total_lead_count'] }}</td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    <!--/ User Statistics -->
@endsection
