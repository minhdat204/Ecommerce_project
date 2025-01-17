<!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="{{ asset('img/logo.png') }}" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="./shoping-cart.html"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__auth">
                @auth
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-user"></i> {{ Auth::user()->hoten }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="dropdown-header">
                                <div class="user-info">
                                    <i class="fa fa-user-circle"></i>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="fa fa-user-circle"></i> Tài khoản của tôi
                            </a>
                            <a class="dropdown-item" href="{{ route('orders.detail', ['id' => 'latest']) }}">
                                <i class="fa fa-shopping-basket"></i> Đơn hàng của tôi
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fa fa-sign-out"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"><i class="fa fa-user"></i> Đăng nhập</a>
                @endauth
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="./index.html">Home</a></li>
                <li><a href="./shop-grid.html">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.html">Shop Details</a></li>
                        <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                        <li><a href="./checkout.html">Check Out</a></li>
                        <li><a href="./blog-details.html">Blog Details</a></li>
                    </ul>
                </li>
                <li><a href="./blog.html">Blog</a></li>
                <li><a href="./contact.html">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Free Shipping for all Order of $99</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">

        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="{{ route('users.home') }}"><img src="{{ asset('img/logo.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <nav class="header__menu">
                        <ul>
                            <li class="{{ Route::is('users.home') ? 'active' : '' }}">
                                <a href="{{route('users.home')}}">Home</a>
                            </li>
                            <li class="{{ Route::is('users.shop') ? 'active' : '' }}">
                                <a href="{{route('users.shop')}}">Shop</a>
                            </li>
                            <li class="{{ Route::is('users.blogs') ? 'active' : '' }}">
                                <a href="{{route('users.blogs')}}">Blog</a>
                            </li>
                            <li class="{{ Route::is('users.contact') ? 'active' : '' }}">
                                <a href="{{route('users.contact')}}">Contact</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-5">
                    <div class="header__cart">
                        <ul>
                            <li>
                                @auth
                                    <a href="{{ route('favorites.index') }}"><i class="fa fa-heart"></i> <span id="favorite-count">{{ Auth::user()->favoriteProducts ? Auth::user()->favoriteProducts->count() : 0 }}</span></a>
                                @else
                                    <a href="#" onclick="openModal('/favorites')"><i class="fa fa-heart"></i> <span>0</span></a>
                                @endauth
                            </li>
                            <li>
                                @auth
                                    <a href="{{route('cart.index')}}"><i class="fa fa-shopping-bag"></i> <span id="cart-count">{{ Auth::check() && Auth::user()->cart ? Auth::user()->cart->cartItems->count() : 0 }}</span></a>
                                @else
                                    <a href="#" onclick="openModal('/cart')"><i class="fa fa-shopping-bag"></i> <span>0</span></a>
                                @endauth
                            </li>
                        </ul>
                        <div class="header__top__right__language">
                            <div class="header__cart__price">Giỏ hàng: <span id="cart-total">{{ Auth::check() && Auth::user()->cart ? number_format(Auth::user()->cart->cartItems->sum(function($item) { return $item->soluong * ($item->product->gia_khuyen_mai !== null && $item->product->gia_khuyen_mai >= 0 ? $item->product->gia_khuyen_mai : $item->product->gia); }), 0, ',', '.') : 0 }}đ</span></div>
                        </div>
                        <div class="header__top__right__auth">
                            @auth
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fa fa-user"></i> {{ Auth::user()->hoten }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <div class="dropdown-header">
                                            <div class="user-info">
                                                <i class="fa fa-user-circle"></i>
                                                <span>{{ Auth::user()->email }}</span>
                                            </div>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                                            <i class="fa fa-user-circle"></i> Tài khoản của tôi
                                        </a>
                                      
                                        <div class="dropdown-divider"></div>
                                        <form class="logout-form" onsubmit="logout(event)">
                                            @csrf
                                            <button type="submit" class="dropdown-item" id="logout-btn">
                                                <i class="fa fa-sign-out"></i> Đăng xuất
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <button id="loginButton" class="no-border"><i class="fa fa-user"></i> Đăng nhập</button>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <section class="hero hero-normal">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="{{route('shop.search')}}" method="GET">
                                @csrf
                                <div class="hero__search__categories">
                                    <span class="category-display">All Categories</span>
                                    <span class="arrow_carrot-down"></span>
                                    <div class="hero__search__categories-menu">
                                        <ul>
                                            <li><a onclick="selectCategory(this); return false;">All Categories</a></li>
                                            @foreach($categories as $category)
                                                @if($category->id_danhmuc_cha == null)
                                                    <li class="has-children">
                                                        <a onclick="selectCategory(this, {{$category->id_danhmuc}}); return false;">
                                                            {{ $category->tendanhmuc }}
                                                        </a>
                                                        @if($category->childCategories->count() > 0)
                                                            <ul class="submenu">
                                                                @foreach($category->childCategories as $child)
                                                                    <li>
                                                                        <a onclick="selectCategory(this, {{$child->id_danhmuc}}); return false;">
                                                                            {{ $child->tendanhmuc }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <input type="hidden" name="id_category" value="">
                                <input type="text" placeholder="What do you need?" name="keyword">
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>{{App\Models\WebsiteInfo::first()->phone}}</h5>
                                <span>support 24/7 time</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->
