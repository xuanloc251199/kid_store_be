@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="button-create">
    <a href="{{route('admin.cart.create')}}">Create</a>
  </div>
  <table>
    <thead>
      <tr>
        <th>User</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($carts as $item)
      <tr>
      <td>{{$item->user->name}}</td>
      <td>{!!$item->product->name!!}</td>
      <td>{!!$item->quantity!!}</td>
      <td style="text-align:center;">
        <a class="button-action" href="{{route('admin.cart.edit', ['cart' => $item->id])}}">Edit</a>
        <form action="{{ route('admin.cart.destroy', ['cart' => $item->id]) }}" method="POST">
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
    <a href="{{route('admin.cart.create')}}">Create</a>
  </div>
</div>
@endsection