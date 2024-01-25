document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('login-form');

    form.addEventListener('submit', function (event) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const errors = {};

        // Validate email
        if (!validateEmail(email)) {
            errors['email'] = 'Невалиден имейл адрес!';
        }

        // Validate password
        if (password.length < 6) {
            errors['password'] = 'Паролата трябва да е поне 6 символа дълга!';
        }

        // Display errors if any
        displayErrors(errors);

        // Prevent the form from submitting if there are errors
        if (Object.keys(errors).length > 0) {
            event.preventDefault();
        }
    });

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+|[^\s@]+@[^\s@]+\.[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function displayErrors(errors) {
        displayError('erroremail', errors['email']);
        displayError('errorpassword', errors['password']);
    }

    function displayError(elementId, errorMessage) {
        const errorElement = document.getElementById(elementId);
        errorElement.innerText = errorMessage || '';
    }
});
