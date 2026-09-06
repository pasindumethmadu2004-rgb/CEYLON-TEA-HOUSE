<?php

$product = $_GET['product'] ?? 'black-tea';

$products = [

    'black-tea' => [
        'name' => 'Ceylon Black Tea',
        'category_title' => 'PREMIUM CEYLON TEA',
        'category' => 'Black Tea',
        'origin' => 'Sri Lanka',
        'code' => 'CTH-BT-001',

        'description' =>
            'Experience the rich taste and wonderful aroma of authentic Ceylon Black Tea. Carefully selected from the finest tea-growing regions of Sri Lanka.',

        'long_description' =>
            'Ceylon Black Tea is known around the world for its rich colour, refreshing aroma and bold flavour. Our tea is carefully selected and packed to preserve its freshness and natural quality.',

        'prices' => [
            '100g' => 1200,
            '250g' => 2500,
            '500g' => 4500
        ],

        'main_image' =>
            'https://images.unsplash.com/photo-1594631252845-29fc4cc8cde9?auto=format&fit=crop&w=1000&q=80',

        'images' => [
            'https://images.unsplash.com/photo-1594631252845-29fc4cc8cde9?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?auto=format&fit=crop&w=1000&q=80'
        ]
    ],


    'green-tea' => [
        'name' => 'Ceylon Green Tea',
        'category_title' => 'PURE CEYLON GREEN TEA',
        'category' => 'Green Tea',
        'origin' => 'Sri Lanka',
        'code' => 'CTH-GT-002',

        'description' =>
            'Enjoy the light and refreshing taste of premium Ceylon Green Tea, carefully selected for its natural aroma and smooth flavour.',

        'long_description' =>
            'Ceylon Green Tea offers a fresh and gentle flavour with a naturally pleasant aroma. It is carefully processed to maintain its quality and freshness.',

        'prices' => [
            '100g' => 1100,
            '250g' => 2300,
            '500g' => 4200
        ],

        'main_image' =>
            'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?auto=format&fit=crop&w=1000&q=80',

        'images' => [
            'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1594631252845-29fc4cc8cde9?auto=format&fit=crop&w=1000&q=80'
        ]
    ],


    'tea-bags' => [
        'name' => 'Ceylon Tea Bags',
        'category_title' => 'EASY EVERYDAY CEYLON TEA',
        'category' => 'Tea Bags',
        'origin' => 'Sri Lanka',
        'code' => 'CTH-TB-003',

        'description' =>
            'Enjoy authentic Ceylon Tea in a convenient tea bag, perfect for a quick and refreshing cup at any time of the day.',

        'long_description' =>
            'Our Ceylon Tea Bags combine convenience with the authentic taste of Sri Lankan tea. Each tea bag is carefully packed to preserve freshness and aroma.',

        'prices' => [
            '100g' => 700,
            '250g' => 1200,
            '500g' => 2200
        ],

        'main_image' =>
            'https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=1000&q=80',

        'images' => [
            'https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1594631252845-29fc4cc8cde9?auto=format&fit=crop&w=1000&q=80'
        ]
    ],


    'premium-tea' => [
        'name' => 'Premium Ceylon Tea',
        'category_title' => 'EXCLUSIVE CEYLON COLLECTION',
        'category' => 'Premium Tea',
        'origin' => 'Sri Lanka',
        'code' => 'CTH-PT-004',

        'description' =>
            'Discover a premium Ceylon Tea selected for its exceptional aroma, elegant flavour and high-quality tea leaves.',

        'long_description' =>
            'Premium Ceylon Tea is carefully selected from high-quality tea leaves to provide a rich and elegant tea experience. Ideal for tea lovers who enjoy a premium cup.',

        'prices' => [
            '100g' => 1400,
            '250g' => 2700,
            '500g' => 5000
        ],

        'main_image' =>
            'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?auto=format&fit=crop&w=1000&q=80',

        'images' => [
            'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1594631252845-29fc4cc8cde9?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?auto=format&fit=crop&w=1000&q=80'
        ]
    ]

];


if (!isset($products[$product])) {
    $product = 'black-tea';
}

$current = $products[$product];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo htmlspecialchars($current['name']); ?>
        | Ceylon Tea House
    </title>

    <link
        rel="stylesheet"
        href="../../assets/css/product-details.css">

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
            href="../cart/cart.php"
            class="cart">

            🛒 Cart

            <span id="cartCount">0</span>

        </a>

    </div>

</header>



<!-- ================= BREADCRUMB ================= -->

<section class="breadcrumb">

    <a href="../../index.php">
        Home
    </a>

    <span>›</span>

    <a href="../../shop.php">
        Shop
    </a>

    <span>›</span>

    <span>
        <?php echo htmlspecialchars($current['name']); ?>
    </span>

</section>



<!-- ================= PRODUCT DETAILS ================= -->

<section class="product-details">


    <!-- LEFT SIDE -->

    <div class="product-gallery">


        <div class="main-image">

            <img
                id="mainProductImage"
                src="<?php echo htmlspecialchars($current['main_image']); ?>"
                alt="<?php echo htmlspecialchars($current['name']); ?>">

        </div>



        <!-- THUMBNAILS -->

        <div class="small-images">

            <?php foreach ($current['images'] as $index => $image) { ?>

                <div
                    class="small-image <?php echo $index === 0 ? 'active-image' : ''; ?>"
                    data-image="<?php echo htmlspecialchars($image); ?>">

                    <img
                        src="<?php echo htmlspecialchars($image); ?>"
                        alt="<?php echo htmlspecialchars($current['name']); ?>">

                </div>

            <?php } ?>

        </div>

    </div>



    <!-- RIGHT SIDE -->

    <div class="product-content">


        <p class="category-name">

            <?php
            echo htmlspecialchars(
                $current['category_title']
            );
            ?>

        </p>


        <h1>

            <?php
            echo htmlspecialchars(
                $current['name']
            );
            ?>

        </h1>



        <div class="rating">

            <span class="stars">
                ★★★★★
            </span>

            <span class="reviews">
                (128 Reviews)
            </span>

        </div>



        <!-- PRICE -->

        <p
            class="product-price"
            id="productPrice">

            Rs.
            <?php
            echo number_format(
                $current['prices']['250g']
            );
            ?>

        </p>



        <!-- DESCRIPTION -->

        <p class="description">

            <?php echo $current['description']; ?>

        </p>


        <hr>



        <!-- AVAILABILITY -->

        <div class="availability">

            <span class="label">
                Availability:
            </span>

            <span class="stock">
                ✓ In Stock
            </span>

        </div>



        <!-- WEIGHT -->

        <div class="weight-section">

            <span class="label">
                Select Weight:
            </span>


            <div class="weight-buttons">

                <?php
                foreach (
                    $current['prices']
                    as $weight => $price
                ) {
                ?>

                    <button
                        type="button"
                        class="weight-btn <?php echo $weight === '250g' ? 'active-weight' : ''; ?>"
                        data-weight="<?php echo htmlspecialchars($weight); ?>"
                        data-price="<?php echo $price; ?>">

                        <?php echo htmlspecialchars($weight); ?>

                    </button>

                <?php } ?>

            </div>

        </div>



        <!-- QUANTITY -->

        <div class="quantity-section">

            <span class="label">
                Quantity:
            </span>


            <div class="quantity-box">

                <button
                    type="button"
                    id="minusButton">

                    -

                </button>


                <input
                    type="number"
                    id="quantity"
                    value="1"
                    min="1"
                    readonly>


                <button
                    type="button"
                    id="plusButton">

                    +

                </button>

            </div>

        </div>



        <!-- BUTTONS -->

        <div class="product-buttons">

            <button
                type="button"
                class="add-cart"
                id="addToCartButton">

                🛒 ADD TO CART

            </button>


            <button
                type="button"
                class="buy-now">

                BUY NOW

            </button>

        </div>



        <!-- META -->

        <div class="product-meta">


            <p>

                <strong>
                    Category:
                </strong>

                <?php
                echo htmlspecialchars(
                    $current['category']
                );
                ?>

            </p>


            <p>

                <strong>
                    Origin:
                </strong>

                <?php
                echo htmlspecialchars(
                    $current['origin']
                );
                ?>

            </p>


            <p>

                <strong>
                    Selected Weight:
                </strong>

                <span id="selectedWeightText">
                    250g
                </span>

            </p>


            <p>

                <strong>
                    Product Code:
                </strong>

                <?php
                echo htmlspecialchars(
                    $current['code']
                );
                ?>

            </p>

        </div>



        <!-- FEATURES -->

        <div class="features">


            <div>

                <span class="feature-icon">
                    🌿
                </span>

                <span>
                    100% Pure<br>
                    Ceylon Tea
                </span>

            </div>


            <div>

                <span class="feature-icon">
                    🚚
                </span>

                <span>
                    Islandwide<br>
                    Delivery
                </span>

            </div>


            <div>

                <span class="feature-icon">
                    🔒
                </span>

                <span>
                    Secure<br>
                    Payment
                </span>

            </div>

        </div>

    </div>

</section>



<!-- ================= DESCRIPTION ================= -->

<section class="information">

    <div class="info-title">

        <h2>
            Product Description
        </h2>

    </div>


    <div class="info-content">

        <p>

            <?php
            echo $current['long_description'];
            ?>

        </p>


        <ul>

            <li>
                100% authentic Ceylon Tea
            </li>

            <li>
                Premium quality tea leaves
            </li>

            <li>
                Fresh and naturally aromatic
            </li>

            <li>
                Carefully packed for freshness
            </li>

            <li>
                Perfect for everyday tea lovers
            </li>

        </ul>

    </div>

</section>



<!-- ================= RELATED PRODUCTS ================= -->

<section class="related">

    <div class="section-title">

        <p>
            YOU MAY ALSO LIKE
        </p>

        <h2>
            Related Products
        </h2>

    </div>


    <div class="related-container">


        <?php

        foreach ($products as $key => $item) {

            if ($key == $product) {
                continue;
            }

        ?>


            <div class="product-card">


                <div class="card-image">

                    <img
                        src="<?php echo htmlspecialchars($item['main_image']); ?>"
                        alt="<?php echo htmlspecialchars($item['name']); ?>">

                </div>


                <div class="card-content">

                    <h3>

                        <?php
                        echo htmlspecialchars(
                            $item['name']
                        );
                        ?>

                    </h3>


                    <div class="stars">
                        ★★★★★
                    </div>


                    <p class="card-price">

                        Rs.

                        <?php
                        echo number_format(
                            $item['prices']['250g']
                        );
                        ?>

                    </p>


                    <a
                        href="product-details.php?product=<?php echo urlencode($key); ?>"
                        class="view-product-btn">

                        VIEW PRODUCT

                    </a>

                </div>

            </div>


        <?php } ?>

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

            <a href="../../index.php">
                Home
            </a>

            <a href="../../shop.php">
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



<!-- ===================================================
     JAVASCRIPT - KEEP THIS INSIDE product-details.php
=================================================== -->

<script>

document.addEventListener("DOMContentLoaded", function () {

    /* ================= PRODUCT DATA ================= */

    const productName =
        <?php echo json_encode($current['name']); ?>;

    const productImage =
        <?php echo json_encode($current['main_image']); ?>;


    let selectedWeight = "250g";

    let selectedPrice =
        <?php echo (int)$current['prices']['250g']; ?>;



    /* ================= IMAGE CHANGE ================= */

    const thumbnails =
        document.querySelectorAll(".small-image");


    thumbnails.forEach(function (thumbnail) {

        thumbnail.addEventListener(
            "click",
            function () {

                const imageUrl =
                    this.dataset.image;


                const mainImage =
                    document.getElementById(
                        "mainProductImage"
                    );


                mainImage.src =
                    imageUrl;


                thumbnails.forEach(
                    function (item) {

                        item.classList.remove(
                            "active-image"
                        );

                    }
                );


                this.classList.add(
                    "active-image"
                );

            }
        );

    });



    /* ================= WEIGHT ================= */

    const weightButtons =
        document.querySelectorAll(
            ".weight-btn"
        );


    weightButtons.forEach(
        function (button) {

            button.addEventListener(
                "click",
                function () {

                    weightButtons.forEach(
                        function (btn) {

                            btn.classList.remove(
                                "active-weight"
                            );

                        }
                    );


                    this.classList.add(
                        "active-weight"
                    );


                    selectedWeight =
                        this.dataset.weight;


                    selectedPrice =
                        Number(
                            this.dataset.price
                        );


                    document.getElementById(
                        "productPrice"
                    ).innerText =
                        "Rs. " +
                        selectedPrice.toLocaleString();


                    document.getElementById(
                        "selectedWeightText"
                    ).innerText =
                        selectedWeight;

                }
            );

        }
    );



    /* ================= QUANTITY ================= */

    const quantityInput =
        document.getElementById(
            "quantity"
        );


    const plusButton =
        document.getElementById(
            "plusButton"
        );


    const minusButton =
        document.getElementById(
            "minusButton"
        );


    plusButton.addEventListener(
        "click",
        function () {

            let quantity =
                Number(
                    quantityInput.value
                );


            quantity++;


            quantityInput.value =
                quantity;

        }
    );


    minusButton.addEventListener(
        "click",
        function () {

            let quantity =
                Number(
                    quantityInput.value
                );


            if (quantity > 1) {

                quantity--;

                quantityInput.value =
                    quantity;

            }

        }
    );



    /* ================= CART COUNT ================= */

    function updateCartCount() {

        const cart =
            JSON.parse(
                localStorage.getItem(
                    "ceylonTeaCart"
                )
            ) || [];


        let count = 0;


        cart.forEach(
            function (item) {

                count +=
                    Number(
                        item.quantity
                    );

            }
        );


        const cartCount =
            document.getElementById(
                "cartCount"
            );


        cartCount.innerText =
            count;

    }



    /* ================= ADD TO CART ================= */

    const addToCartButton =
        document.getElementById(
            "addToCartButton"
        );


    addToCartButton.addEventListener(
        "click",
        function () {

            const quantity =
                Number(
                    quantityInput.value
                );


            let cart =
                JSON.parse(
                    localStorage.getItem(
                        "ceylonTeaCart"
                    )
                ) || [];


            const existingProduct =
                cart.find(
                    function (item) {

                        return (
                            item.name === productName &&
                            item.weight === selectedWeight
                        );

                    }
                );


            if (existingProduct) {

                existingProduct.quantity +=
                    quantity;

            }

            else {

                cart.push({

                    name: productName,

                    price: selectedPrice,

                    image: productImage,

                    weight: selectedWeight,

                    quantity: quantity

                });

            }


            localStorage.setItem(
                "ceylonTeaCart",
                JSON.stringify(cart)
            );


            updateCartCount();


            alert(
                productName +
                " (" +
                selectedWeight +
                ") added to cart!"
            );

        }
    );



    /* ================= INITIAL CART COUNT ================= */

    updateCartCount();

});

</script>


</body>

</html>