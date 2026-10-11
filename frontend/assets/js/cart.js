
/* ==================================================
   CEYLON TEA HOUSE - CART
================================================== */

const CART_KEY = "ceylonTeaCart";
const CHECKOUT_URL =
    "/CEYLON-TEA-HOUSE/frontend/modules/checkout/checkout.php";
const LOGIN_URL =
    "/CEYLON-TEA-HOUSE/frontend/modules/auth/login.php";

/* ================= GET CART ================= */

function getCart() {
    try {
        return JSON.parse(localStorage.getItem(CART_KEY)) || [];
    } catch (error) {
        return [];
    }
}

/* ================= SAVE CART ================= */

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

/* ================= FORMAT PRICE ================= */

function formatPrice(price) {
    return "Rs. " + Number(price).toLocaleString();
}

/* ================= DISPLAY CART ================= */

function displayCart() {
    const cart = getCart();
    const cartItems = document.getElementById("cartItems");
    const emptyCart = document.getElementById("emptyCart");
    const cartSubtotal = document.getElementById("cartSubtotal");
    const cartTotal = document.getElementById("cartTotal");
    const shippingCost = document.getElementById("shippingCost");
    const checkoutButton = document.getElementById("checkoutButton");

    if (!cartItems) return;

    cartItems.innerHTML = "";
    let subtotal = 0;

    if (cart.length === 0) {
        if (emptyCart) emptyCart.style.display = "block";
        cartItems.style.display = "none";
        if (cartSubtotal) cartSubtotal.innerText = "Rs. 0";
        if (shippingCost) shippingCost.innerText = "Free";
        if (cartTotal) cartTotal.innerText = "Rs. 0";
        if (checkoutButton) checkoutButton.disabled = true;
        updateCartCount();
        return;
    }

    if (emptyCart) emptyCart.style.display = "none";
    cartItems.style.display = "block";
    if (checkoutButton) checkoutButton.disabled = false;

    cart.forEach(function (item, index) {
        const quantity = Math.max(1, Number(item.quantity) || 1);
        const price = Math.max(0, Number(item.price) || 0);
        const itemSubtotal = price * quantity;
        subtotal += itemSubtotal;

        const cartItem = document.createElement("div");
        cartItem.className = "cart-item";

        const productInfo = document.createElement("div");
        productInfo.className = "product-info";

        const image = document.createElement("img");
        image.src = item.image || "";
        image.alt = item.name || "Tea product";

        const productText = document.createElement("div");
        productText.className = "product-text";

        const productName = document.createElement("h3");
        productName.textContent = item.name || "Tea product";

        const weight = document.createElement("p");
        weight.textContent = "Weight: " + (item.weight || "250g");

        const removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.className = "remove-btn";
        removeButton.textContent = "Remove";
        removeButton.addEventListener("click", function () {
            removeItem(index);
        });

        productText.append(productName, weight, removeButton);
        productInfo.append(image, productText);

        const itemPrice = document.createElement("div");
        itemPrice.className = "item-price";
        itemPrice.textContent = formatPrice(price);

        const quantityBox = document.createElement("div");
        quantityBox.className = "quantity-box";

        const decreaseButton = document.createElement("button");
        decreaseButton.type = "button";
        decreaseButton.textContent = "−";
        decreaseButton.setAttribute("aria-label", "Decrease quantity");
        decreaseButton.addEventListener("click", function () {
            decreaseQuantity(index);
        });

        const quantityText = document.createElement("span");
        quantityText.textContent = quantity;

        const increaseButton = document.createElement("button");
        increaseButton.type = "button";
        increaseButton.textContent = "+";
        increaseButton.setAttribute("aria-label", "Increase quantity");
        increaseButton.addEventListener("click", function () {
            increaseQuantity(index);
        });

        quantityBox.append(decreaseButton, quantityText, increaseButton);

        const itemSubtotalElement = document.createElement("div");
        itemSubtotalElement.className = "item-subtotal";
        itemSubtotalElement.textContent = formatPrice(itemSubtotal);

        cartItem.append(
            productInfo,
            itemPrice,
            quantityBox,
            itemSubtotalElement
        );

        cartItems.appendChild(cartItem);
    });

    if (cartSubtotal) cartSubtotal.innerText = formatPrice(subtotal);
    if (shippingCost) shippingCost.innerText = "Free";
    if (cartTotal) cartTotal.innerText = formatPrice(subtotal);

    updateCartCount();
}

/* ================= QUANTITY ================= */

function increaseQuantity(index) {
    const cart = getCart();
    if (!cart[index]) return;

    cart[index].quantity = (Number(cart[index].quantity) || 1) + 1;
    saveCart(cart);
    displayCart();
}

function decreaseQuantity(index) {
    const cart = getCart();
    if (!cart[index]) return;

    const quantity = Number(cart[index].quantity) || 1;

    if (quantity > 1) {
        cart[index].quantity = quantity - 1;
    } else {
        cart.splice(index, 1);
    }

    saveCart(cart);
    displayCart();
}

function removeItem(index) {
    const cart = getCart();
    if (!cart[index]) return;

    if (!confirm("Remove this product from your cart?")) return;

    cart.splice(index, 1);
    saveCart(cart);
    displayCart();
}

/* ================= CLEAR CART ================= */

function clearCart() {
    const cart = getCart();

    if (cart.length === 0) {
        alert("Your cart is already empty.");
        return;
    }

    if (!confirm("Are you sure you want to clear your cart?")) return;

    localStorage.removeItem(CART_KEY);
    displayCart();
}

/* ================= CART COUNT ================= */

function updateCartCount() {
    const count = getCart().reduce(function (total, item) {
        return total + Math.max(0, Number(item.quantity) || 0);
    }, 0);

    const cartCount = document.getElementById("cartCount");
    if (cartCount) cartCount.innerText = count;
}

/* ================= AUTH HEADER ================= */

function updateAuthHeader() {
    const loginLink = document.getElementById("loginLink");
    const accountLink = document.getElementById("accountLink");
    const logoutLink = document.getElementById("logoutLink");

    // The PHP session is the trusted login status.
    fetch("/CEYLON-TEA-HOUSE/backend/api/session_status.php", {
        credentials: "same-origin"
    })
        .then(response => {
            if (!response.ok) throw new Error("Session check failed");
            return response.json();
        })
        .then(result => {
            const loggedIn = result.loggedIn === true;

            if (loginLink) loginLink.style.display = loggedIn ? "none" : "inline-block";
            if (accountLink) accountLink.style.display = loggedIn ? "inline-block" : "none";
            if (logoutLink) logoutLink.style.display = loggedIn ? "inline-block" : "none";
        })
        .catch(error => {
            console.error("Session status error:", error);
            if (loginLink) loginLink.style.display = "inline-block";
            if (accountLink) accountLink.style.display = "none";
            if (logoutLink) logoutLink.style.display = "none";
        });
}

/* ================= LOGOUT ================= */

async function logoutUser() {
    if (!confirm("Are you sure you want to logout?")) return;

    try {
        const response = await fetch(
            "/CEYLON-TEA-HOUSE/backend/api/logout.php",
            {
                method: "POST",
                credentials: "same-origin",
                headers: { "Accept": "application/json" }
            }
        );

        const result = await response.json();

        if (!response.ok || !result.success) {
            alert(result.message || "Logout failed. Please try again.");
            return;
        }

        localStorage.removeItem("isLoggedIn");
        localStorage.removeItem("loggedInUser");
        localStorage.removeItem("currentUser");
        localStorage.removeItem("redirectAfterLogin");

       window.location.href = "/CEYLON-TEA-HOUSE/frontend/index.php";
    } catch (error) {
        alert("Unable to connect. Please try again.");
    }
}

/* ================= CHECKOUT ================= */

async function goToCheckout() {
    if (getCart().length === 0) {
        alert("Your cart is empty. Please add a product first.");
        return;
    }

    try {
        const response = await fetch(
            "/CEYLON-TEA-HOUSE/backend/api/session_status.php",
            { credentials: "same-origin" }
        );

        if (!response.ok) throw new Error("Could not check login status");

        const result = await response.json();

        if (result.loggedIn === true) {
            window.location.href = CHECKOUT_URL;
            return;
        }

        localStorage.setItem("redirectAfterLogin", CHECKOUT_URL);
        window.location.href = LOGIN_URL;

    } catch (error) {
        console.error("Checkout session check failed:", error);
        alert("Could not check your login status. Please refresh and try again.");
    }
}

/* ================= PAGE LOAD ================= */

document.addEventListener("DOMContentLoaded", function () {
    displayCart();
    updateCartCount();
    updateAuthHeader();

    const clearCartButton = document.getElementById("clearCart");
    if (clearCartButton) {
        clearCartButton.addEventListener("click", clearCart);
    }

    const checkoutButton = document.getElementById("checkoutButton");
    if (checkoutButton) {
        checkoutButton.addEventListener("click", goToCheckout);
    }

    const logoutLink = document.getElementById("logoutLink");
    if (logoutLink) {
        logoutLink.addEventListener("click", function (event) {
            event.preventDefault();
            logoutUser();
        });
    }
});
