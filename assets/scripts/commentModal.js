document.addEventListener('DOMContentLoaded', () => {
    const doc = document.querySelector('.carousel');
    const trigger = document.querySelector('[aria-haspopup="dialog"]');
    const dialog = document.getElementById(trigger.getAttribute('aria-controls'));
    const dismissTrigger = dialog.querySelector('[data-dismiss]');
    const commentBox = document.querySelector('.comment-box');

    // Function to display the modal with animation
    const open = function (dialog, box) {
        box.classList.add("animation-zoom");
        dialog.setAttribute('aria-hidden', false);
        doc.setAttribute('aria-hidden', true);
    };

    // Function to hide the modal and remove animation
    const close = function (dialog, box) {
        dialog.setAttribute('aria-hidden', true);
        doc.setAttribute('aria-hidden', false);
        box.classList.remove("animation-zoom");
    };

    // Open dialog
    trigger.addEventListener('click', (event) => {
        event.preventDefault();

        open(dialog, commentBox);
    });

    // Close dialog when user click on <span X or around the modal
    const dismissDialog = document.getElementById(dismissTrigger.dataset.dismiss);
    
    dismissTrigger.addEventListener('click', (event) => {
        event.preventDefault();

        close(dismissDialog, commentBox);
    });

    window.addEventListener('click', (event) => {
        if (event.target === dialog) {
            close(dialog, commentBox);
        }
    });
});
