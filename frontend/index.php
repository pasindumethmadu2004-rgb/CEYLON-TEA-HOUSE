<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Ceylon Tea House</title>

    <link
        rel="stylesheet"
        href="assets/css/home.css">

</head>

<body>


<!-- ================= HEADER ================= -->

<header class="header">

    <div class="logo">

        <h2>Ceylon Tea House</h2>

        <span>
            Authentic Ceylon Tea
        </span>

    </div>


    <nav>

        <a href="index.php">
            Home
        </a>

        <a href="shop.php">
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
                placeholder="Search tea...">

        </div>


        <a href="#">
            Login
        </a>


        <a
            href="modules/cart/cart.php"
            class="cart">

            🛒 Cart

            <span id="cartCount">0</span>

        </a>

    </div>

</header>



<!-- ================= HERO ================= -->

<section class="hero">

    <div class="hero-content">

        <p class="small-title">
            WELCOME TO CEYLON TEA HOUSE
        </p>


        <h1>

            Taste the Finest<br>

            <span>
                Ceylon Tea
            </span>

        </h1>


        <p>

            Discover the rich taste and natural aroma
            of authentic tea from Sri Lanka.

        </p>


        <a
            href="shop.php"
            class="btn">

            SHOP NOW

        </a>

    </div>

</section>



<!-- ================= CATEGORIES ================= -->

<section class="categories">

    <div class="section-title">

        <p>
            EXPLORE OUR COLLECTION
        </p>

        <h2>
            Shop By Category
        </h2>

    </div>


    <div class="category-container">


        <div class="category-card">

            <div class="category-image">

                <img
                    src="assets/images/black-tea.png.png"
                    alt="Black Tea">

            </div>

            <h3>
                Black Tea
            </h3>

            <p>
                Rich & Classic
            </p>

        </div>



        <div class="category-card">

            <div class="category-image">

                <img
                    src="assets/images/green-tea.png.png"
                    alt="Green Tea">

            </div>

            <h3>
                Green Tea
            </h3>

            <p>
                Fresh & Natural
            </p>

        </div>



        <div class="category-card">

            <div class="category-image">

                <img
                    src="assets/images/tea-bags.png.png"
                    alt="Tea Bags">

            </div>

            <h3>
                Tea Bags
            </h3>

            <p>
                Easy & Convenient
            </p>

        </div>



        <div class="category-card">

            <div class="category-image">

                <img
                    src="assets/images/gift-box.png.png"
                    alt="Gift Boxes">

            </div>

            <h3>
                Gift Boxes
            </h3>

            <p>
                Perfect Gifts
            </p>

        </div>


    </div>

</section>



<!-- ================= FEATURED PRODUCTS ================= -->

<section class="products">

    <div class="section-title">

        <p>
            OUR BEST SELLERS
        </p>

        <h2>
            Featured Products
        </h2>

    </div>


    <div class="product-container">


        <!-- ================= PRODUCT 01 ================= -->

        <div class="product-card">

            <div class="product-image">

                <img
                    src="assets/images/black-tea2.png"
                    alt="Ceylon Black Tea">

            </div>


            <div class="product-info">

                <h3>
                    Ceylon Black Tea
                </h3>


                <div class="stars">
                    ★★★★★
                </div>


                <p class="price">
                    Rs. 2,500
                </p>


                <button
                    type="button"
                    onclick="addProduct(
                        'Ceylon Black Tea',
                        2500,
                        '../../assets/images/black-tea2.png',
                        '250g'
                    )">

                    Add to Cart

                </button>

            </div>

        </div>



        <!-- ================= PRODUCT 02 ================= -->

        <div class="product-card">

            <div class="product-image">

                <img
                    src="assets/images/green-tea2.png"
                    alt="Ceylon Green Tea">

            </div>


            <div class="product-info">

                <h3>
                    Ceylon Green Tea
                </h3>


                <div class="stars">
                    ★★★★★
                </div>


                <p class="price">
                    Rs. 2,300
                </p>


                <button
                    type="button"
                    onclick="addProduct(
                        'Ceylon Green Tea',
                        2300,
                        '../../assets/images/green-tea2.png',
                        '250g'
                    )">

                    Add to Cart

                </button>

            </div>

        </div>



        <!-- ================= PRODUCT 03 ================= -->

        <div class="product-card">

            <div class="product-image">

                <img
                    src="assets/images/tea-bag.png"
                    alt="Ceylon Tea Bags">

            </div>


            <div class="product-info">

                <h3>
                    Ceylon Tea Bags
                </h3>


                <div class="stars">
                    ★★★★★
                </div>


                <p class="price">
                    Rs. 1,200
                </p>


                <button
                    type="button"
                    onclick="addProduct(
                        'Ceylon Tea Bags',
                        1200,
                        '../../assets/images/tea-bag.png',
                        '250g'
                    )">

                    Add to Cart

                </button>

            </div>

        </div>



        <!-- ================= PRODUCT 04 ================= -->

        <div class="product-card">

            <div class="product-image">

                <img
                    src="assets/images/gift_box.png"
                    alt="Premium Tea Gift Box">

            </div>


            <div class="product-info">

                <h3>
                    Premium Tea Gift Box
                </h3>


                <div class="stars">
                    ★★★★★
                </div>


                <p class="price">
                    Rs. 3,500
                </p>


                <button
                    type="button"
                    onclick="addProduct(
                        'Premium Tea Gift Box',
                        3500,
                        '../../assets/images/gift_box.png',
                        '1 Box'
                    )">

                    Add to Cart

                </button>

            </div>

        </div>


    </div>



    <div class="view-all">

        <a
            href="shop.php"
            class="outline-btn">

            VIEW ALL PRODUCTS

        </a>

    </div>

</section>



<!-- ================= TEA REGIONS ================= -->

<section class="regions">

    <div class="section-title">

        <p>
            FROM THE ISLAND OF CEYLON
        </p>

        <h2>
            Explore Tea Regions
        </h2>

    </div>


    <div class="region-container">


        <div class="region-card">

            <div class="region-image">

                <img
                    src="assets/images/nuwaraeliya.png"
                    alt="Nuwara Eliya">

            </div>

            <h3>
                Nuwara Eliya
            </h3>

        </div>



        <div class="region-card">

            <div class="region-image">

                <img
                    src="assets/images/kandy.png"
                    alt="Kandy">

            </div>

            <h3>
                Kandy
            </h3>

        </div>



        <div class="region-card">

            <div class="region-image">

                <img
                    src="assets/images/uva.png"
                    alt="Uva">

            </div>

            <h3>
                Uva
            </h3>

        </div>



        <div class="region-card">

            <div class="region-image">

                <img
                    src="assets/images/dimbula.png"
                    alt="Dimbula">

            </div>

            <h3>
                Dimbula
            </h3>

        </div>


    </div>

</section>



<!-- ================= ABOUT ================= -->

<section class="about">

    <div class="about-image">

        <img
            src="assets/images/top.png"
            alt="About Ceylon Tea House">

    </div>


    <div class="about-content">

        <p>
            OUR STORY
        </p>


        <h2>
            Discover the Beauty of Ceylon Tea
        </h2>


        <p>

            Ceylon Tea is known around the world for its unique
            taste, wonderful aroma and high quality. Explore
            carefully selected tea products from the beautiful
            tea-growing regions of Sri Lanka.

        </p>


        <a
            href="#"
            class="btn">

            LEARN MORE

        </a>

    </div>

</section>



<!-- ================= REVIEWS ================= -->

<section class="reviews">

    <div class="section-title">

        <p>
            WHAT PEOPLE SAY
        </p>

        <h2>
            Customer Reviews
        </h2>

    </div>


    <div class="review-container">


        <div class="review-card">

            <div class="stars">
                ★★★★★
            </div>

            <p>
                "Amazing quality and beautiful
                Ceylon tea."
            </p>

            <h4>
                - Customer 01
            </h4>

        </div>



        <div class="review-card">

            <div class="stars">
                ★★★★★
            </div>

            <p>
                "The tea was fresh and had
                a wonderful aroma."
            </p>

            <h4>
                - Customer 02
            </h4>

        </div>



        <div class="review-card">

            <div class="stars">
                ★★★★★
            </div>

            <p>
                "Very happy with my purchase.
                Highly recommended!"
            </p>

            <h4>
                - Customer 03
            </h4>

        </div>


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
                Authentic Ceylon Tea<br>
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



<!-- ==================================================
     CART JAVASCRIPT
================================================== -->

<script>


/* ================= ADD PRODUCT ================= */

function addProduct(
    name,
    price,
    image,
    weight
) {

    let cart =
        JSON.parse(
            localStorage.getItem(
                "ceylonTeaCart"
            )
        ) || [];


    const existingProduct =
        cart.find(function(item) {

            return (
                item.name === name &&
                item.weight === weight
            );

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


    alert(
        name +
        " added to cart!"
    );

}



/* ================= CART COUNT ================= */

function updateCartCount() {

    const cart =
        JSON.parse(
            localStorage.getItem(
                "ceylonTeaCart"
            )
        ) || [];


    let count = 0;


    cart.forEach(function(item) {

        count +=
            Number(item.quantity);

    });


    const cartCount =
        document.getElementById(
            "cartCount"
        );


    if (cartCount) {

        cartCount.innerText =
            count;

    }

}



/* ================= PAGE LOAD ================= */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        updateCartCount();

    }
);


</script>


</body>

</html>