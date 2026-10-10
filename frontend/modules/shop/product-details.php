<?php
require_once __DIR__ . '/../../../backend/config/db_connection.php';

/*
 * The products table currently stores one price per product.
 * The 250g price below comes from the database.
 * 100g and 500g values are legacy display values from the original page.
 */
$product = $_GET['product'] ?? 'black-tea';

$slugToName = [
    'black-tea'   => 'Premium Ceylon Black Tea',
    'green-tea'   => 'Pure Ceylon Green Tea',
    'tea-bags'    => 'Classic Ceylon Tea Bags',
    'premium-tea' => 'Premium Tea Gift Box'
];

function teaImagePath($imageUrl)
{
    $imageUrl = trim((string) $imageUrl);

    if ($imageUrl === '') {
        return '../../assets/images/black-tea.png.png';
    }

    if (preg_match('/^https?:\/\//i', $imageUrl)) {
        return $imageUrl;
    }

    return '../../' . ltrim($imageUrl, '/');
}

function teaDescription($name, $category)
{
    $text = strtolower($name . ' ' . $category);

    if (strpos($text, 'green') !== false) {
        return [
            'Enjoy the light and refreshing taste of Ceylon Green Tea, carefully selected for its natural aroma and smooth flavour.',
            'Ceylon Green Tea offers a fresh and gentle flavour with a naturally pleasant aroma. It is carefully processed to maintain its quality and freshness.'
        ];
    }

    if (strpos($text, 'bag') !== false) {
        return [
            'Enjoy authentic Ceylon Tea in a convenient tea bag, perfect for a quick and refreshing cup at any time of the day.',
            'Our Ceylon Tea Bags combine convenience with the authentic taste of Sri Lankan tea. Each tea bag is carefully packed to preserve freshness and aroma.'
        ];
    }

    if (strpos($text, 'gift') !== false || strpos($text, 'collection') !== false) {
        return [
            'Discover a special Ceylon Tea collection, selected for its aroma, flavour and quality. It is a thoughtful gift for tea lovers.',
            'This Ceylon Tea collection brings together carefully selected tea products, packed to preserve freshness and quality.'
        ];
    }

    return [
        'Experience the rich taste and wonderful aroma of authentic Ceylon Black Tea, carefully selected from Sri Lanka.',
        'Ceylon Black Tea is known for its rich colour, refreshing aroma and bold flavour. Our tea is carefully selected and packed to preserve its freshness and natural quality.'
    ];
}

function legacyWeightPrices($name, $category, $databasePrice)
{
    $text = strtolower($name . ' ' . $category);

    if (strpos($text, 'green') !== false) {
        return ['100g' => 1100, '250g' => (float) $databasePrice, '500g' => 4200];
    }

    if (strpos($text, 'bag') !== false) {
        return ['100g' => 700, '250g' => (float) $databasePrice, '500g' => 2200];
    }

    if (strpos($text, 'gift') !== false || strpos($text, 'collection') !== false) {
        return ['100g' => 1400, '250g' => (float) $databasePrice, '500g' => 5000];
    }

    return ['100g' => 1200, '250g' => (float) $databasePrice, '500g' => 4500];
}

$sql = "SELECT product_id, name, price, stock_qty, image_url, is_active, category, description, weight
        FROM products
        WHERE is_active = 1
        ORDER BY product_id ASC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    exit('Unable to load products right now.');
}

$products = [];
$rows = [];

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

foreach ($rows as $row) {
    $id = (int) $row['product_id'];
    $name = $row['name'];
    $dbCategory = trim((string)($row['category'] ?? ''));
    $category = $dbCategory !== '' ? ucwords(str_replace(['-', '_'], ' ', $dbCategory)) : 'Ceylon Tea';

    // If older products have no meaningful database category, preserve the
    // original category detection for those products.
    $nameLower = strtolower($name);
    if ($dbCategory === '') {
        if (strpos($nameLower, 'green') !== false) {
            $category = 'Green Tea';
        } elseif (strpos($nameLower, 'bag') !== false || strpos($nameLower, 'earl grey') !== false) {
            $category = 'Tea Bags';
        } elseif (strpos($nameLower, 'gift') !== false || strpos($nameLower, 'collection') !== false) {
            $category = 'Premium Tea';
        } elseif (strpos($nameLower, 'black') !== false || strpos($nameLower, 'breakfast') !== false) {
            $category = 'Black Tea';
        }
    }

    $descriptions = teaDescription($name, $category);
    $dbDescription = trim((string)($row['description'] ?? ''));
    if ($dbDescription !== '') {
        $descriptions[0] = $dbDescription;
        $descriptions[1] = $dbDescription;
    }
    $image = teaImagePath($row['image_url'] ?? '');
    $extraImages = [
        'https://images.unsplash.com/photo-1544787219-7f47ccb76574?auto=format&fit=crop&w=1000&q=80',
        'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?auto=format&fit=crop&w=1000&q=80'
    ];

    $key = 'product-' . $id;
    foreach ($slugToName as $slug => $mappedName) {
        if (strcasecmp($mappedName, $name) === 0) {
            $key = $slug;
            break;
        }
    }

    $products[$key] = [
        'product_id' => $id,
        'name' => $name,
        'category_title' => strtoupper($category),
        'category' => $category,
        'weight' => trim((string)($row['weight'] ?? '')) ?: '250g',
        'origin' => 'Sri Lanka',
        'code' => 'CTH-' . str_pad((string) $id, 4, '0', STR_PAD_LEFT),
        'description' => $descriptions[0],
        'long_description' => $descriptions[1],
        'prices' => legacyWeightPrices($name, $category, $row['price']),
        'main_image' => $image,
        'images' => array_merge([$image], $extraImages),
        'stock_qty' => (int) $row['stock_qty']
    ];
}

$currentKey = null;

if (isset($slugToName[$product])) {
    foreach ($products as $key => $item) {
        if (strcasecmp($item['name'], $slugToName[$product]) === 0) {
            $currentKey = $key;
            break;
        }
    }
} elseif (preg_match('/^product-(\d+)$/', (string) $product, $matches)) {
    foreach ($products as $key => $item) {
        if ($item['product_id'] === (int) $matches[1]) {
            $currentKey = $key;
            break;
        }
    }
} elseif (ctype_digit((string) $product)) {
    foreach ($products as $key => $item) {
        if ($item['product_id'] === (int) $product) {
            $currentKey = $key;
            break;
        }
    }
}

if ($currentKey === null) {
    http_response_code(404);
    exit('No active products were found. Please add an active product in the database.');
}

$current = $products[$currentKey];
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

                <?php echo $current['stock_qty'] > 0 ? '✓ In Stock (' . (int) $current['stock_qty'] . ')' : 'Out of Stock'; ?>

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

                id="addToCartButton" <?php echo $current['stock_qty'] <= 0 ? 'disabled' : ''; ?>>



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
                <strong>Package weight:</strong>
                <?php echo htmlspecialchars($current['weight']); ?>
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



            if ($key == $currentKey) {

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

\=================================================== -->



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

            const availableStock = <?php echo (int) $current['stock_qty']; ?>;

            if (availableStock <= 0 || quantity > availableStock) {
                alert("Sorry, this quantity is not available in stock.");
                return;
            }





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