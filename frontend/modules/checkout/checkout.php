<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout - Ceylon Tea House</title>

    <link rel="stylesheet" href="../../assets/css/checkout.css">

    <!-- PayHere -->
    <script
        type="text/javascript"
        src="https://www.payhere.lk/lib/payhere-2.0.js">
    </script>
</head>

<body>

<header class="header">

    <a href="../../index.php" class="logo">
        <h2>Ceylon Tea House</h2>
        <span>AUTHENTIC CEYLON TEA</span>
    </a>

    <nav>
        <a href="../../index.php">Home</a>
        <a href="../../shop.php">Shop</a>
        <a href="#">About</a>
        <a href="#">Contact</a>

        <a href="../cart/cart.php" class="cart-link">
            Cart
            <span id="cartCount">0</span>
        </a>
    </nav>

</header>


<section class="checkout-hero">

    <p>CEYLON TEA HOUSE</p>

    <h1>Checkout</h1>

    <span>Complete your order and enjoy authentic Ceylon Tea.</span>

</section>


<section class="steps">

    <div class="step active">
        <span>1</span>
        <p>Information</p>
    </div>

    <div class="step-line"></div>

    <div class="step active">
        <span>2</span>
        <p>Delivery</p>
    </div>

    <div class="step-line"></div>

    <div class="step active">
        <span>3</span>
        <p>Payment</p>
    </div>

</section>


<main class="checkout-container">

    <!-- LEFT -->
    <div class="checkout-left">


        <!-- CONTACT -->
        <section class="checkout-card">

            <div class="card-heading">

                <div class="heading-number">1</div>

                <div>
                    <h2>Contact Information</h2>
                    <p>Enter your contact details.</p>
                </div>

            </div>


            <div class="form-grid">

                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input
                        type="text"
                        id="firstName"
                        placeholder="Enter your first name">
                </div>


                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input
                        type="text"
                        id="lastName"
                        placeholder="Enter your last name">
                </div>


                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        placeholder="Enter your email">
                </div>


                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input
                        type="tel"
                        id="phone"
                        placeholder="Enter your phone number">
                </div>

            </div>

        </section>


        <!-- DELIVERY -->
        <section class="checkout-card">

            <div class="card-heading">

                <div class="heading-number">2</div>

                <div>
                    <h2>Delivery Information</h2>
                    <p>Enter your delivery address.</p>
                </div>

            </div>


            <div class="form-grid">

                <div class="form-group full-width">

                    <label for="address">Address</label>

                    <textarea
                        id="address"
                        rows="3"
                        placeholder="Enter your delivery address"></textarea>

                </div>


                <div class="form-group">

                    <label for="city">City</label>

                    <input
                        type="text"
                        id="city"
                        placeholder="Enter your city">

                </div>


                <div class="form-group">

                    <label for="district">District</label>

                    <input
                        type="text"
                        id="district"
                        placeholder="Enter your district">

                </div>


                <div class="form-group full-width">

                    <label for="notes">
                        Delivery Notes
                        <span>(Optional)</span>
                    </label>

                    <textarea
                        id="notes"
                        rows="3"
                        placeholder="Any special delivery instructions?"></textarea>

                </div>

            </div>

        </section>


        <!-- PAYMENT -->
        <section class="checkout-card">

            <div class="card-heading">

                <div class="heading-number">3</div>

                <div>
                    <h2>Payment Method</h2>
                    <p>Select your preferred payment method.</p>
                </div>

            </div>


            <div class="payment-options">

                <!-- CASH -->
                <label class="payment-option active-payment">

                    <input
                        type="radio"
                        name="paymentMethod"
                        value="cash"
                        checked>

                    <div class="payment-icon">💵</div>

                    <div>

                        <h3>Cash on Delivery</h3>

                        <p>
                            Pay when your order arrives.
                        </p>

                    </div>

                </label>


                <!-- CARD -->
                <label class="payment-option">

                    <input
                        type="radio"
                        name="paymentMethod"
                        value="card">

                    <div class="payment-icon">💳</div>

                    <div>

                        <h3>Card Payment</h3>

                        <p>
                            Visa / Mastercard
                        </p>

                    </div>

                </label>

            </div>


            <!-- PAYHERE AREA -->
            <div
                class="card-payment-box"
                id="cardPaymentBox">

                <div>

                    <h3 style="color:#173d2b; margin-bottom:8px;">
                        Secure Card Payment
                    </h3>

                    <p style="color:#888; font-size:13px; line-height:1.6;">
                        Click "Place Order" to continue to
                        PayHere Sandbox and securely complete
                        your card payment.
                    </p>

                    <p style="color:#999; font-size:11px; margin-top:8px;">
                        Your card details are securely handled by PayHere.
                    </p>

                </div>

            </div>

        </section>


        <!-- PLACE ORDER -->
        <button
            type="button"
            id="placeOrderButton"
            class="place-order-btn">

            Place Order

        </button>


    </div>


    <!-- RIGHT -->
    <aside>


        <!-- SUMMARY -->
        <section class="summary-card order-summary">

            <div class="summary-heading">

                <h2>Order Summary</h2>

                <a href="../cart/cart.php">
                    Edit Cart
                </a>

            </div>


            <div id="checkoutItems"></div>


            <div
                id="emptyCheckout"
                class="empty-summary">

                Your cart is empty.

            </div>


            <div class="summary-divider"></div>


            <div class="summary-row">

                <span>Subtotal</span>

                <strong id="checkoutSubtotal">
                    Rs. 0.00
                </strong>

            </div>


            <div class="summary-row">

                <span>Shipping</span>

                <strong id="checkoutShipping">
                    Rs. 0.00
                </strong>

            </div>


            <div class="summary-divider"></div>


            <div class="summary-row total-row">

                <span>Total</span>

                <strong id="checkoutTotal">
                    Rs. 0.00
                </strong>

            </div>


            <p class="secure-text">
                🔒 Secure checkout
            </p>

        </section>


        <!-- SUPPORT -->
        <section class="support-card">

            <div>💬</div>

            <div>

                <h3>Need Help?</h3>

                <p>
                    If you have any questions about your
                    order, please contact Ceylon Tea House.
                </p>

            </div>

        </section>


    </aside>

</main>


<!-- SUCCESS -->
<div
    class="success-overlay"
    id="successOverlay">

    <div class="success-box">

        <div class="success-icon">
            ✓
        </div>

        <h2>Order Successful!</h2>

        <p>
            Thank you for shopping with Ceylon Tea House.
        </p>

        <button
            type="button"
            id="continueShoppingButton">

            Continue Shopping

        </button>

    </div>

</div>


<footer>

    <div class="footer-container">

        <div>
            <h2>Ceylon Tea House</h2>
            <p>
                Authentic Ceylon Tea.
            </p>
        </div>

    </div>

    <div class="copyright">

        © 2026 Ceylon Tea House. All Rights Reserved.

    </div>

</footer>


<script src="../../assets/js/checkout.js"></script>

</body>
</html>