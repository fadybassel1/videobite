@extends('layouts.app')

@section('content')
<div class="container text-center">
    @if ($allowed == 1)
            <div class="card">
                <div class="card-body">
                    <p>{{ $summary->summary}} </p>
                </div>
                <div class="card-footer">
                    <form method="post" action="{{ route('RequestStore') }}">
                        @csrf
                        <textarea  class="form-control" name="summary" rows="6">{{$summary->summary}}</textarea>
                        <input name="video" value="{{$summary->video_id}}" type="hidden">
                        <input name="summaryID" value="{{$summary->id}}" type="hidden">
                        <br>
                        <button class="btn btn-success" type="submit">Submit Request</button>
                    </form>
                </div>

            </div>
            @else
            <div class="card">
              <div class="alert alert-warning">You already have a pending edit request for this video!</div> 
              <div class="card-body">
                  <div class="row">
                      <div class="col-8">
                          <p>{{$request->summary}}</p>
                      </div>
                    <div class="col-2">
                        <p class="text-muted">{{$request->created_at->diffForHumans()}}</p>
                    </div>
                    <div class="col-2">
                        <input class="btn btn-warning btn-sm" type="button" disabled value="{{$request->status}}"> 
                    </div>
                  </div>
            </div> 
            </div>    
        </div>
    @endif
@endsection
