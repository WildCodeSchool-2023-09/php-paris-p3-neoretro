import { setVerticalCarousel } from "./carousel-functions";

const slideHeight = document.querySelector("li.slide").clientHeight + 50;
const carousel = document.querySelector("ul.carousel");
const sliderBtns = document.querySelectorAll('nav.slider .slider-btn');

setVerticalCarousel(slideHeight, carousel, sliderBtns, 'current-slide', 500);

let scrollTimer;
carousel.addEventListener('scroll', function() {
    clearTimeout(scrollTimer);
    // carousel.style.transition = "mask-image .5s ease";
    carousel.style.maskImage = "linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 1) 1%, rgba(0, 0, 0, 1) 99%, transparent 100%)";
    scrollTimer = setTimeout(function() {
        carousel.style.maskImage = "linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 1) 100%, transparent 100%)";
    }, 200);
});