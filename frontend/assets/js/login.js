
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const message = document.getElementById('loginMessage');
    const toggle = document.getElementById('togglePassword');

    function showMessage(text, type = 'error') {
        if (!message) {
            alert(text);
            return;
        }

        message.textContent = text;
        message.className = 'login-message ' + type;
    }

    // Show or hide password
    if (toggle && password) {
        toggle.addEventListener('click', () => {
            const show = password.type === 'password';

            password.type = show ? 'text' : 'password';
            toggle.textContent = show ? '🙈' : '👁';
        });
    }

    if (!form || !email || !password) {
        console.error('Login form elements were not found.');
        return;
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const emailValue = email.value.trim().toLowerCase();
        const passwordValue = password.value;

        if (!emailValue || !passwordValue) {
            showMessage('Please enter your email and password.');
            return;
        }

        const button = form.querySelector('[type="submit"]');

        if (button) {
            button.disabled = true;
        }

        try {
            const response = await fetch(
                '/CEYLON-TEA-HOUSE/backend/api/login.php',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        email: emailValue,
                        password: passwordValue
                    })
                }
            );

            const result = await response.json();

            if (!response.ok || !result.success) {
                showMessage(
                    result.message || 'Invalid email or password.'
                );
                return;
            }

            showMessage('Login successful!', 'success');

            // Get the destination saved before login
            const redirect = localStorage.getItem(
                'redirectAfterLogin'
            );

            // Remove old client-side login indicators
            localStorage.removeItem('isLoggedIn');
            localStorage.removeItem('loggedInUser');
            localStorage.removeItem('currentUser');

            // Default destination for a normal login
            let destination =
                '/CEYLON-TEA-HOUSE/frontend/index.php';

            // If the customer came from checkout, return there
            if (
                redirect &&
                redirect.startsWith('/CEYLON-TEA-HOUSE/') &&
                !redirect.startsWith('//')
            ) {
                destination = redirect;
            }

            // Remove the saved destination after reading it
            localStorage.removeItem('redirectAfterLogin');

            setTimeout(() => {
                window.location.href = destination;
            }, 500);

        } catch (error) {
            console.error('Login error:', error);

            showMessage(
                'Unable to connect. Please check XAMPP and try again.'
            );
        } finally {
            if (button) {
                button.disabled = false;
            }
        }
    });
});
