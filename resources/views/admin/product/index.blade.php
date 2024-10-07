@extends('admin.master')
@section('content')
    <div class="table-container">
        <div class="button-create">
            <a href="{{ route('admin.product.create') }}">Create</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Detail</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Sold</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td style="text-align:center;"><img style="max-width:75px; max-height: 75px; object-fit:cover; "
                                src="{{ asset($item->thumbnail) }}" alt="{{ $item->name }}"></td>
                        <td>{{ $item->name }}</td>
                        <td>{!! $item->detail !!}</td>
                        <td>{!! $item->description !!}</td>
                        <td>{!! $item->price !!} VNĐ</td>
                        <td>{!! $item->sold !!}</td>
                        <td>{!! $item->quantity !!}</td>
                        <td style="text-align:center;">
                            <a class="button-action"
                                href="{{ route('admin.product.edit', ['product' => $item->id]) }}">Edit</a>
                            <form action="{{ route('admin.product.destroy', ['product' => $item->id]) }}" method="POST">
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
            <a href="{{ route('admin.product.create') }}">Create</a>
        </div>
    </div>
@endsection
