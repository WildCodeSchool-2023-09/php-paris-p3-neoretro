const fields = document.querySelectorAll("input");

function focusField(fields) {
    for (let field of fields) {
        let placeholder = field.placeholder;
        field.addEventListener('focusin', function() {
            field.setAttribute('placeholder', '//');
        });
        field.addEventListener('focusout', function(){
            field.setAttribute('placeholder', placeholder);
        });
    }
}

focusField(fields);
