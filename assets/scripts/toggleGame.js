document.addEventListener('DOMContentLoaded', function() {
    const isVisibleToggle = document.querySelector('.toggle-flex input.switch');
    const isVisibleInput = document.querySelector('input#game_search_isVisible');
    // const form = document.querySelector('#toggle-form');

    if (isVisibleInput.value === '1') {
        isVisibleToggle.classList.add('checked');
    } else {
        isVisibleToggle.classList.remove('checked');
    }

    isVisibleToggle.addEventListener('click', function() {
        isVisibleToggle.classList.toggle('checked');

        if (isVisibleToggle.classList.contains('checked')) {
            isVisibleInput.setAttribute('value', 1);
        } else {
            isVisibleInput.setAttribute('value', 0);
        }

        form.submit();
    });
});


