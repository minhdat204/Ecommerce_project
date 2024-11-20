<!-- Contact Form Begin -->
<div class="contact-form spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="contact__form__title">
                    <h2>Leave Message</h2>
                </div>
            </div>
        </div>
        <form action="{{route('client.contact.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <input type="text" name="ten" placeholder="Your name" required>
                </div>
                <div class="col-lg-6 col-md-6">
                    <input type="text" name="email" placeholder="Your Email" required>
                </div>
                <div class="col-lg-12 text-center">
                    <textarea name="noidung" placeholder="Your message" required></textarea>
                    <button type="submit" class="site-btn">SEND MESSAGE</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Contact Form End -->
