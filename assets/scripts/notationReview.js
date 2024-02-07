const inputNotation = document.querySelector(".input-notation");
const firstStar = document.getElementById("first-star");
const firstStarSolid = document.getElementById("first-star-solid");
const secondStar = document.getElementById("second-star");
const secondStarSolid = document.getElementById("second-star-solid");
const thirdStar = document.getElementById("third-star");
const thirdStarSolid = document.getElementById("third-star-solid");
const fourthStar = document.getElementById("fourth-star");
const fourthStarSolid = document.getElementById("fourth-star-solid");
const fifthStar = document.getElementById("fifth-star");
const fifthStarSolid = document.getElementById("fifth-star-solid");

inputNotation.setAttribute('value', 0);

firstStar.addEventListener("click", () => {
    firstStar.style.display = "none";
    firstStarSolid.style.display = "block";
    secondStar.style.display = "block";
    secondStarSolid.style.display = "none";
    thirdStar.style.display = "block";
    thirdStarSolid.style.display = "none";
    fourthStar.style.display = "block";
    fourthStarSolid.style.display = "none";
    fifthStar.style.display = "block";
    fifthStarSolid.style.display = "none";
    inputNotation.setAttribute("value", 1);
});

firstStarSolid.addEventListener("click", () => {
    firstStar.style.display = "none";
    firstStarSolid.style.display = "block";
    secondStar.style.display = "block";
    secondStarSolid.style.display = "none";
    thirdStar.style.display = "block";
    thirdStarSolid.style.display = "none";
    fourthStar.style.display = "block";
    fourthStarSolid.style.display = "none";
    fifthStar.style.display = "block";
    fifthStarSolid.style.display = "none";
    inputNotation.setAttribute("value", 1);
});

secondStar.addEventListener("click", () => {
    firstStar.style.display = "none";
    firstStarSolid.style.display = "block";
    secondStar.style.display = "none";
    secondStarSolid.style.display = "block";
    thirdStar.style.display = "block";
    thirdStarSolid.style.display = "none";
    fourthStar.style.display = "block";
    fourthStarSolid.style.display = "none";
    fifthStar.style.display = "block";
    fifthStarSolid.style.display = "none";
    inputNotation.setAttribute("value", 2);
});

secondStarSolid.addEventListener("click", () => {
    firstStar.style.display = "none";
    firstStarSolid.style.display = "block";
    secondStar.style.display = "none";
    secondStarSolid.style.display = "block";
    thirdStar.style.display = "block";
    thirdStarSolid.style.display = "none";
    fourthStar.style.display = "block";
    fourthStarSolid.style.display = "none";
    fifthStar.style.display = "block";
    fifthStarSolid.style.display = "none";
    inputNotation.setAttribute("value", 2);
});

thirdStar.addEventListener("click", () => {
    firstStar.style.display = "none";
    firstStarSolid.style.display = "block";
    secondStar.style.display = "none";
    secondStarSolid.style.display = "block";
    thirdStar.style.display = "none";
    thirdStarSolid.style.display = "block";
    fourthStar.style.display = "block";
    fourthStarSolid.style.display = "none";
    fifthStar.style.display = "block";
    fifthStarSolid.style.display = "none";
    inputNotation.setAttribute("value", 3);
});

thirdStarSolid.addEventListener("click", () => {
    firstStar.style.display = "none";
    firstStarSolid.style.display = "block";
    secondStar.style.display = "none";
    secondStarSolid.style.display = "block";
    thirdStar.style.display = "none";
    thirdStarSolid.style.display = "block";
    fourthStar.style.display = "block";
    fourthStarSolid.style.display = "none";
    fifthStar.style.display = "block";
    fifthStarSolid.style.display = "none";
    inputNotation.setAttribute("value", 3);
});

fourthStar.addEventListener("click", () => {
    firstStar.style.display = "none";
    firstStarSolid.style.display = "block";
    secondStar.style.display = "none";
    secondStarSolid.style.display = "block";
    thirdStar.style.display = "none";
    thirdStarSolid.style.display = "block";
    fourthStar.style.display = "none";
    fourthStarSolid.style.display = "block";
    fifthStar.style.display = "block";
    fifthStarSolid.style.display = "none";
    inputNotation.setAttribute("value", 4);
});

fourthStarSolid.addEventListener("click", () => {
    firstStar.style.display = "none";
    firstStarSolid.style.display = "block";
    secondStar.style.display = "none";
    secondStarSolid.style.display = "block";
    thirdStar.style.display = "none";
    thirdStarSolid.style.display = "block";
    fourthStar.style.display = "none";
    fourthStarSolid.style.display = "block";
    fifthStar.style.display = "block";
    fifthStarSolid.style.display = "none";
    inputNotation.setAttribute("value", 4);
});

fifthStar.addEventListener("click", () => {
    firstStar.style.display = "none";
    firstStarSolid.style.display = "block";
    secondStar.style.display = "none";
    secondStarSolid.style.display = "block";
    thirdStar.style.display = "none";
    thirdStarSolid.style.display = "block";
    fourthStar.style.display = "none";
    fourthStarSolid.style.display = "block";
    fifthStar.style.display = "none";
    fifthStarSolid.style.display = "block";
    inputNotation.setAttribute("value", 5);
});

fifthStarSolid.addEventListener("click", () => {
    firstStar.style.display = "none";
    firstStarSolid.style.display = "block";
    secondStar.style.display = "none";
    secondStarSolid.style.display = "block";
    thirdStar.style.display = "none";
    thirdStarSolid.style.display = "block";
    fourthStar.style.display = "none";
    fourthStarSolid.style.display = "block";
    fifthStar.style.display = "none";
    fifthStarSolid.style.display = "block";
    inputNotation.setAttribute("value", 5);
});
