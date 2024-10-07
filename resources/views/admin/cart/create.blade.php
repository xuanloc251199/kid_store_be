@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="formbold-main-wrapper">
    <div class="formbold-form-wrapper">
      <form action="{{route('admin.cart.store')}}" method="POST">
        @csrf
        <div class="formbold-mb-5">
          <label for="user" class="formbold-form-label"> User </label>
          <select class="select-css" name="user_id" id="user">
            @foreach ($users as $item)
        <option value="{{$item->id}}">{{$item->name}}</option>
      @endforeach
          </select>
        </div>
        <div class="formbold-mb-5">
          <label for="product" class="formbold-form-label"> Product </label>
          <select class="select-css" name="product_id" id="product">
            @foreach ($products as $item)
        <option value="{{$item->id}}">{{$item->name}}</option>
      @endforeach
          </select>
        </div>
        <div class="formbold-mb-5">
          <label for="quantity" class="formbold-form-label"> Quantity </label>
          <input type="number" name="quantity" id="name" min="0" max="500" placeholder="Quantity"
            class="formbold-form-input" />
        </div>
        <div>
          <button class="formbold-btn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection