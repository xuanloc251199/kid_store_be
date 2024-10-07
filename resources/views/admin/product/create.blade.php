@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="formbold-main-wrapper">
    <div class="formbold-form-wrapper">
      <form action="{{route('admin.product.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="formbold-mb-5">
          <label for="name" class="formbold-form-label"> Name </label>
          <input type="text" name="name" id="name" placeholder="Name" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="Category" class="formbold-form-label"> Category </label>
          <select class="select-css" name="category_id" id="Category">
            @foreach ($categories as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="formbold-mb-5">
          <label for="image" class="formbold-form-label"> Image </label>
          <input type="file" name="thumbnail" id="photo" accept="image/*" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="price" class="formbold-form-label"> Price </label>
          <input type="number" name="price" id="name" placeholder="Price" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="quantity" class="formbold-form-label"> Quantity </label>
          <input type="number" name="quantity" id="name" placeholder="Quantity" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="detail" class="formbold-form-label"> Detail </label>
          <textarea rows="6" name="detail" id="ckeditor" placeholder="Type your Detail"
            class="formbold-form-input"></textarea>
        </div>
        <div class="formbold-mb-5">
          <label for="description" class="formbold-form-label"> Description </label>
          <textarea rows="6" name="description" id="ckeditor2" placeholder="Type your description"
            class="formbold-form-input"></textarea>
        </div>

        <div>
          <button class="formbold-btn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection