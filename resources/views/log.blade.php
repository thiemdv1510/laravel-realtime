@extends('layouts.app')

@section('content')

    <div class="container">
      <table class="table table-bordered">
          <thead>
          <tr>
              <th>#</th>
              <th>User</th>
              <th>Created</th>
          </tr>
          </thead>
          <tbody>
          @foreach($records as $key => $item)
          <tr >
            <td>{{++$key}}</td>
            <td>{{$item->user_id}}</td>
            <td>{{date('d-m-Y H:i:s', strtotime($item->created_at))}}</td>
          </tr>
          @endforeach
          </tbody>
      </table>
    </div>
@endsection
