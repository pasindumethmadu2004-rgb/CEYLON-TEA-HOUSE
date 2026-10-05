<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        My Account | Ceylon Tea House
    </title>

    <link rel="stylesheet"
          href="../../assets/css/account.css">

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


    <div class="header-actions">

        <a href="../cart/cart.php"
           class="cart-link">

            🛒 Cart

            <span id="cartCount">
                0
            </span>

        </a>

    </div>

</header>



<!-- ================= ACCOUNT HERO ================= -->

<section class="account-hero">

    <div class="hero-overlay"></div>

    <div class="hero-content">

        <span>
            CEYLON TEA HOUSE
        </span>

        <h1>
            My Account
        </h1>

        <p>
            Manage your personal information
            and account details.
        </p>

    </div>

</section>



<!-- ================= ACCOUNT PAGE ================= -->

<main class="account-page">


    <!-- ================= SIDEBAR ================= -->

    <aside class="account-sidebar">


        <div class="profile-summary">

            <div class="profile-avatar"
                 id="profileAvatar">

                U

            </div>


            <h3 id="sidebarName">
                User Name
            </h3>


            <p id="sidebarEmail">
                user@email.com
            </p>

        </div>


        <div class="account-menu">

            <button
                type="button"
                class="menu-item active">

                👤
                My Profile

            </button>


            <a href="../cart/cart.php"
               class="menu-item">

                🛒
                My Cart

            </a>


            <button
                type="button"
                class="menu-item logout-menu"
                id="logoutButton">

                ↪
                Logout

            </button>

        </div>

    </aside>



    <!-- ================= PROFILE CONTENT ================= -->

    <section class="profile-section">


        <div class="profile-card">


            <!-- HEADING -->

            <div class="profile-heading">

                <div>

                    <span class="small-label">
                        PERSONAL INFORMATION
                    </span>

                    <h2>
                        Profile Details
                    </h2>

                    <p>
                        View and update your
                        personal information.
                    </p>

                </div>


                <div class="profile-icon">
                    🍃
                </div>

            </div>



            <!-- ================= PROFILE FORM ================= -->

            <form id="profileForm">


                <!-- NAME -->

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
                                required
                            >

                        </div>

                    </div>

                </div>



                <!-- EMAIL -->

                <div class="input-group">

                    <label for="profileEmail">
                        Email Address
                    </label>

                    <div class="input-box">

                        <span class="input-icon">
                            ✉
                        </span>

                        <input
                            type="email"
                            id="profileEmail"
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
                            required
                        >

                    </div>

                </div>



                <!-- ROLE -->

                <div class="input-group">

                    <label for="role">
                        Account Type
                    </label>

                    <div class="input-box disabled-box">

                        <span class="input-icon">
                            ✓
                        </span>

                        <input
                            type="text"
                            id="role"
                            value="Customer"
                            disabled
                        >

                    </div>

                </div>



                <!-- MESSAGE -->

                <p id="profileMessage"
                   class="profile-message">
                </p>



                <!-- BUTTONS -->

                <div class="profile-actions">

                    <button
                        type="button"
                        class="edit-button"
                        id="editProfileButton">

                        EDIT PROFILE

                    </button>


                    <button
                        type="submit"
                        class="save-button"
                        id="saveProfileButton">

                        SAVE CHANGES

                        <span>
                            →
                        </span>

                    </button>

                </div>


            </form>


        </div>



        <!-- ================= ACCOUNT INFO ================= -->

        <div class="info-cards">


            <div class="info-card">

                <div class="info-icon">
                    🔐
                </div>

                <div>

                    <h3>
                        Secure Account
                    </h3>

                    <p>
                        Your account information
                        is protected and only
                        available after login.
                    </p>

                </div>

            </div>



            <div class="info-card">

                <div class="info-icon">
                    🛒
                </div>

                <div>

                    <h3>
                        Easy Shopping
                    </h3>

                    <p>
                        Continue shopping and
                        manage your cart easily.
                    </p>

                </div>

            </div>


        </div>


    </section>


</main>



<!-- ================= LOGOUT MODAL ================= -->

<div class="logout-overlay"
     id="logoutOverlay">

    <div class="logout-modal">

        <div class="logout-icon">
            🍃
        </div>

        <h2>
            Logout?
        </h2>

        <p>
            Are you sure you want to
            logout from your account?
        </p>


        <div class="logout-actions">

            <button
                type="button"
                class="cancel-button"
                id="cancelLogout">

                CANCEL

            </button>


            <button
                type="button"
                class="confirm-logout-button"
                id="confirmLogout">

                LOGOUT

            </button>

        </div>

    </div>

</div>



<!-- ================= FOOTER ================= -->

<footer class="footer">

    <p>
        © 2026 Ceylon Tea House.
        All Rights Reserved.
    </p>

</footer>



<script src="../../assets/js/account.js?v=1"></script>

</body>

</html>