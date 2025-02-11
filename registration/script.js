// Get references to elements
const resetPasswordBtn = document.getElementById('resetPasswordBtn');
const forgotPasswordDiv = document.getElementById('forgotPasswordDiv');
const newPasswordDiv = document.getElementById('newPasswordDiv');
const emailInput = document.getElementById('email');
const emailError = document.getElementById('emailError');
const confirmButton = document.querySelector('#newPasswordDiv button');
const signPassword = document.getElementById('signupPassword')

// Add click event listener to the Reset Password button
resetPasswordBtn.addEventListener('click', function () {
    const email = emailInput.value.trim(); // Get the trimmed email value

    // Email validation regex pattern
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    // Validate email input
    if (email === '') {
        alert('Please enter your email.');
        return;
    } else if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        return;
    }

    // Hide the first div
    forgotPasswordDiv.style.display = 'none';
    // Show the second div
    newPasswordDiv.style.display = 'block';
});

// Add click event listener to the Confirm button
confirmButton.addEventListener('click', function () {
    const newPassword = document.getElementById('new_password').value.trim();
    const confirmPassword = document.getElementById('con_password').value.trim();
    const signupPassword = document.getElementById('password').value.trim();

    // Check if both passwords match
    if (newPassword === '' || confirmPassword === '') {
        alert('Please fill out both password fields.');
        return;
    }

    if (newPassword.length < 8) {
        alert('Password must be at least 8 characters long.');
        return;
    }
    if (newPassword !== confirmPassword) {
        alert('Passwords do not match. Please try again.');
        return;
    }

    // Display success message
    alert('Password reset successfully!');

    // Redirect to login page after 2 seconds
    setTimeout(() => {
        window.location.href = 'login.html'; // Change to your login page URL
    }, 500);
});
