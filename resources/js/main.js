// Check auth on each page refresh and sync state/local storage
require('Helpers/auth');
require('./bootstrap');
require('./lib/vue');

[].map.call(document.querySelectorAll('.accessible-input'), function (input) {
    input.addEventListener('focus', function (event) {
        input.parentNode.classList.remove('accessible-input-container')
        input.parentNode.classList.add('accessible-input-container-active')
    });
    input.addEventListener('blur', function (event) {
        input.parentNode.classList.remove('accessible-input-container-active')
        input.parentNode.classList.add('accessible-input-container')
    });
});
