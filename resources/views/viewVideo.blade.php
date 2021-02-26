@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="display-4 text-center d-none d-md-block" style="color:#646ecb"> {{ $video->title }}</h4>
        <h5 class="display-5 text-center  d-md-none" style="color:#646ecb"> {{ $video->title }}</h5>
        <div class="row justify-content-around">
            <div class="col-lg-9">
                @if ($video->flag == 1)
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <div class="embed-responsive embed-responsive-16by9">
                            <video height="auto" width="auto" controls>
                                <source src="{{ $video->link }}">
                            </video>
                        </div>
                    </div>
                @else
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe src="{{ $video->link }}/?controls=1" title="{{ $video->title }}"
                            allowfullscreen></iframe>
                    </div>
                @endif

                <div class="card">
                    <div style="background-color:#646ecb" class="card-header text-center text-white">
                        Summary
                    </div>
                    @if (count($video->summary) == 0)
                        <div class="card-body d-flex justify-content-center">
                            <div class="alert alert-info text-center float-right">No Summary</div>
                        </div>
                    @else
                        <div class="card-body">
                            {{ $video['summary'][0]->summary }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md">
                <div class="card text-center">
                    <div style="background-color:#646ecb" class="card-header text-center text-white">Video timestamps</div>
                    <div class="card-body">
                        @forelse ($video['timestamps'] as $timestamp)
                            <h6><a href=""> {{ $timestamp->start_time }} || {{ $timestamp->end_time }} </a> </h6>
                        @empty
                        </div>
                        <div class="alert alert-info">No timeStamps</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection
