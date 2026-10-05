<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Login | Ceylon Tea House
    </title>

    <link
        rel="stylesheet"
        href="../../assets/css/login.css">

</head>

<body>


<!-- ================= HEADER ================= -->

<header class="header">

    <a
        href="../../index.php"
        class="brand">

        <h2>
            Ceylon Tea House
        </h2>

        <span>
            Authentic Ceylon Tea
        </span>

    </a>


    <nav class="navbar">

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


    <a
        href="../cart/cart.php"
        class="cart-link">

        🛒 Cart

        <span id="cartCount">
            0
        </span>

    </a>

</header>



<!-- ================= LOGIN PAGE ================= -->

<main class="login-page">


    <!-- ================= LEFT VISUAL ================= -->

    <section class="login-visual">

        <div class="visual-overlay">

            <p class="small-title">
                WELCOME BACK
            </p>

            <h1>
                Your Ceylon Tea
                <br>
                Journey Continues
            </h1>

            <p class="visual-text">
                Sign in to continue shopping and
                enjoy your favourite authentic
                Ceylon teas.
            </p>

        </div>

    </section>



    <!-- ================= LOGIN AREA ================= -->

    <section class="login-area">

        <div class="login-card">


            <p class="small-title">
                CUSTOMER ACCOUNT
            </p>


            <h2>
                Sign In
            </h2>


            <p class="login-intro">
                Enter your account details
                to continue.
            </p>



            <!-- ================= LOGIN FORM ================= -->

            <form id="loginForm">


                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        placeholder="Enter your email"
                        autocomplete="email">

                </div>



                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>


                    <div class="password-box">

                        <input
                            type="password"
                            id="password"
                            placeholder="Enter your password"
                            autocomplete="current-password">


                        <button
                            type="button"
                            id="togglePassword"
                            class="toggle-password">

                            👁

                        </button>

                    </div>

                </div>



                <!-- OPTIONS -->

                <div class="form-options">

                    <label class="remember">

                        <input
                            type="checkbox"
                            id="rememberMe">

                        Remember me

                    </label>


                    <a
                        href="#"
                        class="forgot-link">

                        Forgot Password?

                    </a>

                </div>



                <!-- LOGIN MESSAGE -->

                <p
                    id="loginMessage"
                    class="login-message">
                </p>



                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    class="login-button">

                    SIGN IN

                </button>

            </form>



            <!-- ================= REGISTER ================= -->

            <div class="register-section">

                <p>
                    Don't have an account?
                </p>

                <a
                    href="register.php"
                    class="register-button">

                    CREATE AN ACCOUNT

                </a>

            </div>


            <!-- ================= SECURITY ================= -->

            <div class="security-note">

                <strong>
                    🔒 Secure Account Access
                </strong>

                <p>
                    Your account information
                    is used to manage your
                    Ceylon Tea House account.
                </p>

            </div>


        </div>

    </section>

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

            <p>Facebook</p>

            <p>Instagram</p>

        </div>

    </div>


    <div class="copyright">

        © 2026 Ceylon Tea House.
        All Rights Reserved.

    </div>

</footer>


<script src="../../assets/js/login.js?v=3"></script>


</body>

</html>