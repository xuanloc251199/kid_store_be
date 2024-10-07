@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="button-create">
    <a href="{{route('admin.ticket.create')}}">Create</a>
  </div>
  <table>
    <thead>
      <tr>
        <th>Thumbnail</th>
        <th>Name</th>
        <th>Place</th>
        <th>Date</th>
        <th>Detail</th>
        <th>Description</th>
        <th>Price</th>
        <th>Number ticket</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($tickets as $item)
      <tr>
      <td style="text-align:center;"><img style="max-width:75px; max-height: 75px; object-fit:cover; " src="{{asset($item->thumbnail)}}" alt="{{$item->name}}"></td>
      <td>{!!$item->name!!}</td>
      <td>{!!$item->place!!}</td>
      <td>{!!$item->date!!}</td>
      <td>{!!$item->detail!!}</td>
      <td>{!!$item->description!!}</td>
      <td>{!!$item->price!!} $</td>
      <td>{!!$item->number_ticket!!} </td>
      <td style="text-align:center;">
        <a class="button-action" href="{{route('admin.ticket.edit', ['ticket' => $item->id])}}">Edit</a>
        <form action="{{ route('admin.ticket.destroy', ['ticket' => $item->id]) }}" method="POST">
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
    <a href="{{route('admin.ticket.create')}}">Create</a>
  </div>
</div>
@endsection