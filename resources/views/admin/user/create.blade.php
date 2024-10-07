@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="formbold-main-wrapper">
    <div class="formbold-form-wrapper">
      <form action="{{route('admin.user.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="formbold-mb-5">
          <label for="name" class="formbold-form-label"> Name </label>
          <input type="text" name="name" id="name" placeholder="Full Name" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="password" class="formbold-form-label"> Password </label>
          <input type="password" name="password" id="password" placeholder="Password" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="role" class="formbold-form-label"> Role </label>
          <select class="select-css" name="role_id" id="role">
            @foreach ($roles as $item)
              <option value="{{$item->id}}" {{$item->id == 2 ? "selected" : ""}}>{{$item->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="formbold-mb-5">
          <label for="email" class="formbold-form-label"> Email </label>
          <input type="email" name="email" id="email" placeholder="Email" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="number_phone" class="formbold-form-label"> Phone </label>
          <input type="text" name="number_phone" id="number_phone" placeholder="Phone" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="address" class="formbold-form-label"> Address </label>
          <input type="text" name="address" id="address" placeholder="Address" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="avatar" class="formbold-form-label"> Avatar </label>
          <input type="file" name="avatar" accept="image/*" id="avatar" class="formbold-form-input" />
        </div>
        <div>
          <button class="formbold-btn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection