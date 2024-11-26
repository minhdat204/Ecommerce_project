@extends('users.layouts.layout')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/history.css')}}">
@endpush
@section('content')

<!-- History Section Begin -->
<section class="py-5">
    <div class="container-history">
        <section class="history-section">
            <div class="history">
                <div class="history-item">
                    <div class="history-year">2004</div>
                    <div class="history-content">
                        <h1>Get Started</h1>
                        <p>We started with a small farm, driven by a belief in clean and sustainable food.</p>
                    </div>
                </div>

                <div class="history-arrow"></div>
                <div class="history-item">
                    <div class="history-year">2010 - 2020</div>
                    <div class="history-content">
                        <h1>Development stage</h1>
                        <p>We expanded production and focused on developing organic products, ensuring quality and sustainability.</p>
                    </div>

                </div>
                <div class="history-arrow"></div>
                <div class="history-item">
                    <div class="history-year">2021 - 2023</div>
                    <div class="history-content">
                        <h1>First Product Launched</h1>
                        <p>Our first organic juice product quickly became a customer favorite.</p>
                    </div>
                </div>

                <div class="history-arrow"></div>
                <div class="history-item">
                    <div class="history-year">Present</div>
                    <div class="history-content">
                        <h1>Future Plans</h1>
                        <p>With over 500 partners worldwide, we remain committed to health and sustainability.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<!-- History Section Begin -->
@endsection
