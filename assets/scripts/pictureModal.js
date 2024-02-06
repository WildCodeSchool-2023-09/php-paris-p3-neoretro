// Get the modal
const modal = document.getElementById("picture-modal");

// Get the images and insert it inside the modal
const img = document.querySelectorAll("li.pictures > img");
const modalImg = document.getElementById("img-modal");
for (let i = 0 ; i < img.length ; i++) {
    img[i].addEventListener("click", () => {
        modal.style.display = "block";
        modalImg.src = img[i].src;
    });
}

// Get the <span> element that closes the modal
const span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.addEventListener("click", () => {
    modal.style.display = "none";
});

// When the user click around the modal, close the modal
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});
