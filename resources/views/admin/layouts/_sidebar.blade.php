<div class="navigation">
  <ul>
    <li>
      <a href="">
        <span class="icon"><ion-icon name="aperture-outline"></ion-icon></span>
        <span class="title">Brand Name</span>
      </a>
    </li>
    <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'hovered active' : '' }}">
      <a href="{{route('admin.dashboard')}}">
        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
        <span class="title">Dashboard</span>
      </a>
    </li>
    <li class="{{ in_array(Route::currentRouteName(), haystack: ['admin.user.index', 'admin.user.create', 'admin.user.update']) ? 'hovered active' : '' }}">
      <a href="{{route('admin.user.index')}}">
        <span class="icon"><ion-icon name="layers-outline"></ion-icon></span>
        <span class="title">User</span>
      </a>
    </li>
    <li class="{{ in_array(Route::currentRouteName(), ['admin.category.index', 'admin.category.create', 'admin.category.update']) ? 'hovered active' : '' }}">
      <a href="{{route('admin.category.index')}}">
        <span class="icon"><ion-icon name="layers-outline"></ion-icon></span>
        <span class="title">Category</span>
      </a>
    </li>
    <li class="{{ in_array(Route::currentRouteName(), ['admin.product.index', 'admin.product.create', 'admin.product.update']) ? 'hovered active' : '' }}">
      <a href="{{route('admin.product.index')}}">
        <span class="icon"><ion-icon name="list-outline"></ion-icon></span>
        <span class="title">Products</span>
      </a>
    </li>
    <li class="{{ in_array(Route::currentRouteName(), ['admin.review.index', 'admin.review.create', 'admin.review.update']) ? 'hovered active' : '' }}">
      <a href="{{route('admin.review.index')}}">
        <span class="icon"><ion-icon name="eye-outline"></ion-icon></span>
        <span class="title">Review</span>
      </a>
    </li>
    <li class="{{ in_array(Route::currentRouteName(), ['admin.cart.index', 'admin.cart.create', 'admin.cart.update']) ? 'hovered active' : '' }}">
      <a href="{{route('admin.cart.index')}}">
        <span class="icon"><ion-icon name="cart-outline"></ion-icon></span>
        <span class="title">Cart</span>
      </a>
    </li>
    <li class="{{ in_array(Route::currentRouteName(), ['admin.ticket.index', 'admin.ticket.create', 'admin.ticket.update']) ? 'hovered active' : '' }}">
      <a href="{{route('admin.ticket.index')}}">
        <span class="icon"><ion-icon name="ticket-outline"></ion-icon></span>
        <span class="title">Ticket</span>
      </a>
    </li>
    <li>
      <a href="#" id="logout-link">
        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
        <span class="title">Logout</span>
      </a>
      <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>

  </ul>
</div>