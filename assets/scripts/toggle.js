const isVisibleToggle = document.querySelector('#toggle input.switch');
const isVisibleInput = document.querySelector('input#game_search_isVisible');

isVisibleToggle.addEventListener('click', function() {
    isVisibleToggle.classList.toggle('checked');
    
    if (isVisibleToggle.classList.contains('checked')) {
        isVisibleInput.setAttribute('value', 1);
    }
    else {
        isVisibleInput.setAttribute('value', 0);
    }
})