@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="button-create">
    <a href="{{route('admin.category.create')}}">Create</a>
  </div>
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Thumbnail</th>
        <th>Detail</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $item)
      <tr>
      <td>{{$item->name}}</td>
      <td style="text-align:center;"><img style="max-width:75px; max-height: 75px; object-fit:cover; " src="{{asset($item->thumbnail)}}" alt="{{$item->name}}"></td>
      <td>{!!$item->description!!}</td>
      <td style="text-align:center;">
        <a class="button-action" href="{{route('admin.category.edit', ['category' => $item->id])}}">Edit</a>
        <form action="{{ route('admin.category.destroy', ['category' => $item->id]) }}" method="POST">
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
    <a href="{{route('admin.category.create')}}">Create</a>
  </div>
</div>
@endsection