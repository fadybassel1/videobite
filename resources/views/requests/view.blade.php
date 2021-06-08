@extends('layouts.app')

@section('content')

    <div class="container">
            <div class="text-center">
                <h3>Video Requests</h3>
            </div>

            @forelse ($requests as $request)
                <table class="table text-center">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 70%" scope="col">Posted Summary</th>
                            <th style="width: 15%" scope="col">Status</th>
                            <th style="width: 15%" scope="col">Date Posted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $request->summary }}</td>
                            <td>{{ $request->status }}</td>
                            <td class="text-muted">{{ $request->created_at->diffForHumans() }}</td>
                        </tr>
                    </tbody>
                </table>
            @empty
                <div class="alert alert-info text-center"> No Previous Requests!</div>
            @endforelse




    </div>


@endsection
