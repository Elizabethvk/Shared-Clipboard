document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('register-form');

    form.addEventListener('submit', function (event) {
        // Validate email, username, password, repeat_password fields using JavaScript
        const email = document.getElementById('email').value;
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const repeatPassword = document.getElementById('repeat_password').value;

        const errors = {};

        // Validate email
        if (!validateEmail(email)) {
            errors['email'] = 'Invalid email address';
        }

        // Validate username
        if (username.trim() === '') {
            errors['username'] = 'Username is required';
        }

        // Validate password
        if (password.length < 6) {
            errors['password'] = 'Password must be at least 6 characters long';
        }

        // Check if passwords match
        if (password !== repeatPassword) {
            errors['repeat_password'] = 'Passwords do not match';
        }

        // Display errors if any
        displayErrors(errors);

        // Prevent form submission if there are errors
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
        displayError('errorusername', errors['username']);
        displayError('errorpassword', errors['password']);
        displayError('errorrepeat_password', errors['repeat_password']);
    }

    function displayError(elementId, errorMessage) {
        const errorElement = document.getElementById(elementId);
        errorElement.innerText = errorMessage || '';
    }
});
