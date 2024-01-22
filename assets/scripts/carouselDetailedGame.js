import { setVerticalCarousel, setHorizontalCarousel } from "./carousel";

// SLIDER BTN DETAILED GAME

const slideHeight = document.querySelector("#detailed-game-one").clientHeight + 50;
const carousel = document.querySelector(".carousel");
const sliderBtns = document.querySelectorAll('.slider .slider-btn');

setVerticalCarousel(slideHeight, carousel, sliderBtns, 'current-slide', 380);

// SLIDER BTN PICTURE

const carouselPicture = document.querySelector("#carousel-pictures");
const sliderPictureBtns = document.querySelectorAll("#slider-pictures .slider-picture-btn");

if (window.matchMedia("(min-width: 1366px)").matches) {

    // DESKTOP - NORMAL SLIDER (VERTICAL)
    const slidePictureHeight = document.querySelector("li.pictures").clientHeight + 24;

    setVerticalCarousel(slidePictureHeight, carouselPicture, sliderPictureBtns, "current-slide-picture", 180);

} else {

    // MOBILE - HORIZONTAL SLIDER
    const slidePictureWidth = document.querySelector("li.pictures").clientWidth + 24;

    setHorizontalCarousel(slidePictureWidth, carouselPicture, sliderPictureBtns, "current-slide-picture", 180);
}
