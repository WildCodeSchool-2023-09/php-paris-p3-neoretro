// CAROUSEL FUNCTIONS

export function setVerticalCarousel(slideHeight, carousel, sliderBtns, currentSlide, classCurrentSlide, responseTime) {
    for (let i = 0 ; i < sliderBtns.length ; i++) {
        sliderBtns[i].addEventListener("click", () => {
            carousel.scrollTo({
                top: slideHeight * i
            });
            document.querySelector(classCurrentSlide).classList.toggle(currentSlide);
            sliderBtns[i].classList.toggle(currentSlide);
        });
    }
    
    carousel.addEventListener("scroll", function(e) {
        setTimeout(function() {
            for (let i = 0 ; i < sliderBtns.length ; i++) {
                if (carousel.scrollTop == slideHeight * i) {
                    document.querySelector(classCurrentSlide).classList.toggle(currentSlide);
                    sliderBtns[i].classList.toggle(currentSlide);
                }
            }
        }, responseTime);
    });
}

export function setHorizontalCarousel(slideWidth, carousel, sliderBtns, currentSlide, classCurrentSlide, responseTime) {
    for (let i = 0 ; i < sliderBtns.length ; i++) {
        sliderBtns[i].addEventListener("click", () => {
            carousel.scrollTo({
                left: slideWidth * i
            });
            document.querySelector(classCurrentSlide).classList.toggle(currentSlide);
            sliderBtns[i].classList.toggle(currentSlide);
        });
    }

    carousel.addEventListener("scroll", function(e) {
        setTimeout(function() {
            for (let i = (sliderBtns.length - 1) ; i >= 0 ; i--) {
                if (carousel.scrollLeft == slideWidth * i) {
                    document.querySelector(classCurrentSlide).classList.toggle(currentSlide);
                    sliderBtns[i].classList.toggle(currentSlide);
                }
            }
        }, responseTime);
    });
}
