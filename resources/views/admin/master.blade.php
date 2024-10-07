<!DOCTYPE html>
<html lang="en">

@include('admin.layouts._head')

<body>
  <div class="container">
    @include('admin.layouts._sidebar')
    <div class="main">
      <div class="topbar">
        <div class="toggle">
          <ion-icon name="menu-outline"></ion-icon>
        </div>
        <!-- <div class="search">
          <label for="">
            <input type="text" name="" placeholder="Search here">
            <ion-icon name="search-outline"></ion-icon>
          </label>
        </div> -->
        <div class="user">
          <img src="{{asset('assets/images/test_0.jpg')}}" alt="">
        </div>
      </div>
      <!-- card -->
      <div class="cardBox">
        @yield('card')
      </div>
      <div class="main-content">
        @yield('content')
      </div>
    </div>
  </div>
  @include('admin.layouts._script')
</body>

</html>