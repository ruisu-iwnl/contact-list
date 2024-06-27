@extends('layout')
@section('content')
<div>            
    <header class="py-4 text-center">
        <h3 class="text-3xl font-bold">Activity Logs</h1>
        <p>refresh the page if it's not updating</p>
    </header>
    <table class="table-auto w-full bg-white shadow-md rounded mb-4">
        <thead>
            <tr>
                <th class="px-4 py-2">User</th>
                <th class="px-4 py-2">Activity Description</th>
                <th class="px-4 py-2">Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td class="border px-4 py-2">{{ $log->user ? $log->user->username : 'Unknown' }}</td>
                    <td class="border px-4 py-2">{{ $log->activity_description }}</td>
                    <td class="border px-4 py-2">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $logs->links() }}
</div>
@endsection