@extends('users.layouts.layout')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/aboutUs.css')}}">
@endpush
@section('content')
<!-- About-us Section Begin -->
<section class="py-5">
	<div class="container-aboutUs">
        <div class="image-section">
            <img src="/img/categories/cat-3.jpg" alt="aboutUs">
        </div>
        <div class="aboutUs-section" >
            <h1>Organic Website - ABOUT US</h1>
			<p>Organi Website is located at 65 Đ. Huỳnh Thúc Kháng, Bến Nghé, Quận 1, Hồ Chí Minh, Vietnam. </p>
			<p>We specialize in the production and distribution of organic fruits, vegetables, and meats, ensuring the highest standards of quality. </p>
			<p>At Organi, we are committed to customer satisfaction, which is why we implement clear policies such as Quality Assurance, where all products are certified organic and rigorously tested; Eco-Friendly Packaging, using biodegradable materials to reduce environmental impact; and a Flexible Return Policy, allowing customers to shop with confidence. We are proud to support sustainable practices while delivering premium organic products.</p>
		</div>
    </div>
</section>
<!-- About-us Section End -->
@endsection