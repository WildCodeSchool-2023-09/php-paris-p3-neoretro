import { setVerticalCarousel } from "./carousel-functions";

const slideHeight = document.querySelector("li.slide").clientHeight + 50;
const carousel = document.querySelector("ul.carousel");
const sliderBtns = document.querySelectorAll('nav.slider .slider-btn');

setVerticalCarousel(slideHeight, carousel, sliderBtns, 'current-slide', 500);