document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('register-form');

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        // Validate email, username, password, repeat_password fields using JavaScript
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

        // Check if passwords match
        if (password !== repeatPassword) {
            errors['repeat_password'] = 'Паролите не съвпадат!';
        }

        // Display errors if any
        displayErrors(errors);

        // If there are no errors, submit the form
        if (Object.keys(errors).length === 0) {
            try {
                const response = await submitForm(email, username, password, repeatPassword);

                if (response && response.success) {
                    // Registration successful, redirect or display a success message
                    window.location.href = 'home_user.php';
                } else {
                    // Registration failed, display error messages
                    displayServerErrors(response ? response.errors : { server: 'Server error' });
                }
            } catch (error) {
                // Handle unexpected errors
                console.error('Unexpected error:', error);
                displayServerErrors({ server: 'Unexpected error' });
            }
        }

        event.preventDefault();

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

    async function submitForm(email, username, password, repeatPassword) {
        const formData = new FormData();
        formData.append('email', email);
        formData.append('username', username);
        formData.append('password', password);
        formData.append('repeat_password', repeatPassword);

        try {
            const response = await fetch('/src/registration_credentials.php', {
                method: 'POST',
                body: formData,
            });
    
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Server error');
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            return { success: false, errors: { server: 'Server error' } };
        }
    }

    function displayServerErrors(serverErrors) {
        // Display server-side errors as needed
        // You can update your error display logic here
        displayErrors(serverErrors);
    }
});
