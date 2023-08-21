document.getElementById('login-form').addEventListener('submit', function(event) {
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const errorMessage = document.getElementById('error-message');

    errorMessage.innerHTML = ''; // Clear any previous error messages

    // Example: Check if the email and password match some predefined values
    const validEmail = 'user@example.com';
    const validPassword = 'password123';

    if (emailField.value !== validEmail || passwordField.value !== validPassword) {
        appendErrorMessage("Invalid email or password.");
        event.preventDefault(); // Prevent form submission
    }
});

function appendErrorMessage(message) {
    const errorMessage = document.getElementById('error-message');
    const errorMessageElement = document.createElement('p');
    errorMessageElement.textContent = message;
    errorMessage.appendChild(errorMessageElement);
}