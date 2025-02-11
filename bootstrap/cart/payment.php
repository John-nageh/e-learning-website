<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="cart_style.css">
    <link rel="stylesheet" href="../home/styles.css">
    <link rel="stylesheet" href="payment.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center logo" href="#">
                    <img src="../home/images/logo1.png" alt="Logo" width="50" height="50" class="me-2">
                    <span>E-Learning</span>
                </a>

                <!-- Toggler for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="actions">
                    <a href="cart.php" class="remove">Cancel</a>
                </div>
            </div>
        </nav>
    </header>
    <div class="payment">
        <div class="payment-div">
            <h1>Checkout</h1>
            <div>
                <h3 style="font-size: 18px;">Billing Address</h3>
                <label>Country</label>
                <select name="country" id="country">
                    <option value="Eg">Egypt</option>
                    <option value="USA">United States</option>
                    <option value="Eg">Egypt</option>
                </select>
                <p>Udemy is required by law to collect applicable transaction taxes for purchases made in certain tax
                    jurisdictions.</p>
            </div>
            <h3 style="font-size: 18px;">Payment Method</h3>
            <div class="payment-method">
                <div class="card-option">
                    <label for="card">Cards</label>
                    <div style="display: flex; margin-top: 5px;">
                        <img src="images/card1.jpeg" alt="Visa">
                        <img src="images/card2.jpeg" alt="Mastercard">
                        <img src="images/card3.jpeg" alt="Discover">
                        <img src="images/card4.jpeg" alt="American Express">
                    </div>
                </div>
                <div class="inputs">
                    <label>Card Number</label>
                    <input type="text" placeholder="1234 5678 9012 3456" style="width: 100%;">
                    <div style="display: flex;">
                        <div class="Expire-date">
                            <label>Expire Date</label>
                            <input type="text" placeholder="MM/YY" style="width: 100%;">
                        </div>
                        <div class="cvc" style="margin-left: 20px;">
                            <label>CVC/CVV</label>
                            <input type="text" placeholder="CVC" style="width: 100%;">
                        </div>
                    </div>
                    <label>Name of card</label>
                    <input type="text" placeholder="Name of card" style="width: 100%;">

                    <div class="checkbox">
                        <input id="terms" type="checkbox" name="terms" value="terms" required>
                        <label for="terms">I Accept all terms and privacy policy.</label>
                    </div>
                </div>

            </div>
        </div>
        <div class="summary-container">
            <h3>Summary</h3>
            <div class="summary-detail">
                <p>Original Price:</p>
                <?php
                if (isset($_GET['total'])) {
                    echo '<p>£' . $_GET['total'] . '</p>';
                }
                ?>
            </div>
            <div class="summary-detail total">
                <p><strong>Total:</strong></p>
                <?php
                if (isset($_GET['total'])) {
                    echo '<p><strong>£' . $_GET['total'] . '</strong></p>';
                }
                ?>

            </div>
            <p class="terms">
                By completing your purchase, you agree to these
                <a href="#">Terms of Service</a>.
            </p>
            <button class="checkout-btn" onclick="showSuccessBox()">
                <span>🔒</span> Complete Checkout
            </button>
            <p class="money-back">30-Day Money-Back Guarantee</p>
        </div>
    </div>

    <!-- Success Box -->
    <div id="success-box" class="success-box hidden">
        <p>✅<br>Your purchase was completed successfully!</p>
        <button onclick="hideSuccessBox()">Close</button>
    </div>
    <!--header-->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show the success box
        function showSuccessBox() {
            fetch('process_payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}), // Send data if necessary (e.g., session-related info)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hide the success box and redirect if the PHP script succeeded
                        const successBox = document.getElementById('success-box');
                        successBox.classList.remove('hidden');
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }

        // Hide the success box
        function hideSuccessBox() {
            // Send a request to the PHP script to execute the server-side logic
            const successBox = document.getElementById('success-box');
            successBox.classList.add('hidden');
            window.location.href = '../home/home.php';
        }

    </script>
</body>

</html>