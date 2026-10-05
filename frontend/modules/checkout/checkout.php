<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Checkout | Ceylon Tea House
    </title>

    <link
        rel="stylesheet"
        href="../../assets/css/checkout.css">

</head>

<body>


<!-- ================= HEADER ================= -->

<header class="header">

    <div class="logo">

        <h2>
            Ceylon Tea House
        </h2>

        <span>
            Authentic Ceylon Tea
        </span>

    </div>


    <nav>

        <a href="../../index.php">
            Home
        </a>

        <a href="../../shop.php">
            Shop
        </a>

        <a href="#">
            About
        </a>

        <a href="#">
            Contact
        </a>

    </nav>


    <div class="header-right">

        <a href="../cart/cart.php" class="cart-link">
            🛒 Cart
            <span id="cartCount">0</span>
        </a>

    </div>

</header>



<!-- ================= CHECKOUT HERO ================= -->

<section class="checkout-hero">

    <p>
        SECURE CHECKOUT
    </p>

    <h1>
        Complete Your Order
    </h1>

    <span>
        Fast, simple and secure checkout.
    </span>

</section>



<!-- ================= STEPS ================= -->

<section class="steps">

    <div class="step completed">

        <span>1</span>

        <p>
            Cart
        </p>

    </div>


    <div class="step-line"></div>


    <div class="step active">

        <span>2</span>

        <p>
            Checkout
        </p>

    </div>


    <div class="step-line"></div>


    <div class="step">

        <span>3</span>

        <p>
            Complete
        </p>

    </div>

</section>



<!-- ================= MAIN CHECKOUT ================= -->

<main class="checkout-container">


    <!-- ================= LEFT SIDE ================= -->

    <section class="checkout-form-section">


        <!-- CONTACT DETAILS -->

        <div class="checkout-card">

            <div class="card-heading">

                <div class="heading-number">
                    1
                </div>

                <div>

                    <h2>
                        Contact Information
                    </h2>

                    <p>
                        Enter your contact details.
                    </p>

                </div>

            </div>


            <div class="form-grid">


                <div class="form-group">

                    <label for="firstName">
                        First Name
                    </label>

                    <input
                        type="text"
                        id="firstName"
                        placeholder="Enter first name">

                </div>


                <div class="form-group">

                    <label for="lastName">
                        Last Name
                    </label>

                    <input
                        type="text"
                        id="lastName"
                        placeholder="Enter last name">

                </div>


                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        placeholder="example@email.com">

                </div>


                <div class="form-group">

                    <label for="phone">
                        Phone Number
                    </label>

                    <input
                        type="tel"
                        id="phone"
                        placeholder="07X XXX XXXX">

                </div>

            </div>

        </div>



        <!-- DELIVERY DETAILS -->

        <div class="checkout-card">

            <div class="card-heading">

                <div class="heading-number">
                    2
                </div>

                <div>

                    <h2>
                        Delivery Address
                    </h2>

                    <p>
                        Where should we deliver your order?
                    </p>

                </div>

            </div>


            <div class="form-grid">


                <div class="form-group full-width">

                    <label for="address">
                        Address
                    </label>

                    <input
                        type="text"
                        id="address"
                        placeholder="House number and street">

                </div>


                <div class="form-group">

                    <label for="city">
                        City
                    </label>

                    <input
                        type="text"
                        id="city"
                        placeholder="Enter city">

                </div>


                <div class="form-group">

                    <label for="district">
                        District
                    </label>

                    <select id="district">

                        <option value="">
                            Select District
                        </option>

                        <option>Colombo</option>
                        <option>Gampaha</option>
                        <option>Kalutara</option>
                        <option>Kandy</option>
                        <option>Galle</option>
                        <option>Matara</option>
                        <option>Kurunegala</option>
                        <option>Kegalle</option>
                        <option>Ratnapura</option>
                        <option>Other</option>

                    </select>

                </div>


                <div class="form-group full-width">

                    <label for="notes">
                        Order Notes
                        <span>
                            Optional
                        </span>
                    </label>

                    <textarea
                        id="notes"
                        rows="4"
                        placeholder="Special delivery instructions..."></textarea>

                </div>

            </div>

        </div>



        <!-- PAYMENT METHOD -->

        <div class="checkout-card">

            <div class="card-heading">

                <div class="heading-number">
                    3
                </div>

                <div>

                    <h2>
                        Payment Method
                    </h2>

                    <p>
                        Choose how you would like to pay.
                    </p>

                </div>

            </div>


            <div class="payment-options">


                <label class="payment-option active-payment">

                    <input
                        type="radio"
                        name="payment"
                        value="cash"
                        checked>

                    <div class="payment-icon">
                        💵
                    </div>

                    <div>

                        <h3>
                            Cash on Delivery
                        </h3>

                        <p>
                            Pay when your order arrives.
                        </p>

                    </div>

                </label>



                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment"
                        value="card">

                    <div class="payment-icon">
                        💳
                    </div>

                    <div>

                        <h3>
                            Card Payment
                        </h3>

                        <p>
                            Visa / Mastercard
                        </p>

                    </div>

                </label>


            </div>


            <div
                class="card-payment-box"
                id="cardPaymentBox">


                <div class="form-group full-width">

                    <label for="cardNumber">
                        Card Number
                    </label>

                    <input
                        type="text"
                        id="cardNumber"
                        placeholder="0000 0000 0000 0000"
                        maxlength="19">

                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label for="expiry">
                            Expiry Date
                        </label>

                        <input
                            type="text"
                            id="expiry"
                            placeholder="MM/YY"
                            maxlength="5">

                    </div>


                    <div class="form-group">

                        <label for="cvv">
                            CVV
                        </label>

                        <input
                            type="password"
                            id="cvv"
                            placeholder="123"
                            maxlength="3">

                    </div>

                </div>

            </div>

        </div>


    </section>



    <!-- ================= RIGHT SIDE ================= -->

    <aside class="order-summary">

        <div class="summary-card">

            <div class="summary-heading">

                <h2>
                    Order Summary
                </h2>

                <a href="../cart/cart.php">
                    Edit Cart
                </a>

            </div>


            <div
                class="summary-items"
                id="checkoutItems">
            </div>


            <div
                class="empty-summary"
                id="emptyCheckout">

                Your cart is empty.

            </div>


            <div class="summary-divider"></div>


            <div class="summary-row">

                <span>
                    Subtotal
                </span>

                <strong id="checkoutSubtotal">
                    Rs. 0
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Delivery
                </span>

                <strong id="checkoutShipping">
                    Rs. 0
                </strong>

            </div>


            <div class="summary-divider"></div>


            <div class="summary-row total-row">

                <span>
                    Total
                </span>

                <strong id="checkoutTotal">
                    Rs. 0
                </strong>

            </div>


            <button
                type="button"
                class="place-order-btn"
                id="placeOrderButton">

                🔒 PLACE ORDER

            </button>


            <div class="secure-text">

                🔒 Secure checkout

            </div>

        </div>


        <div class="support-card">

            <div>
                📦
            </div>

            <div>

                <h3>
                    Islandwide Delivery
                </h3>

                <p>
                    Safe delivery across Sri Lanka.
                </p>

            </div>

        </div>


        <div class="support-card">

            <div>
                🌿
            </div>

            <div>

                <h3>
                    Authentic Ceylon Tea
                </h3>

                <p>
                    Carefully selected quality products.
                </p>

            </div>

        </div>

    </aside>


</main>



<!-- ================= SUCCESS MODAL ================= -->

<div
    class="success-overlay"
    id="successOverlay">

    <div class="success-box">

        <div class="success-icon">
            ✓
        </div>

        <h2>
            Order Placed Successfully!
        </h2>

        <p>
            Thank you for shopping with
            Ceylon Tea House.
        </p>

        <button
            type="button"
            id="continueShoppingButton">

            CONTINUE SHOPPING

        </button>

    </div>

</div>



<!-- ================= FOOTER ================= -->

<footer>

    <div class="footer-container">

        <div>

            <h2>
                Ceylon Tea House
            </h2>

            <p>
                Authentic Ceylon Tea<br>
                from Sri Lanka.
            </p>

        </div>


        <div>

            <h3>
                Quick Links
            </h3>

            <a href="../../index.php">
                Home
            </a>

            <a href="../../shop.php">
                Shop
            </a>

            <a href="#">
                Contact
            </a>

        </div>


        <div>

            <h3>
                Customer Service
            </h3>

            <a href="#">
                Delivery
            </a>

            <a href="#">
                Returns
            </a>

            <a href="#">
                FAQ
            </a>

        </div>

    </div>


    <div class="copyright">

        © 2026 Ceylon Tea House.
        All Rights Reserved.

    </div>

</footer>


<script src="../../assets/js/checkout.js"></script>

</body>

</html>