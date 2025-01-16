<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>@yield('title')</h2>
                    <div class="breadcrumb__option">
                        @php
                            $segments = request()->segments();
                            $url = '';
                        @endphp
                        <a href="{{ url('/') }}">Home</a>
                        @foreach($segments as $segment)
                            @php $url .= '/'.$segment; @endphp
                            <span>
                                @if(!$loop->last)
                                    <a href="{{ url($url) }}">{{ ucfirst($segment) }}</a>
                                @else
                                    {{ ucfirst($segment) }}
                                @endif
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
