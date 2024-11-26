@extends('users.layouts.layout')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/loseweight.css')}}">
@endpush
@section('content')
<!-- Lose-weight Section Begin -->
<section class="py-5">
    <div class="container-loseweight">
        <div class="page-divider"></div>
        <div class="row">
            <div class="loseweight-column">
                <div class="loseweight-tittle">
                    <h1>Create a Calorie Deficit</h1>
                </div>
            </div>
            <div class="loseweight-column" style="box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);">
                <div class="loseweight-content">
                    <p>The most fundamental principle for weight loss is creating a calorie deficit, meaning you consume fewer calories than your body needs to maintain its current weight. This can be achieved by either reducing the number of calories you eat or increasing the number of calories you burn through exercise.</p>
                </div>
            </div>
            <div class="loseweight-column">
                <img src="img/cart/cart-1.jpg" alt=""  style="width: 400px; height: 200px;">
            </div>
        </div>
        <div class="page-divider"></div>
        <div class="row">
            <div class="loseweight-column">
                <div class="loseweight-tittle">
                    <h1>Eat a Balanced Diet</h1>
                </div>
            </div>
            <div class="loseweight-column" style="box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);">
                <div class="loseweight-content">
                    <p>It's important to focus on eating a well-rounded diet that includes a variety of nutrient-dense foods. A balanced diet provides the necessary vitamins, minerals, protein, fiber, and healthy fats your body needs for optimal function.</p>
                </div>
            </div>
            <div class="loseweight-column">
                <img src="img/cart/cart-2.jpg" alt=""  style="width: 400px; height: 200px;">
            </div>
        </div>
        <div class="page-divider"></div>
        <div class="row">
            <div class="loseweight-column">
                <div class="loseweight-tittle">
                    <h1>Exercise Regularly</h1>
                </div>
            </div>
            <div class="loseweight-column" style="box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);">
                <div class="loseweight-content">
                    <p>Regular physical activity not only helps burn calories but also improves overall health and well-being. Exercise builds muscle, boosts metabolism, and can help regulate hunger hormones.</p>
                </div>
            </div>
            <div class="loseweight-column">
                <img src="img/cart/cart-3.jpg" alt=""  style="width: 400px; height: 200px;">
            </div>
        </div>
        <div class="page-divider"></div>
        <div class="row">
            <div class="loseweight-column">
                <div class="loseweight-tittle">
                    <h1>Exercise Regularly</h1>
                </div>
            </div>
            <div class="loseweight-column" style="box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);">
                <div class="loseweight-content">
                    <p>Both sleep and stress have a significant impact on weight loss. Poor sleep and chronic stress can interfere with hormones that control hunger and fat storage.</p>
                </div>
            </div>
            <div class="loseweight-column">
                <img src="img/blog/blog-5.jpg" alt=""  style="width: 400px; height: 200px;">
            </div>
        </div>
    </div>
</section>
<!-- Lose-weight Section End -->
@endsection