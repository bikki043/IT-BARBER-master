<nav class="navbar-custom">
    <div class="d-flex align-items-center">
        <a href="{{ url('/') }}">
            <img src="https://i.postimg.cc/wBXNS8BC/634279408-927069233189594-6692013687990253917-n.jpg"
                class="nav-logo" alt="Logo">
        </a>
    </div>

    <ul class="nav-links d-none d-lg-flex">
        <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
        
        @if (Auth::guard('customer')->check())
            <li><a href="{{ route('booking.history') }}" class="{{ request()->routeIs('booking.history') ? 'active' : '' }}"></a></li>
        @endif

        <li><a href="{{ route('shop.index') }}">Shop</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
    </ul>

    <div class="nav-icons d-flex align-items-center">
        {{-- ตะกร้าสินค้า --}}
        <a href="{{ route('cart.index') }}" class="position-relative mr-4" style="color: inherit; text-decoration: none;">
            <i class="fas fa-shopping-cart" style="font-size: 1.4rem;"></i>
            @if (isset($cartCount) && $cartCount > 0)
                <span class="badge badge-pill badge-warning"
                    style="font-size: 0.7rem; position: absolute; top: -8px; right: -10px; border: 2px solid #000;">
                    {{ $cartCount }}
                </span>
            @endif
        </a>

        @if (Auth::guard('customer')->check())
            {{-- ส่วนของลูกค้าที่ Login แล้ว --}}
            @php $user = Auth::guard('customer')->user(); @endphp
            <div class="dropdown">
                <a href="#" class="dropdown-toggle d-flex align-items-center" id="userDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    style="text-decoration: none; color: white;">
                    <img src="{{ $user->image_path ? asset('storage/' . $user->image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ffcc00&color=000' }}"
                        alt="Profile"
                        style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid #ffcc00; object-fit: cover;">
                    <span class="ml-2 d-none d-md-inline-block" style="font-size: 0.9rem; font-weight: 600;">{{ $user->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right mt-3 shadow-lg" aria-labelledby="userDropdown"
                    style="background: #111; border: 1px solid #333; min-width: 200px;">
                    <a class="dropdown-item text-white py-2" href="{{ route('customer.profile') }}">
                        <i class="fas fa-user-circle mr-2 text-warning"></i> ข้อมูลส่วนตัว
                    </a>
                    <a class="dropdown-item text-white py-2" href="{{ route('booking.history') }}">
                        <i class="fas fa-history mr-2 text-warning"></i> ประวัติการจอง
                    </a>
                    <div class="dropdown-divider" style="border-top: 1px solid #333;"></div>
                    <form method="POST" action="{{ route('customer.logout') }}" class="px-3 py-1">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning btn-sm btn-block">
                            <i class="fas fa-sign-out-alt mr-2"></i> ออกจากระบบ
                        </button>
                    </form>
                </div>
            </div>
        @elseif(Auth::check())
             {{-- ส่วนของ Admin/User ปกติ --}}
             <div class="dropdown">
                <a href="#" class="dropdown-toggle d-flex align-items-center text-white" data-toggle="dropdown" style="text-decoration: none;">
                    <i class="fas fa-user-shield mr-2 text-warning"></i> {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right mt-3" style="background: #111; border: 1px solid #333;">
                    <a class="dropdown-item text-white" href="{{ route('profile.edit') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="px-3 py-1">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm btn-block">Log Out</button>
                    </form>
                </div>
            </div>
        @else
            {{-- ยังไม่ได้ Login --}}
            <a href="{{ url('/customer/login') }}" class="btn-login-header">
                <i class="fas fa-user-circle mr-1"></i> เข้าสู่ระบบ
            </a>
        @endif
    </div>
</nav>

<style>
    /* CSS เพิ่มเติมเพื่อให้ Navbar แสดงผลได้เหมือนหน้า Welcome เป๊ะๆ */
    .navbar-custom {
        padding: 15px 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: rgba(0, 0, 0, 0.95);
        border-bottom: 1px solid #222;
        position: sticky;
        top: 0;
        z-index: 1000;
        font-family: 'Chakra Petch', sans-serif;
    }

    .nav-logo {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid #ffcc00;
    }

    .nav-links {
        list-style: none;
        display: flex;
        margin: 0;
        padding: 0;
    }

    .nav-links li { margin: 0 15px; }

    .nav-links a {
        color: #fff;
        text-transform: uppercase;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }

    .nav-links a:hover, .nav-links a.active { color: #ffcc00; }

    .btn-login-header {
        background: transparent;
        border: 1px solid #ffcc00;
        color: #ffcc00;
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: 0.3s;
        text-decoration: none !important;
    }

    .btn-login-header:hover {
        background: #ffcc00;
        color: #000;
    }

    .dropdown-item:hover {
        background: #222 !important;
        color: #ffcc00 !important;
    }
</style>
