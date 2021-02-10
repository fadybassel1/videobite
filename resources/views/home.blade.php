@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h4 class="display-4 alert alert-info text-center" style="color:#646ecb"> Hello, {{ auth()->user()->name }} here
            are
            your videos</h4>
        <div class="row justify-content-around">
            @forelse ($videos as $video)
                <div class="card text-center" style="width: 20rem; margin-bottom: 2%">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <iframe src="{{ $video->link }}" title="{{ $video->title }}" allowfullscreen></iframe>
                    
                    </div>
                    <div class="card-body">
                        <h5  class="card-title">{{ $video->title }}</h5>
                        <p>
                            {{ $video->created_at->diffForHumans() }}
                        </p>
                        <a href="#!" class="btn btn-indigo">View</a>
                      
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
