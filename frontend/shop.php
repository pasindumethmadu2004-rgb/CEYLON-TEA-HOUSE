<?php

require_once __DIR__ . '/../backend/config/db_connection.php';



$sql = "SELECT product_id, name, price, stock_qty, image_url, is_active, category, description, weight

        FROM products

        WHERE is_active = 1

        ORDER BY product_id ASC";

$result = $conn->query($sql);



if (!$result) {

    error_log('Shop products query failed: ' . $conn->error);

    $products = [];

} else {

    $products = $result->fetch_all(MYSQLI_ASSOC);

}



function e($value) {

    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');

}



/* Legacy display metadata is retained for existing products. New product
   details are read from the database columns category, description, weight. */

$productDetails = [

    'Premium Ceylon Black Tea' => [

        'category' => 'black-tea', 'label' => 'BLACK TEA', 'popularity' => 24,

        'rating' => 24, 'description' => 'Rich and classic Ceylon tea with a wonderful aroma and smooth taste.',

        'badge' => 'BEST SELLER', 'badge_class' => '', 'slug' => 'black-tea', 'weight' => '250g'

    ],

    'Pure Ceylon Green Tea' => [

        'category' => 'green-tea', 'label' => 'GREEN TEA', 'popularity' => 18,

        'rating' => 18, 'description' => 'Fresh and natural green tea made from carefully selected tea leaves.',

        'badge' => 'NEW', 'badge_class' => 'new', 'slug' => 'green-tea', 'weight' => '250g'

    ],

    'Classic Ceylon Tea Bags' => [

        'category' => 'tea-bags', 'label' => 'TEA BAGS', 'popularity' => 31,

        'rating' => 31, 'description' => 'Convenient tea bags delivering the authentic taste of Ceylon tea.',

        'badge' => 'POPULAR', 'badge_class' => '', 'slug' => 'tea-bags', 'weight' => '250g'

    ],

    'Premium Tea Gift Box' => [

        'category' => 'gift-box', 'label' => 'GIFT BOX', 'popularity' => 27,

        'rating' => 27, 'description' => 'A beautiful selection of premium Ceylon teas, perfect for gifting.',

        'badge' => 'GIFT', 'badge_class' => 'gift', 'slug' => 'premium-tea', 'weight' => '1 Box'

    ],

    'Ceylon Breakfast Tea' => [

        'category' => 'black-tea', 'label' => 'BLACK TEA', 'popularity' => 15,

        'rating' => 15, 'description' => 'A bold and refreshing tea that is perfect for starting your morning.',

        'badge' => '', 'badge_class' => '', 'slug' => 'black-tea', 'weight' => '250g'

    ],

    'Premium Green Tea' => [

        'category' => 'green-tea', 'label' => 'GREEN TEA', 'popularity' => 21,

        'rating' => 21, 'description' => 'Light, refreshing and naturally aromatic premium green tea.',

        'badge' => '', 'badge_class' => '', 'slug' => 'green-tea', 'weight' => '250g'

    ],

    'Ceylon Earl Grey Tea Bags' => [

        'category' => 'tea-bags', 'label' => 'TEA BAGS', 'popularity' => 12,

        'rating' => 12, 'description' => 'Fragrant Ceylon tea bags with a refreshing and elegant flavour.',

        'badge' => '', 'badge_class' => '', 'slug' => 'tea-bags', 'weight' => '250g'

    ],

    'Luxury Ceylon Tea Collection' => [

        'category' => 'gift-box', 'label' => 'GIFT BOX', 'popularity' => 35,

        'rating' => 35, 'description' => 'An elegant collection of selected Ceylon teas for special occasions.',

        'badge' => 'GIFT', 'badge_class' => 'gift', 'slug' => 'premium-tea', 'weight' => '1 Box'

    ],

];



function product_image_path($imageUrl, $productName) {

    $imageUrl = trim((string)$imageUrl);

    if ($imageUrl !== '') {

        // Keep local project paths and remote image URLs as saved in the database.

        if (preg_match('#^https?://#i', $imageUrl)) {

            return $imageUrl;

        }

        $imageUrl = ltrim($imageUrl, '/');

        if (strpos($imageUrl, 'frontend/') === 0) {

            $imageUrl = substr($imageUrl, strlen('frontend/'));

        }

        if (strpos($imageUrl, 'assets/') === 0) {

            return $imageUrl;

        }

        if (strpos($imageUrl, 'images/') === 0) {

            return 'assets/' . $imageUrl;

        }

        return 'assets/images/' . basename($imageUrl);

    }



    $name = strtolower($productName);

    if (strpos($name, 'green') !== false) return 'assets/images/green-tea.png.png';

    if (strpos($name, 'bag') !== false || strpos($name, 'earl grey') !== false) return 'assets/images/tea-bags.png.png';

    if (strpos($name, 'gift') !== false || strpos($name, 'collection') !== false) return 'assets/images/gift-box.png.png';

    return 'assets/images/black-tea.png.png';

}



function cart_image_path($imagePath) {

    if (preg_match('#^https?://#i', $imagePath)) return $imagePath;

    return '../../' . ltrim($imagePath, '/');

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shop | Ceylon Tea House</title>

    <link rel="stylesheet" href="assets/css/shop.css">

</head>

<body>



<!-- ================= HEADER ================= -->

<header class="header">

    <div class="logo">

        <h2>Ceylon Tea House</h2>

        <span>Authentic Ceylon Tea</span>

    </div>



    <nav>

        <a href="index.php">Home</a>

        <a href="shop.php" class="active">Shop</a>

        <a href="#">About</a>

        <a href="#">Contact</a>

    </nav>



    <div class="header-right">

        <div class="search">

            🔍

            <input type="text" id="searchInput" placeholder="Search tea...">

        </div>



        <div class="auth-links">

            <a href="modules/auth/login.php" id="loginLink" class="login-link">Login</a>

            <a href="modules/account/account.php" id="accountLink" class="account-link">My Account</a>

            <button type="button" id="logoutLink" class="logout-link">Logout</button>

        </div>



        <a href="modules/cart/cart.php" class="cart">🛒 Cart <span id="cartCount">0</span></a>

    </div>

</header>



<!-- ================= SHOP HERO ================= -->

<section class="shop-hero">

    <div class="hero-overlay">

        <p>EXPLORE OUR COLLECTION</p>

        <h1>Discover Your Perfect<br><span>Ceylon Tea</span></h1>

        <p class="hero-text">Carefully selected teas from the beautiful tea-growing regions of Sri Lanka.</p>

    </div>

</section>



<!-- ================= SHOP CONTENT ================= -->

<section class="shop-section">

    <div class="shop-heading">

        <div>

            <p class="small-title">OUR COLLECTION</p>

            <h2>Shop Ceylon Tea</h2>

        </div>

        <p class="product-count" id="productCount"><?php echo count($products); ?> Products</p>

    </div>



    <!-- ================= FILTER BAR ================= -->

    <div class="filter-bar">

        <div class="categories">

            <button class="filter active" data-filter="all">All</button>

            <button class="filter" data-filter="black-tea">Black Tea</button>

            <button class="filter" data-filter="green-tea">Green Tea</button>

            <button class="filter" data-filter="tea-bags">Tea Bags</button>

            <button class="filter" data-filter="gift-box">Gift Boxes</button>

        </div>



        <select id="sortProducts">

            <option value="default">Sort By</option>

            <option value="low-high">Price: Low to High</option>

            <option value="high-low">Price: High to Low</option>

            <option value="popular">Popular</option>

        </select>

    </div>



    <!-- ================= PRODUCTS FROM DATABASE ================= -->

    <div class="product-grid" id="productGrid">

        <?php foreach ($products as $product):

            $name = (string)$product['name'];

            $details = $productDetails[$name] ?? [
                'category' => 'all', 'label' => 'CEYLON TEA', 'popularity' => 0,
                'rating' => 0, 'description' => 'Discover authentic Ceylon tea, carefully selected for you.',
                'badge' => '', 'badge_class' => '', 'slug' => '', 'weight' => '250g'
            ];

            // Database values take priority when provided. Legacy mappings keep
            // the original products looking the same when their fields are blank.
            $dbCategory = trim((string)($product['category'] ?? ''));
            $dbDescription = trim((string)($product['description'] ?? ''));
            $dbWeight = trim((string)($product['weight'] ?? ''));
            if ($dbCategory !== '') {
                $details['category'] = strtolower($dbCategory);
                $details['label'] = strtoupper(str_replace(['-', '_'], ' ', $dbCategory));
            }
            if ($dbDescription !== '') {
                $details['description'] = $dbDescription;
            }
            if ($dbWeight !== '') {
                $details['weight'] = $dbWeight;
            }

            $imagePath = product_image_path($product['image_url'] ?? '', $name);

            $cartImage = cart_image_path($imagePath);

            $price = (float)$product['price'];

            $stock = (int)$product['stock_qty'];

            $detailUrl = 'modules/shop/product-details.php?product=product-' . (int)$product['product_id'];

        ?>

        <div class="product-card"

             data-category="<?php echo e($details['category']); ?>"

             data-price="<?php echo e($price); ?>"

             data-popularity="<?php echo e($details['popularity']); ?>">

            <div class="product-image">

                <?php if ($details['badge'] !== ''): ?>

                    <span class="badge <?php echo e($details['badge_class']); ?>"><?php echo e($details['badge']); ?></span>

                <?php endif; ?>



                <img src="<?php echo e($imagePath); ?>" alt="<?php echo e($name); ?>">

                <a href="<?php echo e($detailUrl); ?>" class="quick-view">VIEW FULL DETAILS</a>

            </div>



            <div class="product-info">

                <p class="category"><?php echo e($details['label']); ?></p>

                <h3><a href="<?php echo e($detailUrl); ?>"><?php echo e($name); ?></a></h3>



                <div class="rating">

                    <?php echo $details['rating'] > 0 ? '★★★★★' : '☆☆☆☆☆'; ?>

                    <span>(<?php echo e($details['rating']); ?>)</span>

                </div>



                <p class="description"><?php echo e($details['description']); ?></p>



                <div class="product-bottom">

                    <strong>Rs. <?php echo number_format($price, 2); ?></strong>

                    <button type="button"

                            class="add-to-cart-btn"

                            data-name="<?php echo e($name); ?>"

                            data-price="<?php echo e($price); ?>"

                            data-image="<?php echo e($cartImage); ?>"

                            data-weight="<?php echo e($details['weight']); ?>"

                            <?php echo $stock <= 0 ? 'disabled' : ''; ?>>

                        <?php echo $stock <= 0 ? 'Out of Stock' : '🛒 Add'; ?>

                    </button>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

    </div>



    <!-- ================= NO PRODUCTS MESSAGE ================= -->

    <p id="noProducts" class="no-products" <?php echo count($products) === 0 ? 'style="display:block"' : ''; ?>>

        <?php echo count($products) === 0 ? 'No products available at the moment.' : 'No products found.'; ?>

    </p>



    <!-- ================= PAGINATION (kept from original design) ================= -->

    <div class="pagination">

        <button class="page active" type="button">1</button>

        <button class="page" type="button">2</button>

        <button class="page" type="button">3</button>

        <button class="next" type="button">Next →</button>

    </div>

</section>



<!-- ================= FOOTER ================= -->

<footer>

    <div class="footer-container">

        <div>

            <h2>Ceylon Tea House</h2>

            <p>Authentic Ceylon Tea<br>from Sri Lanka.</p>

        </div>



        <div>

            <h3>Quick Links</h3>

            <a href="index.php">Home</a>

            <a href="shop.php">Shop</a>

            <a href="#">About Us</a>

            <a href="#">Contact</a>

        </div>



        <div>

            <h3>Customer Service</h3>

            <a href="#">Delivery</a>

            <a href="#">Returns</a>

            <a href="#">FAQ</a>

        </div>



        <div>

            <h3>Follow Us</h3>

            <p>Facebook</p>

            <p>Instagram</p>

        </div>

    </div>



    <div class="copyright">© 2026 Ceylon Tea House. All Rights Reserved.</div>

</footer>



<script>

/* ================= CATEGORY FILTER ================= */

const filterButtons = document.querySelectorAll('.filter');

const productCount = document.getElementById('productCount');

const noProducts = document.getElementById('noProducts');

const searchInput = document.getElementById('searchInput');

const sortProducts = document.getElementById('sortProducts');

const productGrid = document.getElementById('productGrid');

let currentFilter = 'all';



filterButtons.forEach(function(button) {

    button.addEventListener('click', function() {

        filterButtons.forEach(function(btn) { btn.classList.remove('active'); });

        button.classList.add('active');

        currentFilter = button.getAttribute('data-filter');

        filterProducts();

    });

});



searchInput.addEventListener('input', filterProducts);



function filterProducts() {

    const searchText = searchInput.value.toLowerCase().trim();

    let visibleProducts = 0;



    document.querySelectorAll('.product-card').forEach(function(card) {

        const category = card.getAttribute('data-category');

        const productName = card.querySelector('h3').innerText.toLowerCase();

        const categoryText = card.querySelector('.category').innerText.toLowerCase();

        const matchesCategory = currentFilter === 'all' || category === currentFilter;

        const matchesSearch = productName.includes(searchText) || categoryText.includes(searchText);



        if (matchesCategory && matchesSearch) {

            card.style.display = '';

            visibleProducts++;

        } else {

            card.style.display = 'none';

        }

    });



    productCount.innerText = visibleProducts + (visibleProducts === 1 ? ' Product' : ' Products');

    noProducts.style.display = visibleProducts === 0 ? 'block' : 'none';

}



/* ================= SORT PRODUCTS ================= */

sortProducts.addEventListener('change', function() {

    const sortValue = this.value;

    const products = Array.from(document.querySelectorAll('.product-card'));



    if (sortValue === 'low-high') {

        products.sort(function(a, b) { return Number(a.dataset.price) - Number(b.dataset.price); });

    } else if (sortValue === 'high-low') {

        products.sort(function(a, b) { return Number(b.dataset.price) - Number(a.dataset.price); });

    } else if (sortValue === 'popular') {

        products.sort(function(a, b) { return Number(b.dataset.popularity) - Number(a.dataset.popularity); });

    }



    products.forEach(function(product) { productGrid.appendChild(product); });

    filterProducts();

});



/* ================= ADD TO CART ================= */

function addProduct(name, price, image, weight) {

    let cart = JSON.parse(localStorage.getItem('ceylonTeaCart')) || [];

    const existingProduct = cart.find(function(item) {

        return item.name === name && item.weight === weight;

    });



    if (existingProduct) {

        existingProduct.quantity++;

    } else {

        cart.push({ name: name, price: Number(price), image: image, weight: weight, quantity: 1 });

    }



    localStorage.setItem('ceylonTeaCart', JSON.stringify(cart));

    updateCartCount();

    alert(name + ' added to cart!');

}



document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {

    button.addEventListener('click', function() {

        addProduct(

            this.dataset.name,

            this.dataset.price,

            this.dataset.image,

            this.dataset.weight

        );

    });

});



/* ================= CART COUNT ================= */

function updateCartCount() {

    const cart = JSON.parse(localStorage.getItem('ceylonTeaCart')) || [];

    let count = 0;

    cart.forEach(function(item) { count += Number(item.quantity) || 0; });

    const cartCount = document.getElementById('cartCount');

    if (cartCount) cartCount.innerText = count;

}



/* ================= AUTH HEADER ================= */

function updateAuthHeader() {

    const isLoggedIn = localStorage.getItem('isLoggedIn');

    const currentUser = localStorage.getItem('currentUser');

    const loginLink = document.getElementById('loginLink');

    const accountLink = document.getElementById('accountLink');

    const logoutLink = document.getElementById('logoutLink');



    if (isLoggedIn === 'true' && currentUser) {

        loginLink.style.display = 'none';

        accountLink.style.display = 'inline-block';

        logoutLink.style.display = 'inline-block';

    } else {

        loginLink.style.display = 'inline-block';

        accountLink.style.display = 'none';

        logoutLink.style.display = 'none';

    }

}



/* ================= LOGOUT ================= */

function logoutUser() {

    if (!confirm('Are you sure you want to logout?')) return;

    localStorage.removeItem('isLoggedIn');

    localStorage.removeItem('loggedInUser');

    localStorage.removeItem('currentUser');

    localStorage.removeItem('redirectAfterLogin');

    window.location.href = 'index.php';

}



const logoutLink = document.getElementById('logoutLink');

if (logoutLink) logoutLink.addEventListener('click', logoutUser);



document.addEventListener('DOMContentLoaded', function() {

    updateCartCount();

    updateAuthHeader();

    filterProducts();

});

</script>



</body>

</html>
