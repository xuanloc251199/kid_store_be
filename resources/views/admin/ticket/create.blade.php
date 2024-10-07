@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="formbold-main-wrapper">
    <div class="formbold-form-wrapper">
      <form action="{{route('admin.ticket.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="formbold-mb-5">
          <label for="name" class="formbold-form-label"> Name </label>
          <input type="text" name="name" id="name" placeholder="Full Name" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="image" class="formbold-form-label"> Image </label>
          <input type="file" name="thumbnail" id="photo" accept="image/*" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="Place" class="formbold-form-label"> Place </label>
          <input type="text" name="place" id="Place" placeholder="Place" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="price" class="formbold-form-label"> Price </label>
          <input type="number" name="price" id="price" placeholder="Price" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="number_ticket" class="formbold-form-label"> Number Ticket </label>
          <input type="number" name="number_ticket" id="number_ticket" placeholder="Number Ticket" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="date" class="formbold-form-label"> Date </label>
          <input type="date" name="date" id="date" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="detail" class="formbold-form-label"> Detail </label>
          <textarea rows="6" name="detail" id="ckeditor" class="formbold-form-input"></textarea>
        </div>
        <div class="formbold-mb-5">
          <label for="description" class="formbold-form-label"> Description </label>
          <textarea rows="6" name="description" id="ckeditor2" class="formbold-form-input"></textarea>
        </div>

        <div>
          <button class="formbold-btn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection