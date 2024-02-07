const usernameField = document.querySelector("input#username");
const passwordField = document.querySelector("input#password");

function focusField(field) {
    let placeholder = field.placeholder;
    field.addEventListener('focusin', function() {
        field.setAttribute('placeholder', '//');
    });
    field.addEventListener('focusout', function(){
        field.setAttribute('placeholder', placeholder);
    });
}

focusField(usernameField);
focusField(passwordField);