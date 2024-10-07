@extends('admin.master')
@section('content')
<div class="table-container">
  <div class="formbold-main-wrapper">
    <div class="formbold-form-wrapper">
      <form action="{{route('admin.user.update',$user->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="formbold-mb-5">
          <label for="name" class="formbold-form-label"> Name </label>
          <input type="text" name="name" id="name" value="{{$user->name}}" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="password" class="formbold-form-label"> Password </label>
          <input type="password" name="password" id="password" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="role" class="formbold-form-label"> Role </label>
          <select class="select-css" name="role_id" id="role">
            @foreach ($roles as $item)
              <option value="{{$item->id}}" {{$item->id == $user->role_id ? "selected" : ""}}>{{$item->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="formbold-mb-5">
          <label for="email" class="formbold-form-label"> Email </label>
          <input type="email" name="email" id="email" value="{{$user->email}}" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="number_phone" class="formbold-form-label"> Phone </label>
          <input type="text" name="number_phone" id="number_phone" value="{{$user->number_phone}}" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="address" class="formbold-form-label"> Address </label>
          <input type="text" name="address" id="address" value="{{$user->address}}" class="formbold-form-input" />
        </div>
        <div class="formbold-mb-5">
          <label for="avatar" class="formbold-form-label"> Avatar </label>
          <input type="file" name="avatar" accept="image/*" id="avatar" class="formbold-form-input" />
          @if ($user->avatar)
            <div>
              <img src="{{ asset($user->avatar) }}" alt="avatar" style="max-width: 150px; max-height: 150px; margin-top: 10px;">
            </div>
          @endif
        </div>
        <div>
          <button class="formbold-btn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection