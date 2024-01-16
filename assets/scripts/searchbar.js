// SEARCH BAR
console.log('coucou');

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
    const sortBy = document.querySelector('input#sort-by');
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

toggleDisplay('.btn.settings', '#search-modal', 'flex');
toggleDisplay('.filter p', '.filter .params#category', 'block');

toggleSorting('.sort.title', '.sort.title img', 'title');
toggleSorting('.sort.score', '.sort.score img', 'score');
toggleSorting('.sort.time', '.sort.time img', 'time');

const searchField = document.querySelector("input#search-field");

// searchField.addEventListener('focusin', function() {
//     searchField.setAttribute('placeholder', '//');
// });
// searchField.addEventListener('focusout', function(){
//     searchField.setAttribute('placeholder', '{{ field_label(searchForm.title) }}');
// });

document.querySelector('.btn.search').addEventListener('click', function() {
    document.querySelector('form#searchbar').submit();
})