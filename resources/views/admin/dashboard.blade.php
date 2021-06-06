@extends('layouts.adminApp')


@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body text-center">
                welcome {{ auth()->user()->name }}
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-lg-6 col-md-12">

                <div class="card">
                    <div class="card-header">
                        Latest Requests
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 30%" scope="col">Video</th>
                                    <th style="width: 60%" scope="col">Summary</th>
                                    <th style="width: 10%" scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)

                                    <tr>

                                        <td>
                                            @if ($request->video->flag == 1)
                                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                                    <video height="100%" width="100%" controls>
                                                        <source src="{{ $request->video->link }}">
                                                    </video>

                                                </div>
                                            @else
                                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                                    <iframe src="{{ $request->video->link }}/?controls=1"
                                                        title="{{ $request->video->title }}" allowfullscreen></iframe>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $request->summary }}</td>
                                        <td>{{ $request->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div >{{ $requests->links() }}</div>
                        
                    </div>
                </div>

            </div>

            <div class="col-lg-6 col-md-12">

                <div class="card">
                    <div class="card-header">
                        Latest videos with summaries.
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 30%" scope="col">Video</th>
                                    <th style="width: 70%" scope="col">Summary</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($videos as $video)

                                    <tr>

                                        <td>
                                            @if ($video->flag == 1)
                                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                                    <video height="100%" width="100%" controls>
                                                        <source src="{{ $video->link }}">
                                                    </video>

                                                </div>
                                            @else
                                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                                    <iframe src="{{ $video->link }}/?controls=1"
                                                        title="{{ $video->title }}" allowfullscreen></iframe>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $video->summary->summary }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div >{{ $videos->links() }}</div>
                        
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
