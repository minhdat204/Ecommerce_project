<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                    <a href="{{ url('/') }}">
                            <img src="{{ $websiteInfo->logo_image ? asset('storage/' . $websiteInfo->logo_image) : asset('img/logo.png') }}" alt="Logo">
                    </a>
                    </div>
                    <p>{{ $websiteInfo->content ?? 'Ogani là một công ty chuyên cung cấp thực phẩm sạch...' }}</p>
                    <div class="footer__widget">
                        <div class="footer__widget__social">
                            <a href="{{ $websiteInfo->facebook_link ?? '#' }}"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Useful Links</h6>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Shop</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                    <ul>
                        <li><a href="#">Fresh Meat</a></li>
                        <li><a href="#">Vegetable</a></li>
                        <li><a href="#">Fruit & Nut Gifts</a></li>
                        <li><a href="#">Fresh Berries</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer__about">
                    <h6>Contact Us</h6>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Address: {{ $websiteInfo->address ?? 'Updating...' }}</li>
                        <li><i class="fas fa-phone"></i> Phone: {{ $websiteInfo->phone ?? 'Updating...' }}</li>
                        <li><i class="fas fa-envelope"></i> Email: {{ $websiteInfo->email ?? 'Updating...' }}</li>
                    </ul>
                </div>
            </div>
        </div>
        
    </div>
</footer>
<!-- Footer Section End -->
