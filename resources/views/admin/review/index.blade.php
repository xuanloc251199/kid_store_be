@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="button-create">
    <a href="{{route('admin.review.create')}}">Create</a>
  </div>
  <table>
    <thead>
      <tr>
        <th>User name</th>
        <th>User product</th>
        <th>Rating</th>
        <th>Comment</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($reviews as $item)
      <tr>
      <td>{{$item->user->name}}</td>
      <td>{{$item->product->name}}</td>
      <td>{{$item->rating}}</td>
      <td>{!!$item->comment!!}</td>
      <td style="text-align:center;">
        <a class="button-action" href="{{route('admin.review.edit', ['review' => $item->id])}}">Edit</a>
        <form action="{{ route('admin.review.destroy', ['review' => $item->id]) }}" method="POST">
        @csrf
        @method('DELETE') <!-- Create phương thức DELETE -->
        <button class="button-action" type="submit" style=" cursor: pointer;">Delete</button>
        </form>
      </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="button-create">
    <a href="{{route('admin.review.create')}}">Create</a>
  </div>
</div>
@endsection