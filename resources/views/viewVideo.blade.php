@extends('layouts.app')

@section('content')
<div class="container-fluid">
@if (session('info'))
<div class="alert alert-info">
    {!! session('info') !!}
</div>
@endif
@if ($info ?? false)
<div class="alert alert-info text-center">
    Your video is currently being processed you can leave this page and you'll be notified when it's ready.
</div>
@endif
        <h4 class="display-4 text-center d-none d-md-block" style="color:#646ecb"> {{ $video->title }}</h4>
        <h5 class="display-5 text-center  d-md-none" style="color:#646ecb"> {{ $video->title }}</h5>
        <div class="row justify-content-around">
            <div class="col-lg-2 col-md-12">
                <div class="card text-center">
                   
                    <div class="card-body">  
                        <ul class="list-group">
                            <li class="list-group-item"><a href="{{ route('RequestEdit', ['id'=>$video->id]) }}">Request edit summary</a></li>
                            <li class="list-group-item"><a href="{{ route('VideoRequestsView', ['id'=>$video->id]) }}"> Video edit requests</a></li>
                            <li class="list-group-item"><a href="{{ route('summaryView', ['id'=>$video->id]) }}">Video summaries</a></li>
                          </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                @if ($video->flag == 1)
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe src="{{ $video->link }}" title="W3Schools Free Online Web Tutorials"></iframe>
                        
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
                    @if (!$video->summary)
                        <div class="card-body d-flex justify-content-center">
                            <div class="alert alert-info text-center float-right">No Summary</div>
                        </div>
                    @else
                        <div class="card-body">
                            {{ $video['summary']->summary }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-12">
                <div class="card text-center">
                    <div style="background-color:#646ecb" class="card-header text-center text-white">Video Timestamps</div>
                    <div class="card-body">
                        @forelse ($video['timestamps'] as $timestamp)
                            <h6><a  href=""> {{ $timestamp->start_time }} || {{ $timestamp->end_time }} </a> </h6>
                            <h6>{{$timestamp->description}}</h6>
                            <hr>
                        @empty
                        </div>
                        <div class="alert alert-info">No Timestamps</div>
                    @endforelse
                </div>

                <div class="card text-center">
                    <div style="background-color:#646ecb" class="card-header text-center text-white">Video Keywords</div>
                    <div class="card-body">
                        <h5>
                        @forelse ($video['keywords'] as $keyword)
                        <span class="badge rounded-pill bg-primary">{{$keyword->keyword}}</span>
                        
                        @empty
                        </div>
                        <div class="alert alert-info">No Keywords</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

<style>

</style>
@endsection
