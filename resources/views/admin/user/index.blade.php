@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="button-create">
    <a href="{{route('admin.user.create')}}">Create</a>
  </div>
  <table>
    <thead>
      <tr>
        <th>Avatar</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Role</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $item)
      <tr>
      <td style="text-align:center;"><img style="max-width:75px; max-height: 75px; object-fit:cover; " src="{{asset($item->avatar)}}" alt="{{$item->name}}"></td>
      <td>{{$item->name}}</td>
      <td>{!!$item->email!!}</td>
      <td>{!!$item->number_phone!!}</td>
      <td>{!!$item->address!!}</td>
      <td>{!!$item->role->name!!}</td>
      <td style="text-align:center;">
        <a class="button-action" href="{{route('admin.user.edit', ['user' => $item->id])}}">Edit</a>
        <form action="{{ route('admin.user.destroy', ['user' => $item->id]) }}" method="POST">
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
    <a href="{{route('admin.user.create')}}">Create</a>
  </div>
</div>
@endsection