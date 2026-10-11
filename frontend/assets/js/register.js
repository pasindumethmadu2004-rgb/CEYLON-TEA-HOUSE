
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registerForm');
    if (!form) return;

    const firstName = document.getElementById('firstName');
    const lastName = document.getElementById('lastName');
    const email = document.getElementById('registerEmail');
    const password = document.getElementById('registerPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const terms = document.getElementById('terms');

    // Keep the existing page's message area if it has one.
    function showMessage(text, type) {
        let message = document.getElementById('registerMessage');

        if (!message) {
            message = document.createElement('p');
            message.id = 'registerMessage';
            message.setAttribute('role', 'status');
            form.prepend(message);
        }

        message.innerText = text;
        message.className = 'register-message ' + type;
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const first = firstName.value.trim();
        const last = lastName.value.trim();
        const mail = email.value.trim().toLowerCase();
        const pass = password.value;
        const confirm = confirmPassword.value;

        if (!first || !last || !mail || !pass || !confirm) {
            showMessage('Please fill in all required fields.', 'error');
            return;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(mail)) {
            showMessage('Please enter a valid email address.', 'error');
            return;
        }

        if (pass.length < 8) {
            showMessage('Password must be at least 8 characters.', 'error');
            return;
        }

        if (new TextEncoder().encode(pass).length > 72) {
            showMessage('Password is too long. Please use a shorter password.', 'error');
            return;
        }

        if (pass !== confirm) {
            showMessage('Passwords do not match.', 'error');
            return;
        }

        if (terms && !terms.checked) {
            showMessage('Please accept the terms and conditions.', 'error');
            return;
        }

        const button = form.querySelector('[type="submit"]');
        if (button) button.disabled = true;

        try {
            const response = await fetch('../../../backend/api/register.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'same-origin',
                body: JSON.stringify({
                    firstName: first,
                    lastName: last,
                    email: mail,
                    password: pass
                })
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                showMessage(result.message || 'Registration failed.', 'error');
                return;
            }

            showMessage('Registration successful! Redirecting to login...', 'success');

            setTimeout(() => {
                window.location.href = 'login.php';
            }, 800);

        } catch (error) {
            showMessage('Unable to connect. Please try again.', 'error');
        } finally {
            if (button) button.disabled = false;
        }
    });
});
