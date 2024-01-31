import { setVerticalCarousel } from "./carousel";

const slideHeight = document.querySelector(".games").clientHeight + 50;
const carousel = document.querySelector(".carousel");
const sliderBtns = document.querySelectorAll('.slider .slider-btn');

setVerticalCarousel(slideHeight, carousel, sliderBtns, 'current-slide', 380);