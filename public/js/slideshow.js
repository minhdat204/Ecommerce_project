const slides = document.querySelectorAll('.hero__item');
const dots = document.querySelectorAll('.hero__nav-dot');
let currentSlide = 0;
let slideInterval;

function showSlide(index) {
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));

    slides[index].classList.add('active');
    dots[index].classList.add('active');
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

function startSlideshow() {
    slideInterval = setInterval(nextSlide, 5000);
}

// Add click events to dots
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        currentSlide = index;
        showSlide(currentSlide);
        clearInterval(slideInterval);
        startSlideshow();
    });
});

// Start slideshow
startSlideshow();
