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

function toggleSorting(buttonSelector, targetSelector = buttonSelector + ' img', inputValue) {
    const button = document.querySelector(buttonSelector);
    const target = document.querySelector(targetSelector);
    const sortBy = document.querySelector('input#game_search_sort_by');
    const sortOrder = document.querySelector('input#game_search_sort_order');

    // SET UPSIDE DOWN ON LOAD IF NEEDED
    if (sortBy.value == inputValue && sortOrder.value == 'ASC') {
        target.classList.toggle('reversed');
    }

    button.addEventListener('click', function() {
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

// USING FUNCTIONS

toggleDisplay('.btn.settings', '#search-modal', 'flex');
toggleDisplay('.filter p', '.filter .params#category', 'block');

toggleSorting('.sort.title', '.sort.title img', 'title');
toggleSorting('.sort.score', '.sort.score img', 'score');
toggleSorting('.sort.time', '.sort.time img', 'time');

// SUBMIT FORM ON CLICK

document.querySelector('.btn.search').addEventListener('click', function() {
    document.querySelector('form#searchbar').submit();
})
