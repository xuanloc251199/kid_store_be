@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="formbold-main-wrapper">
    <div class="formbold-form-wrapper">
      <form action="{{route('admin.category.update',$categories->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="formbold-mb-5">
          <label for="name" class="formbold-form-label"> Name </label>
          <input type="text" name="name" id="name" value="{{ $categories->name}}" placeholder="Full Name"
            class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="image" class="formbold-form-label"> Thumbnail </label>
          <input type="file" name="thumbnail" id="image" accept="image/*" class="formbold-form-input" />
          
          <!-- Hiển thị hình ảnh hiện tại nếu có -->
          @if ($categories->thumbnail)
            <div>
              <img src="{{ asset($categories->thumbnail) }}" alt="Thumbnail" style="max-width: 150px; max-height: 150px; margin-top: 10px;">
            </div>
          @endif
        </div>
        <div class="formbold-mb-5">
          <label for="description" class="formbold-form-label"> Description </label>
          <textarea rows="6" name="description" id="ckeditor"
            placeholder="Type your description" class="formbold-form-input"> {!! $categories->description!!}</textarea>
        </div>
        <div>
          <button class="formbold-btn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection