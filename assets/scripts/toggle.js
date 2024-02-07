function toggleInput(toggleSelector, inputSelector, formSelector)
{
    const isVisibleToggle = document.querySelector(toggleSelector);
    const isVisibleInput = document.querySelector(inputSelector);
    const form = document.querySelector(formSelector);

    isVisibleToggle.addEventListener('click', function() {
        isVisibleToggle.classList.toggle('checked');
        
        if (isVisibleToggle.classList.contains('checked')) {
            isVisibleInput.setAttribute('value', 1);
        }
        else {
            isVisibleInput.setAttribute('value', 0);
        }

        form.submit();
    })
}

toggleInput('#toggle input.switch', 'input.isVisible', 'form');
