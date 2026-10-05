<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Shopping Cart | Ceylon Tea House</title>

    <link
        rel="stylesheet"
        href="../../assets/css/cart.css">

</head>

<body>


<!-- ================= HEADER ================= -->

<header class="header">

    <a
        href="../../index.php"
        class="logo">

        <h2>Ceylon Tea House</h2>

        <span>Authentic Ceylon Tea</span>

    </a>


    <nav>

        <a href="../../index.php">
            Home
        </a>

        <a href="../../shop.php">
            Shop
        </a>

        <a href="../../index.php#about">
            About
        </a>

        <a href="../../index.php#contact">
            Contact
        </a>

    </nav>


    <div class="header-right">


        <!-- AUTH LINKS -->

        <div class="auth-links">

            <a
                href="../auth/login.php"
                id="loginLink"
                class="login-link">

                Login

            </a>


            <a
                href="../account/account.php"
                id="accountLink"
                class="account-link">

                My Account

            </a>


            <button
                type="button"
                id="logoutLink"
                class="logout-link">

                Logout

            </button>

        </div>


        <!-- CART -->

        <a
            href="cart.php"
            class="cart-link">

            🛒 Cart

            <span id="cartCount">
                0
            </span>

        </a>

    </div>

</header>



<!-- ================= CART HERO ================= -->

<section class="cart-hero">

    <p>YOUR SHOPPING BAG</p>

    <h1>
        Shopping Cart
    </h1>

    <div class="breadcrumb">

        <a href="../../index.php">
            Home
        </a>

        <span>›</span>

        <span>
            Cart
        </span>

    </div>

</section>



<!-- ================= CART SECTION ================= -->

<main class="cart-section">

    <div class="cart-layout">


        <!-- ================= LEFT SIDE ================= -->

        <section class="cart-products">


            <div class="cart-title">

                <div>

                    <p class="small-title">
                        YOUR SELECTION
                    </p>

                    <h2>
                        Shopping Cart
                    </h2>

                </div>


                <button
                    type="button"
                    class="clear-cart"
                    id="clearCart">

                    Clear Cart

                </button>

            </div>



            <!-- TABLE HEADER -->

            <div class="cart-table-header">

                <span>
                    PRODUCT
                </span>

                <span>
                    PRICE
                </span>

                <span>
                    QUANTITY
                </span>

                <span>
                    SUBTOTAL
                </span>

            </div>



            <!-- PRODUCTS ADDED BY JAVASCRIPT -->

            <div id="cartItems"></div>



            <!-- EMPTY CART -->

            <div
                class="empty-cart"
                id="emptyCart">

                <div class="empty-icon">
                    🛒
                </div>

                <h3>
                    Your cart is empty
                </h3>

                <p>
                    Looks like you haven't added
                    any tea to your cart yet.
                </p>

                <a
                    href="../../shop.php"
                    class="continue-button">

                    CONTINUE SHOPPING

                </a>

            </div>


        </section>



        <!-- ================= ORDER SUMMARY ================= -->

        <aside class="cart-summary">

            <p class="small-title">
                ORDER DETAILS
            </p>

            <h2>
                Order Summary
            </h2>


            <div class="summary-line">

                <span>
                    Subtotal
                </span>

                <strong id="cartSubtotal">
                    Rs. 0
                </strong>

            </div>


            <div class="summary-line">

                <span>
                    Shipping
                </span>

                <strong id="shippingCost">
                    Free
                </strong>

            </div>


            <div class="summary-divider"></div>


            <div class="summary-line total-line">

                <span>
                    Total
                </span>

                <strong id="cartTotal">
                    Rs. 0
                </strong>

            </div>


            <button
                type="button"
                class="checkout-button"
                id="checkoutButton">

                PROCEED TO CHECKOUT

            </button>


            <a
                href="../../shop.php"
                class="continue-shopping">

                ← Continue Shopping

            </a>


            <div class="secure-box">

                <strong>
                    🔒 Secure Checkout
                </strong>

                <p>
                    Your shopping information
                    is handled securely.
                </p>

            </div>

        </aside>


    </div>

</main>



<!-- ================= FOOTER ================= -->

<footer id="contact">

    <div class="footer-container">


        <div>

            <h2>
                Ceylon Tea House
            </h2>

            <p>
                Authentic Ceylon Tea
                <br>
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

            <a href="../../index.php#about">
                About Us
            </a>

            <a href="../../index.php#contact">
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


        <div>

            <h3>
                Follow Us
            </h3>

            <p>
                Facebook
            </p>

            <p>
                Instagram
            </p>

        </div>

    </div>


    <div class="copyright">

        © 2026 Ceylon Tea House.
        All Rights Reserved.

    </div>

</footer>


<script src="../../assets/js/cart.js?v=8"></script>


</body>

</html>