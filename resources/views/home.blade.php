@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h4 class="display-4 alert alert-info text-center d-none d-md-block" style="color:#646ecb"> Hello, {{ ucfirst(auth()->user()->name) }} here
            are
            your videos</h4>
        <h5 class="display-5 alert alert-info text-center  d-md-none" style="color:#646ecb"> Hello, {{ auth()->user()->name }} here
            are
            your videos</h5>
        <div class="row justify-content-center">
            @forelse ($videos as $video)
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="card text-center" style="margin-bottom: 3%">
                        @if ($video->flag == 1)
                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <video height="auto" width="auto" controls>
                                        <source src="{{ $video->link }}">
                                    </video>
                                </div>
                            </div>
                        @else
                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                <iframe src="{{ $video->link }}/?controls=1" title="{{ $video->title }}"
                                    allowfullscreen></iframe>
                            </div>
                        @endif
    
                        <div class="card-body">
                            <h5 class="card-title">{{ $video->title }}</h5>
                            <p>
                                {{ $video->created_at->diffForHumans() }}
                            </p>
                            <a href="{{ route('viewVideo', $video->id) }}" class="btn btn-indigo">View</a>
    
                        </div>
                    </div>
                </div>
        

            @empty
                <div class="alert alert-info">You don't have any videos yet</div>
            @endforelse

        </div>
        <div class="row justify-content-center">
            <nav aria-label="...">
                <ul class="pagination pagination-circle">
                    {{ $videos->links() }}
                </ul>
            </nav>
        </div>
    </div>
@endsection
