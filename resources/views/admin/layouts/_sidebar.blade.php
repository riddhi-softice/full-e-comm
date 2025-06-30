<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('get_setting') ? '' : 'collapsed' }}" href="{{ route('get_setting') }}">
                <i class="bi bi-gear"></i>
                <span>Common Setting</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('users.index') ? '' : 'collapsed' }}" href="{{ route('users.index') }}">
                <i class="bi bi-person"></i>
                <span>Users</span>
            </a>
        </li>
       
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('brands.index') ? '' : 'collapsed' }}" href="{{ route('brands.index') }}">
                <i class="bi bi-list"></i>
                <span>Brands</span>
            </a>
        </li>
       
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('categories.index') ? '' : 'collapsed' }}" href="{{ route('categories.index') }}">
                <i class="bi bi-list"></i>
                <span>Categories</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('products.*') ? '' : 'collapsed' }}" href="{{ route('products.index') }}">
                <i class="bi bi-list"></i>
                <span>Products</span>
            </a>
        </li>
       
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('get_order_list') ? '' : 'collapsed' }}" href="{{ route('get_order_list') }}">
                <i class="bi bi-list"></i>
                <span>Orders</span>
            </a>
        </li>
       
    </ul>
</aside>
