@extends('layouts.adminApp')
@section('content')
@if(Session::has('status'))
<div class="container alert alert-success" role="alert">
  {{ Session::get('status') }}
</div>
@endif
<div class="card">
  <h3 class="card-header text-center font-weight-bold text-uppercase py-4">All Users</h3>
  <div class="card-body">
    <div id="table" class="table-editable">
      <table id="DBTable" class="table table-bordered table-responsive-md table-striped text-center">
        <thead class="elegant-color white-text">
          <tr>
            <th class="text-center">#</th>
            <th class="text-center">Name</th>
            <th class="text-center">Email</th>
            <th class="text-center">Delete</th>
          </tr>
        </thead>
        <tbody>
          @php($i=1)
          @forelse ($users as $user)
          <tr>
            <th class="pt-3-half">{{$i}}</th>
            <td class="pt-3-half">{{$user->name}}</td>
            <td class="pt-3-half">{{$user->email}}</td>
            <td class="pt-3-half">
              <form action="{{ route('admin.userDelete', $user->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }} 
                <input onclick="return confirm('Are you sure');" class="btn btn-danger btn-rounded btn-sm my-0"
                  type="submit" value="Delete">
              </form>
            </td>
            @php($i++)
          </tr>
          @empty
          <th colspan="9" style="text-align:center">No Users to show </th>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection