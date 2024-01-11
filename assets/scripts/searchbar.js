// SEARCH BAR

function toggleDisplay(buttonSelector, targetSelector, defaultDisplay) {
    const button = document.querySelector(buttonSelector);
    const target = document.querySelector(targetSelector);
    button.addEventListener('click', function() {
        if (target.classList.contains("hidden")) {
            target.style.display = defaultDisplay;
        }
        else {
            target.style.display = "none";
        }
        target.classList.toggle("hidden");
    });
}

function toggleSorting(buttonSelector, targetSelector, inputValue) {
    const button = document.querySelector(buttonSelector);
    const target = document.querySelector(targetSelector);
    const sortBy = document.querySelector('input#sort-criteria');
    const sortOrder = document.querySelector('input#sort-order');
    button.addEventListener('click', function(){
        target.classList.toggle('reversed');
        sortBy.setAttribute('value', inputValue);
        if (target.className.includes('reversed')) {
            sortOrder.setAttribute('value', 'ASC');
        }
        else {
            sortOrder.setAttribute('value', 'DESC');   
        }
    });
}

toggleDisplay('img.settings', '#search-modal', 'flex');
toggleDisplay('.filter label[for="category"]', '.filter .params#category', 'block');

toggleSorting('.sort.title', '.sort.date img', 'title');
toggleSorting('.sort.score', '.sort.note img', 'score');
toggleSorting('.sort.time', '.sort.reads img', 'time');

const searchField = document.querySelector("#search-field");

searchField.addEventListener('focusin', function() {
    searchField.setAttribute('placeholder', '');
});
searchField.addEventListener('focusout', function(){
    searchField.setAttribute('placeholder', 'Search');
});



// SEARCH IN AJAX

// const ul = document.getElementById('book-list');

// function searchBooks(books) {
//     ul.innerHTML = '';
//     for (book of books) {
//         // console.log(book.title);
//         const li = document.createElement('li');
//         li.innerHTML = book.title;
//         ul.appendChild(li);
//     }
// }

// fetch('/book/global-libraryAJAX')
//         .then(response => response.json())
//         .then(books => searchBooks(books))
//         .catch((err) => console.log(err));

// searchField.addEventListener('input', function(){
//     const searchInput = searchField.value;
//     fetch('/book/global-libraryAJAX?name='+searchInput)
//         .then(response => response.json())
//         .then(books => searchBooks(books))
//         .catch((err) => console.log(err));
// })