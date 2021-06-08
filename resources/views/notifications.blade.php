@extends('layouts.app')

@section('content')

<div  style=" width:95%; margin:auto">
  <div class="row">
    <div class="col-lg">
      <table id="tablePreview" class="table table-bordered">
        <thead>
          <tr class="text-center">
            @if(Route::getCurrentRoute()->uri() == 'notifications')
            <th><h4 class="font-weight-bold">Unread Notifications<h4></th>
            @elseif(Route::getCurrentRoute()->uri() == 'notifications/viewall')
            <th><h4 class="font-weight-bold">All Notifications<h4></th>
            @endif
          </tr>
        </thead>
        <tbody>
          @if($notifications->isEmpty())
          <tr>
            <td>No Unread Notifications</td>
          </tr>
          @else
          @foreach($notifications as $notification)
          <tr>
            <td>{{ $notification->data['data'] }}</td>
          </tr>
          @endforeach
          @endif
        </tbody>
        <tfoot>
          <tr>
            <td colspan="7" class="col-12 text-center">
              @if(Route::getCurrentRoute()->uri() == 'notifications')
              <input type="button" class="btn" style="background-color: #646ecb; color:white;" onclick="window.location='{{ url('notifications/markallasread') }}'" id="markasread" value="Mark All As Read">
              <input type="button" class="btn" style="background-color: #646ecb; color:white;" onclick="window.location='{{ url('notifications/viewall') }}'" id="viewall" value="View All Notifications">
              @elseif(Route::getCurrentRoute()->uri() == 'notifications/viewall')
              <input type="button" class="btn" style="background-color: #646ecb; color:white;" onclick="window.location='{{ url('/notifications') }}'" id="viewall" value="Back to Unread Notifications">
              @endif
            </td>
          </tr>
        </tfoot>
      </table>
      </div>
  </div>
</div>

@endsection
