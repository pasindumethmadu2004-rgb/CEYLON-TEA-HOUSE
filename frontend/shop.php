<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Shop | Ceylon Tea House
    </title>

    <link
        rel="stylesheet"
        href="assets/css/shop.css">

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

        <a href="index.php">
            Home
        </a>

        <a
            href="shop.php"
            class="active">
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

        <div class="search">

            🔍

            <input
                type="text"
                id="searchInput"
                placeholder="Search tea...">

        </div>

        <div class="auth-links">

            <a href="modules/auth/login.php" id="loginLink" class="login-link">
                Login
            </a>

            <a href="modules/account/account.php" id="accountLink" class="account-link">
                My Account
            </a>

            <button type="button" id="logoutLink" class="logout-link">
                Logout
            </button>

        </div>

        <a
            href="modules/cart/cart.php"
            class="cart">
            🛒 Cart
            <span id="cartCount">0</span>
        </a>

    </div>

</header>


<!-- ================= SHOP HERO ================= -->

<section class="shop-hero">

    <div class="hero-overlay">

        <p>
            EXPLORE OUR COLLECTION
        </p>

        <h1>
            Discover Your Perfect
            <br>

            <span>
                Ceylon Tea
            </span>
        </h1>

        <p class="hero-text">

            Carefully selected teas from the beautiful
            tea-growing regions of Sri Lanka.

        </p>

    </div>

</section>


<!-- ================= SHOP CONTENT ================= -->

<section class="shop-section">


    <!-- ================= HEADING ================= -->

    <div class="shop-heading">

        <div>

            <p class="small-title">
                OUR COLLECTION
            </p>

            <h2>
                Shop Ceylon Tea
            </h2>

        </div>


        <p
            class="product-count"
            id="productCount">

            8 Products

        </p>

    </div>


    <!-- ================= FILTER BAR ================= -->

    <div class="filter-bar">


        <div class="categories">

            <button
                class="filter active"
                data-filter="all">

                All

            </button>


            <button
                class="filter"
                data-filter="black-tea">

                Black Tea

            </button>


            <button
                class="filter"
                data-filter="green-tea">

                Green Tea

            </button>


            <button
                class="filter"
                data-filter="tea-bags">

                Tea Bags

            </button>


            <button
                class="filter"
                data-filter="gift-box">

                Gift Boxes

            </button>

        </div>


        <select id="sortProducts">

            <option value="default">
                Sort By
            </option>

            <option value="low-high">
                Price: Low to High
            </option>

            <option value="high-low">
                Price: High to Low
            </option>

            <option value="popular">
                Popular
            </option>

        </select>

    </div>


    <!-- ================= PRODUCTS ================= -->

    <div
        class="product-grid"
        id="productGrid">


        <!-- ================================================= -->
        <!-- PRODUCT 01 -->
        <!-- ================================================= -->

        <div
            class="product-card"
            data-category="black-tea"
            data-price="2500"
            data-popularity="24">


            <div class="product-image">

                <span class="badge">
                    BEST SELLER
                </span>

                <img
                    src="assets/images/black-tea.png.png"
                    alt="Premium Ceylon Black Tea">


                <a
                    href="modules/shop/product-details.php?product=black-tea"
                    class="quick-view">

                    VIEW FULL DETAILS

                </a>

            </div>


            <div class="product-info">

                <p class="category">
                    BLACK TEA
                </p>


                <h3>

                    <a
                        href="modules/shop/product-details.php?product=black-tea">

                        Premium Ceylon Black Tea

                    </a>

                </h3>


                <div class="rating">

                    ★★★★★

                    <span>
                        (24)
                    </span>

                </div>


                <p class="description">

                    Rich and classic Ceylon tea with a
                    wonderful aroma and smooth taste.

                </p>


                <div class="product-bottom">

                    <strong>
                        Rs. 2,500
                    </strong>

                    <button
                        type="button"
                        onclick="addProduct('Premium Ceylon Black Tea', 2500, '../../assets/images/black-tea.png.png', '250g')">

                        🛒 Add

                    </button>

                </div>

            </div>

        </div>



        <!-- ================================================= -->
        <!-- PRODUCT 02 -->
        <!-- ================================================= -->

        <div
            class="product-card"
            data-category="green-tea"
            data-price="2300"
            data-popularity="18">


            <div class="product-image">

                <span class="badge new">
                    NEW
                </span>

                <img
                    src="assets/images/green-tea.png.png"
                    alt="Pure Ceylon Green Tea">


                <a
                    href="modules/shop/product-details.php?product=green-tea"
                    class="quick-view">

                    VIEW FULL DETAILS

                </a>

            </div>


            <div class="product-info">

                <p class="category">
                    GREEN TEA
                </p>


                <h3>

                    <a
                        href="modules/shop/product-details.php?product=green-tea">

                        Pure Ceylon Green Tea

                    </a>

                </h3>


                <div class="rating">

                    ★★★★★

                    <span>
                        (18)
                    </span>

                </div>


                <p class="description">

                    Fresh and natural green tea made
                    from carefully selected tea leaves.

                </p>


                <div class="product-bottom">

                    <strong>
                        Rs. 2,300
                    </strong>


                    <button
                        type="button"
                        onclick="addProduct('Pure Ceylon Green Tea', 2300, '../../assets/images/green-tea.png.png', '250g')">

                        🛒 Add

                    </button>

                </div>

            </div>

        </div>



        <!-- ================================================= -->
        <!-- PRODUCT 03 -->
        <!-- ================================================= -->

        <div
            class="product-card"
            data-category="tea-bags"
            data-price="1200"
            data-popularity="31">


            <div class="product-image">

                <span class="badge">
                    POPULAR
                </span>


                <img
                    src="assets/images/tea-bags.png.png"
                    alt="Classic Ceylon Tea Bags">


                <a
                    href="modules/shop/product-details.php?product=tea-bags"
                    class="quick-view">

                    VIEW FULL DETAILS

                </a>

            </div>


            <div class="product-info">

                <p class="category">
                    TEA BAGS
                </p>


                <h3>

                    <a
                        href="modules/shop/product-details.php?product=tea-bags">

                        Classic Ceylon Tea Bags

                    </a>

                </h3>


                <div class="rating">

                    ★★★★★

                    <span>
                        (31)
                    </span>

                </div>


                <p class="description">

                    Convenient tea bags delivering the
                    authentic taste of Ceylon tea.

                </p>


                <div class="product-bottom">

                    <strong>
                        Rs. 1,200
                    </strong>


                    <button
                        type="button"
                        onclick="addProduct('Classic Ceylon Tea Bags', 1200, '../../assets/images/tea-bags.png.png', '250g')">

                        🛒 Add

                    </button>

                </div>

            </div>

        </div>



        <!-- ================================================= -->
        <!-- PRODUCT 04 -->
        <!-- ================================================= -->

        <div
            class="product-card"
            data-category="gift-box"
            data-price="3500"
            data-popularity="27">


            <div class="product-image">

                <span class="badge gift">
                    GIFT
                </span>


                <img
                    src="assets/images/gift-box.png.png"
                    alt="Premium Tea Gift Box">


                <a
                    href="modules/shop/product-details.php?product=premium-tea"
                    class="quick-view">

                    VIEW FULL DETAILS

                </a>

            </div>


            <div class="product-info">

                <p class="category">
                    GIFT BOX
                </p>


                <h3>

                    <a
                        href="modules/shop/product-details.php?product=premium-tea">

                        Premium Tea Gift Box

                    </a>

                </h3>


                <div class="rating">

                    ★★★★★

                    <span>
                        (27)
                    </span>

                </div>


                <p class="description">

                    A beautiful selection of premium
                    Ceylon teas, perfect for gifting.

                </p>


                <div class="product-bottom">

                    <strong>
                        Rs. 3,500
                    </strong>


                    <button
                        type="button"
                        onclick="addProduct('Premium Tea Gift Box', 3500, '../../assets/images/gift-box.png.png', '1 Box')">

                        🛒 Add

                    </button>

                </div>

            </div>

        </div>



        <!-- ================================================= -->
        <!-- PRODUCT 05 -->
        <!-- ================================================= -->

        <div
            class="product-card"
            data-category="black-tea"
            data-price="1950"
            data-popularity="15">


            <div class="product-image">

                <img
                    src="assets/images/black-tea.png.png"
                    alt="Ceylon Breakfast Tea">


                <a
                    href="modules/shop/product-details.php?product=black-tea"
                    class="quick-view">

                    VIEW FULL DETAILS

                </a>

            </div>


            <div class="product-info">

                <p class="category">
                    BLACK TEA
                </p>


                <h3>

                    <a
                        href="modules/shop/product-details.php?product=black-tea">

                        Ceylon Breakfast Tea

                    </a>

                </h3>


                <div class="rating">

                    ★★★★☆

                    <span>
                        (15)
                    </span>

                </div>


                <p class="description">

                    A bold and refreshing tea that is
                    perfect for starting your morning.

                </p>


                <div class="product-bottom">

                    <strong>
                        Rs. 1,950
                    </strong>


                    <button
                        type="button"
                        onclick="addProduct('Ceylon Breakfast Tea', 1950, '../../assets/images/black-tea.png.png', '250g')">

                        🛒 Add

                    </button>

                </div>

            </div>

        </div>



        <!-- ================================================= -->
        <!-- PRODUCT 06 -->
        <!-- ================================================= -->

        <div
            class="product-card"
            data-category="green-tea"
            data-price="2750"
            data-popularity="21">


            <div class="product-image">

                <img
                    src="assets/images/green-tea.png.png"
                    alt="Premium Green Tea">


                <a
                    href="modules/shop/product-details.php?product=green-tea"
                    class="quick-view">

                    VIEW FULL DETAILS

                </a>

            </div>


            <div class="product-info">

                <p class="category">
                    GREEN TEA
                </p>


                <h3>

                    <a
                        href="modules/shop/product-details.php?product=green-tea">

                        Premium Green Tea

                    </a>

                </h3>


                <div class="rating">

                    ★★★★★

                    <span>
                        (21)
                    </span>

                </div>


                <p class="description">

                    Light, refreshing and naturally
                    aromatic premium green tea.

                </p>


                <div class="product-bottom">

                    <strong>
                        Rs. 2,750
                    </strong>


                    <button
                        type="button"
                        onclick="addProduct('Premium Green Tea', 2750, '../../assets/images/green-tea.png.png', '250g')">

                        🛒 Add

                    </button>

                </div>

            </div>

        </div>



        <!-- ================================================= -->
        <!-- PRODUCT 07 -->
        <!-- ================================================= -->

        <div
            class="product-card"
            data-category="tea-bags"
            data-price="1650"
            data-popularity="12">


            <div class="product-image">

                <img
                    src="assets/images/tea-bags.png.png"
                    alt="Ceylon Earl Grey Tea Bags">


                <a
                    href="modules/shop/product-details.php?product=tea-bags"
                    class="quick-view">

                    VIEW FULL DETAILS

                </a>

            </div>


            <div class="product-info">

                <p class="category">
                    TEA BAGS
                </p>


                <h3>

                    <a
                        href="modules/shop/product-details.php?product=tea-bags">

                        Ceylon Earl Grey Tea Bags

                    </a>

                </h3>


                <div class="rating">

                    ★★★★★

                    <span>
                        (12)
                    </span>

                </div>


                <p class="description">

                    Fragrant Ceylon tea bags with a
                    refreshing and elegant flavour.

                </p>


                <div class="product-bottom">

                    <strong>
                        Rs. 1,650
                    </strong>


                    <button
                        type="button"
                        onclick="addProduct('Ceylon Earl Grey Tea Bags', 1650, '../../assets/images/tea-bags.png.png', '250g')">

                        🛒 Add

                    </button>

                </div>

            </div>

        </div>



        <!-- ================================================= -->
        <!-- PRODUCT 08 -->
        <!-- ================================================= -->

        <div
            class="product-card"
            data-category="gift-box"
            data-price="4500"
            data-popularity="35">


            <div class="product-image">

                <span class="badge gift">
                    GIFT
                </span>


                <img
                    src="assets/images/gift-box.png.png"
                    alt="Luxury Ceylon Tea Collection">


                <a
                    href="modules/shop/product-details.php?product=premium-tea"
                    class="quick-view">

                    VIEW FULL DETAILS

                </a>

            </div>


            <div class="product-info">

                <p class="category">
                    GIFT BOX
                </p>


                <h3>

                    <a
                        href="modules/shop/product-details.php?product=premium-tea">

                        Luxury Ceylon Tea Collection

                    </a>

                </h3>


                <div class="rating">

                    ★★★★★

                    <span>
                        (35)
                    </span>

                </div>


                <p class="description">

                    An elegant collection of selected
                    Ceylon teas for special occasions.

                </p>


                <div class="product-bottom">

                    <strong>
                        Rs. 4,500
                    </strong>


                    <button
                        type="button"
                        onclick="addProduct('Luxury Ceylon Tea Collection', 4500, '../../assets/images/gift-box.png.png', '1 Box')">

                        🛒 Add

                    </button>

                </div>

            </div>

        </div>


    </div>


    <!-- ================= NO PRODUCTS MESSAGE ================= -->

    <p
        id="noProducts"
        class="no-products">

        No products found.

    </p>


    <!-- ================= PAGINATION ================= -->

    <div class="pagination">

        <button class="page active">
            1
        </button>

        <button class="page">
            2
        </button>

        <button class="page">
            3
        </button>

        <button class="next">
            Next →
        </button>

    </div>

</section>


<!-- ================= FOOTER ================= -->

<footer>

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

            <a href="index.php">
                Home
            </a>

            <a href="shop.php">
                Shop
            </a>

            <a href="#">
                About Us
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



<!-- ========================================================= -->
<!-- JAVASCRIPT -->
<!-- ========================================================= -->

<script>


/* ================= CATEGORY FILTER ================= */

const filterButtons =
    document.querySelectorAll(".filter");

const productCards =
    document.querySelectorAll(".product-card");

const productCount =
    document.getElementById("productCount");

const noProducts =
    document.getElementById("noProducts");


let currentFilter = "all";


filterButtons.forEach(function(button) {

    button.addEventListener("click", function() {


        /* ACTIVE BUTTON */

        filterButtons.forEach(function(btn) {

            btn.classList.remove("active");

        });


        button.classList.add("active");


        currentFilter =
            button.getAttribute("data-filter");


        filterProducts();

    });

});



/* ================= SEARCH ================= */

const searchInput =
    document.getElementById("searchInput");


searchInput.addEventListener("input", function() {

    filterProducts();

});



/* ================= FILTER FUNCTION ================= */

function filterProducts() {

    const searchText =
        searchInput.value
        .toLowerCase()
        .trim();


    let visibleProducts = 0;


    productCards.forEach(function(card) {


        const category =
            card.getAttribute("data-category");


        const productName =
            card.querySelector("h3")
            .innerText
            .toLowerCase();


        const matchesCategory =
            currentFilter === "all" ||
            category === currentFilter;


        const matchesSearch =
            productName.includes(searchText);


        if (matchesCategory && matchesSearch) {

            card.style.display = "block";

            visibleProducts++;

        }

        else {

            card.style.display = "none";

        }

    });


    productCount.innerText =
        visibleProducts +
        (visibleProducts === 1
            ? " Product"
            : " Products");


    if (visibleProducts === 0) {

        noProducts.style.display =
            "block";

    }

    else {

        noProducts.style.display =
            "none";

    }

}



/* ================= SORT PRODUCTS ================= */

const sortProducts =
    document.getElementById("sortProducts");

const productGrid =
    document.getElementById("productGrid");


sortProducts.addEventListener("change", function() {


    const sortValue =
        this.value;


    const products =
        Array.from(
            document.querySelectorAll(".product-card")
        );


    if (sortValue === "low-high") {

        products.sort(function(a, b) {

            return Number(a.dataset.price) -
                   Number(b.dataset.price);

        });

    }


    else if (sortValue === "high-low") {

        products.sort(function(a, b) {

            return Number(b.dataset.price) -
                   Number(a.dataset.price);

        });

    }


    else if (sortValue === "popular") {

        products.sort(function(a, b) {

            return Number(b.dataset.popularity) -
                   Number(a.dataset.popularity);

        });

    }


    products.forEach(function(product) {

        productGrid.appendChild(product);

    });

});



/* ================= ADD TO CART ================= */

function addProduct(name, price, image, weight) {

    let cart =
        JSON.parse(localStorage.getItem("ceylonTeaCart")) || [];


    const existingProduct = cart.find(function(item) {

        return item.name === name &&
               item.weight === weight;

    });


    if (existingProduct) {

        existingProduct.quantity++;

    }

    else {

        cart.push({
            name: name,
            price: price,
            image: image,
            weight: weight,
            quantity: 1
        });

    }


    localStorage.setItem(
        "ceylonTeaCart",
        JSON.stringify(cart)
    );


    updateCartCount();

    alert(name + " added to cart!");

}


/* ================= CART COUNT ================= */

function updateCartCount() {

    const cart =
        JSON.parse(localStorage.getItem("ceylonTeaCart")) || [];

    let count = 0;


    cart.forEach(function(item) {

        count += Number(item.quantity);

    });


    const cartCount =
        document.getElementById("cartCount");


    if (cartCount) {

        cartCount.innerText = count;

    }

}


/* ================= AUTH HEADER ================= */

function updateAuthHeader() {
    const isLoggedIn = localStorage.getItem("isLoggedIn");
    const currentUser = localStorage.getItem("currentUser");

    const loginLink = document.getElementById("loginLink");
    const accountLink = document.getElementById("accountLink");
    const logoutLink = document.getElementById("logoutLink");

    if (isLoggedIn === "true" && currentUser) {
        loginLink.style.display = "none";
        accountLink.style.display = "inline-block";
        logoutLink.style.display = "inline-block";
    } else {
        loginLink.style.display = "inline-block";
        accountLink.style.display = "none";
        logoutLink.style.display = "none";
    }
}


/* ================= LOGOUT ================= */

function logoutUser() {
    const answer = confirm("Are you sure you want to logout?");

    if (!answer) {
        return;
    }

    localStorage.removeItem("isLoggedIn");
    localStorage.removeItem("loggedInUser");
    localStorage.removeItem("currentUser");
    localStorage.removeItem("redirectAfterLogin");

    window.location.href = "index.php";
}


const logoutLink = document.getElementById("logoutLink");

if (logoutLink) {
    logoutLink.addEventListener("click", function() {
        logoutUser();
    });
}


/* ================= PAGE LOAD ================= */

document.addEventListener("DOMContentLoaded", function() {
    updateCartCount();
    updateAuthHeader();
});


</script>


</body>

</html>