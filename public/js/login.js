document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('login-form');

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // const errors = validateForm(email, password);

        const errors = {};

        if (!validateEmail(email)) {
            errors['email'] = 'Невалиден имейл адрес!';
        }

        if (password.length < 6) {
            errors['password'] = 'Паролата трябва да е поне 6 символа дълга!';
        }

        displayErrors(errors);

        if (Object.keys(errors).length === 0) {
            try {
                const response = await submitLoginForm(email, password);

                if (response && response.success) {
                    window.location.href = 'home_user.php';
                } else {
                    displayServerErrors(response ? response.errors : { server: 'Server error' });
                }
            } catch (error) {
                console.error('Error during form submission:', error);
                displayServerErrors({ server: 'Unexpected error' });
            }
        }
    });

    // function validateForm(email, password) {
    //     const errors = {};

    //     if (!validateEmail(email)) {
    //         errors['email'] = 'Невалиден имейл адрес!';
    //     }

    //     if (password.length < 6) {
    //         errors['password'] = 'Паролата трябва да е поне 6 символа дълга!';
    //     }

    //     return errors;
    // }

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

    async function submitLoginForm(email, password) {
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        try {
            const response = await fetch('../../src/login_credentials.php', {
                method: 'POST',
                body: formData,
            });

            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Server error');
            }
        } catch (error) {
            console.error('Error during form submission:', error);
            return { success: false, errors: { server: 'Server error' } };
        }
    }

    function displayServerErrors(serverErrors) {
        displayErrors(serverErrors);
        // displayError('erroremail', serverErrors['email']);
        // displayError('errorpassword', serverErrors['password']);
    }
});
