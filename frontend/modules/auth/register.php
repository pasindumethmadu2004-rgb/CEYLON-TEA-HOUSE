<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Create Account | Ceylon Tea House
    </title>

    <link rel="stylesheet"
          href="../../assets/css/register.css">

</head>


<body>


<!-- ================= HEADER ================= -->

<header class="header">

    <a href="../../index.php"
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


    <a href="../cart/cart.php"
       class="cart-link">

        🛒 Cart

        <span id="cartCount">
            0
        </span>

    </a>

</header>



<!-- ================= REGISTER PAGE ================= -->

<main class="register-page">


    <!-- ================= LEFT SIDE ================= -->

    <section class="register-visual">

        <div class="visual-overlay"></div>


        <div class="visual-content">

            <span class="small-title">
                JOIN OUR TEA COMMUNITY
            </span>

            <h1>
                Begin Your
                <br>
                Ceylon Tea Journey
            </h1>

            <p>
                Create your account and discover
                authentic premium teas from the
                beautiful tea gardens of Sri Lanka.
            </p>


            <div class="benefits">

                <div class="benefit-item">

                    <span>✓</span>

                    <div>
                        <h4>Easy Shopping</h4>

                        <p>
                            Enjoy a simple and convenient
                            shopping experience.
                        </p>
                    </div>

                </div>


                <div class="benefit-item">

                    <span>✓</span>

                    <div>
                        <h4>Order Management</h4>

                        <p>
                            View and manage your tea
                            orders from your account.
                        </p>
                    </div>

                </div>


                <div class="benefit-item">

                    <span>✓</span>

                    <div>
                        <h4>Premium Ceylon Tea</h4>

                        <p>
                            Discover quality teas from
                            Sri Lanka's famous tea regions.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </section>



    <!-- ================= RIGHT SIDE ================= -->

    <section class="register-form-section">


        <div class="register-card">


            <div class="form-heading">

                <div class="leaf-icon">
                    🍃
                </div>

                <span class="account-label">
                    CREATE YOUR ACCOUNT
                </span>

                <h2>
                    Join Ceylon Tea House
                </h2>

                <p>
                    Enter your details below to
                    create a new account.
                </p>

            </div>



            <!-- ================= REGISTER FORM ================= -->

            <form id="registerForm">


                <!-- NAME ROW -->

                <div class="form-row">


                    <div class="input-group">

                        <label for="firstName">
                            First Name
                        </label>

                        <div class="input-box">

                            <span class="input-icon">
                                👤
                            </span>

                            <input
                                type="text"
                                id="firstName"
                                placeholder="First name"
                                required
                            >

                        </div>

                    </div>



                    <div class="input-group">

                        <label for="lastName">
                            Last Name
                        </label>

                        <div class="input-box">

                            <span class="input-icon">
                                👤
                            </span>

                            <input
                                type="text"
                                id="lastName"
                                placeholder="Last name"
                                required
                            >

                        </div>

                    </div>


                </div>



                <!-- EMAIL -->

                <div class="input-group">

                    <label for="registerEmail">
                        Email Address
                    </label>

                    <div class="input-box">

                        <span class="input-icon">
                            ✉
                        </span>

                        <input
                            type="email"
                            id="registerEmail"
                            placeholder="Enter your email"
                            required
                        >

                    </div>

                </div>



                <!-- PHONE -->

                <div class="input-group">

                    <label for="phone">
                        Phone Number
                    </label>

                    <div class="input-box">

                        <span class="input-icon">
                            ☎
                        </span>

                        <input
                            type="tel"
                            id="phone"
                            placeholder="07X XXX XXXX"
                            required
                        >

                    </div>

                </div>



                <!-- PASSWORD -->

                <div class="input-group">

                    <label for="registerPassword">
                        Password
                    </label>

                    <div class="input-box">

                        <span class="input-icon">
                            🔒
                        </span>

                        <input
                            type="password"
                            id="registerPassword"
                            placeholder="Create a password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                        >
                            👁
                        </button>

                    </div>

                </div>



                <!-- CONFIRM PASSWORD -->

                <div class="input-group">

                    <label for="confirmPassword">
                        Confirm Password
                    </label>

                    <div class="input-box">

                        <span class="input-icon">
                            🔒
                        </span>

                        <input
                            type="password"
                            id="confirmPassword"
                            placeholder="Confirm your password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="toggleConfirmPassword"
                        >
                            👁
                        </button>

                    </div>

                </div>



                <!-- TERMS -->

                <label class="terms-box">

                    <input
                        type="checkbox"
                        id="terms"
                    >

                    <span>
                        I agree to the
                        <a href="#">
                            Terms & Conditions
                        </a>
                        and
                        <a href="#">
                            Privacy Policy
                        </a>.
                    </span>

                </label>



                <!-- MESSAGE -->

                <p
                    id="registerMessage"
                    class="register-message">
                </p>



                <!-- REGISTER BUTTON -->

                <button
                    type="submit"
                    class="register-button"
                >

                    CREATE MY ACCOUNT

                    <span>
                        →
                    </span>

                </button>


            </form>



            <!-- ================= DIVIDER ================= -->

            <div class="divider">

                <span></span>

                <p>
                    Already have an account?
                </p>

                <span></span>

            </div>



            <!-- ================= LOGIN ================= -->

            <a
                href="login.php"
                class="login-button"
            >

                SIGN IN TO YOUR ACCOUNT

            </a>



            <p class="secure-text">

                🔐 Your personal information
                is kept safe and secure.

            </p>


        </div>

    </section>


</main>



<!-- ================= FOOTER ================= -->

<footer class="footer">

    <p>
        © 2026 Ceylon Tea House.
        All Rights Reserved.
    </p>

</footer>



<script src="../../assets/js/register.js"></script>


</body>

</html>