@extends('layouts.app')

@section('content')
 
<div class="container text-center">
<h4>{{$video->title}}</h4>
@if (session('success'))
<div class="alert alert-success">
    {!! session('success') !!}
</div>
@endif
@if (session('error'))
<div class="alert alert-danger">
    {!! session('error') !!}
</div>
@endif
@forelse ($summaries as $summary)
    <div class="card m-5">
        <div class="card-header text-muted">
            {{$summary->created_at->diffForHumans()}}
            </div>
        <div class="card body">
           <p class="p-2"> {{$summary->summary}} </p> 
        </div>
        <div class="card-footer">
            @if ($video->active_summary != $summary->id)
            <a href="{{ route('summaryUpdate', ['id'=>$summary->id]) }}" class="btn btn-primary btn-sm">Assign as Active</a>    
            @else
            <input type="button" disabled class="btn btn-success" value="Active">
            @endif
        </div>
    </div>
@empty
    <div class="alert alert-info">There are no summaries for this video yet.</div>
@endforelse

</div>

@endsection