import axios from "axios";
$(function () {

}).on('click', '#submit', function(e) {
    e.preventDefault();

    var url = APP_URL + 'signIn';
    var data = new FormData($('#formAuthentication')[0]); // Retrieve the FormData instance
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

    axios.post(url, data) // Pass the FormData directly
        .then(response => {
            console.log(response.data); // Log the response data
            window.location.href = APP_URL + 'dashboard'
        })
        .catch(error => {
            if (error.response) {
                console.log('Redirect URL: ', error.response.headers.location); // Check the redirect URL
            }
            console.error(error);
        });
});
