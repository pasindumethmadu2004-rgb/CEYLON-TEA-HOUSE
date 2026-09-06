<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shopping Cart | Ceylon Tea House</title>

    <link rel="stylesheet" href="../../assets/css/cart.css">
</head>

<body>

    <!-- ================= HEADER ================= -->
    <header class="header">

        <div class="logo">
            <h2>Ceylon Tea House</h2>
            <span>Authentic Ceylon Tea</span>
        </div>

        <nav class="nav">
            <a href="../../index.php">Home</a>
            <a href="../../shop.php">Shop</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
        </nav>

        <div class="header-right">
            <a href="../auth/login.php">Login</a>

            <a href="cart.php" class="cart-link">
                🛒 Cart
                <span id="cartCount">0</span>
            </a>
        </div>

    </header>


    <!-- ================= CART HERO ================= -->
    <section class="cart-hero">

        <p>YOUR SHOPPING BAG</p>

        <h1>Shopping Cart</h1>

        <div class="breadcrumb">
            <a href="../../index.php">Home</a>
            <span>/</span>
            <span>Cart</span>
        </div>

    </section>


    <!-- ================= CART SECTION ================= -->
    <main class="cart-container">

        <div class="cart-title">

            <div>
                <p class="small-title">CEYLON TEA HOUSE</p>
                <h2>Your Cart</h2>
            </div>

            <button
                type="button"
                class="clear-cart"
                id="clearCart">
                Clear Cart
            </button>

        </div>


        <!-- Cart Content -->
        <div class="cart-layout">

            <!-- ================= CART ITEMS ================= -->
            <section class="cart-items-section">

                <div class="cart-table-header">

                    <span>PRODUCT</span>
                    <span>PRICE</span>
                    <span>QUANTITY</span>
                    <span>SUBTOTAL</span>

                </div>


                <!-- Products will be added using JavaScript -->
                <div id="cartItems"></div>


                <!-- Empty Cart -->
                <div class="empty-cart" id="emptyCart">

                    <div class="empty-cart-icon">
                        🛒
                    </div>

                    <h2>Your cart is empty</h2>

                    <p>
                        Looks like you haven't added any Ceylon tea yet.
                    </p>

                    <a href="../../shop.php" class="shop-now-btn">
                        SHOP NOW
                    </a>

                </div>


                <!-- Continue Shopping -->
                <div class="continue-shopping">

                    <a href="../../shop.php">
                        ← Continue Shopping
                    </a>

                </div>

            </section>


            <!-- ================= ORDER SUMMARY ================= -->
            <aside class="order-summary">

                <p class="summary-small-title">
                    YOUR ORDER
                </p>

                <h2>Order Summary</h2>

                <div class="summary-line">

                    <span>Subtotal</span>

                    <strong id="cartSubtotal">
                        Rs. 0
                    </strong>

                </div>


                <div class="summary-line">

                    <span>Shipping</span>

                    <strong id="shippingCost">
                        Free
                    </strong>

                </div>


                <div class="divider"></div>


                <div class="summary-total">

                    <span>Total</span>

                    <strong id="cartTotal">
                        Rs. 0
                    </strong>

                </div>


                <p class="shipping-message">
                    Free delivery for your Ceylon tea order.
                </p>


                <button
                    type="button"
                    class="checkout-btn"
                    id="checkoutButton">

                    PROCEED TO CHECKOUT →

                </button>


                <div class="secure-payment">
                    🔒 Secure Checkout
                </div>

            </aside>

        </div>

    </main>


    <!-- ================= BENEFITS ================= -->
    <section class="benefits">

        <div class="benefit">
            <div>🍃</div>

            <h3>100% Ceylon Tea</h3>

            <p>
                Authentic tea from Sri Lanka
            </p>
        </div>


        <div class="benefit">
            <div>📦</div>

            <h3>Safe Packaging</h3>

            <p>
                Carefully packed for freshness
            </p>
        </div>


        <div class="benefit">
            <div>🚚</div>

            <h3>Fast Delivery</h3>

            <p>
                Quick and reliable delivery
            </p>
        </div>


        <div class="benefit">
            <div>🔒</div>

            <h3>Secure Payment</h3>

            <p>
                Safe checkout experience
            </p>
        </div>

    </section>


    <!-- ================= FOOTER ================= -->
    <footer class="footer">

        <div class="footer-container">

            <div class="footer-column">

                <h2>Ceylon Tea House</h2>

                <p>
                    Bringing the finest authentic Ceylon tea
                    from Sri Lanka to tea lovers everywhere.
                </p>

            </div>


            <div class="footer-column">

                <h3>Quick Links</h3>

                <a href="../../index.php">Home</a>
                <a href="../../shop.php">Shop</a>
                <a href="#">About</a>
                <a href="#">Contact</a>

            </div>


            <div class="footer-column">

                <h3>Customer Service</h3>

                <a href="#">My Account</a>
                <a href="cart.php">Shopping Cart</a>
                <a href="#">Shipping Information</a>
                <a href="#">Privacy Policy</a>

            </div>


            <div class="footer-column">

                <h3>Follow Us</h3>

                <p>
                    Facebook
                </p>

                <p>
                    Instagram
                </p>

                <p>
                    YouTube
                </p>

            </div>

        </div>


        <div class="footer-bottom">
            © 2026 Ceylon Tea House. All Rights Reserved.
        </div>

    </footer>


    <script src="../../assets/js/cart.js"></script>

</body>

</html>