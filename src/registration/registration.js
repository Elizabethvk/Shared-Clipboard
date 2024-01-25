document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('register-form');

    form.addEventListener('submit', function (event) {
        const email = document.getElementById('email').value;
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const repeatPassword = document.getElementById('repeat_password').value;

        const errors = {};

        // Validate email
        if (!validateEmail(email)) {
            errors['email'] = 'Невалиден имейл адрес!';
        }

        // Validate username
        if (username.trim() === '') {
            errors['username'] = 'Трябва да се въведе никнейм!';
        }

        // Validate password
        if (password.length < 6) {
            errors['password'] = 'Паролата трябва да е поне 6 символа дълга!';
        }

        if (!validatePassword(password)) {
            errors['password'] = 'Паролата трябва да съдържа поне една главна буква, една малка буква, една цифра и специален символ!';
        }

        // Check if passwords match
        if (password !== repeatPassword) {
            errors['repeat_password'] = 'Паролите не съвпадат!';
        }

        // Display errors if any
        displayErrors(errors);

        // If there are no errors, the form will submit naturally
        if (Object.keys(errors).length > 0) {
            event.preventDefault();
        }
    });

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+|[^\s@]+@[^\s@]+\.[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validatePassword(password) {
        // const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/;
        const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[.!@#$%^&*])[A-Za-z\d.!@#$%^&*]+$/;
        return passwordRegex.test(password);
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