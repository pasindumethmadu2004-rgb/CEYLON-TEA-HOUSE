/* ==================================================
   CEYLON TEA HOUSE - CART
================================================== */


const CART_KEY = "ceylonTeaCart";


/* ================= GET CART ================= */

function getCart() {

    return (
        JSON.parse(
            localStorage.getItem(
                CART_KEY
            )
        ) || []
    );

}


/* ================= SAVE CART ================= */

function saveCart(cart) {

    localStorage.setItem(
        CART_KEY,
        JSON.stringify(cart)
    );

}


/* ================= FORMAT PRICE ================= */

function formatPrice(price) {

    return (
        "Rs. " +
        Number(price).toLocaleString()
    );

}


/* ================= DISPLAY CART ================= */

function displayCart() {

    const cart =
        getCart();


    const cartItems =
        document.getElementById(
            "cartItems"
        );


    const emptyCart =
        document.getElementById(
            "emptyCart"
        );


    const cartSubtotal =
        document.getElementById(
            "cartSubtotal"
        );


    const cartTotal =
        document.getElementById(
            "cartTotal"
        );


    const shippingCost =
        document.getElementById(
            "shippingCost"
        );


    const checkoutButton =
        document.getElementById(
            "checkoutButton"
        );


    /*
        Safety check
    */

    if (!cartItems) {
        return;
    }


    cartItems.innerHTML = "";


    let subtotal = 0;


    /* ================= EMPTY CART ================= */

    if (cart.length === 0) {

        emptyCart.style.display =
            "block";


        cartItems.style.display =
            "none";


        cartSubtotal.innerText =
            "Rs. 0";


        shippingCost.innerText =
            "Free";


        cartTotal.innerText =
            "Rs. 0";


        if (checkoutButton) {

            checkoutButton.disabled =
                true;

        }


        updateCartCount();

        return;

    }


    /* ================= CART HAS PRODUCTS ================= */

    emptyCart.style.display =
        "none";


    cartItems.style.display =
        "block";


    if (checkoutButton) {

        checkoutButton.disabled =
            false;

    }



    /* ================= CREATE PRODUCTS ================= */

    cart.forEach(
        function(item, index) {


            const quantity =
                Number(
                    item.quantity || 1
                );


            const price =
                Number(
                    item.price || 0
                );


            const itemSubtotal =
                price * quantity;


            subtotal +=
                itemSubtotal;



            const cartItem =
                document.createElement(
                    "div"
                );


            cartItem.className =
                "cart-item";


            /*
                IMPORTANT

                Class names me CSS ekata
                match wenawa:
                cart-item
                product-info
                product-text
                remove-btn
                item-price
                quantity-box
                item-subtotal
            */

            cartItem.innerHTML = `

                <div class="product-info">

                    <img
                        src="${item.image}"
                        alt="${item.name}">

                    <div class="product-text">

                        <h3>
                            ${item.name}
                        </h3>

                        <p>
                            Weight:
                            ${item.weight || "250g"}
                        </p>

                        <button
                            type="button"
                            class="remove-btn"
                            onclick="removeItem(${index})">

                            Remove

                        </button>

                    </div>

                </div>


                <div class="item-price">

                    ${formatPrice(price)}

                </div>


                <div class="quantity-box">

                    <button
                        type="button"
                        onclick="decreaseQuantity(${index})">

                        −

                    </button>


                    <span>
                        ${quantity}
                    </span>


                    <button
                        type="button"
                        onclick="increaseQuantity(${index})">

                        +

                    </button>

                </div>


                <div class="item-subtotal">

                    ${formatPrice(itemSubtotal)}

                </div>

            `;


            cartItems.appendChild(
                cartItem
            );

        }
    );


    /* ================= TOTAL ================= */

    cartSubtotal.innerText =
        formatPrice(subtotal);


    /*
        Current Cart design eke
        shipping FREE.
    */

    const shipping = 0;


    shippingCost.innerText =
        "Free";


    cartTotal.innerText =
        formatPrice(
            subtotal + shipping
        );


    updateCartCount();

}


/* ================= INCREASE QUANTITY ================= */

function increaseQuantity(index) {

    const cart =
        getCart();


    if (!cart[index]) {
        return;
    }


    cart[index].quantity =
        Number(
            cart[index].quantity || 1
        ) + 1;


    saveCart(cart);

    displayCart();

}


/* ================= DECREASE QUANTITY ================= */

function decreaseQuantity(index) {

    const cart =
        getCart();


    if (!cart[index]) {
        return;
    }


    const quantity =
        Number(
            cart[index].quantity || 1
        );


    if (quantity > 1) {

        cart[index].quantity =
            quantity - 1;

    }

    else {

        cart.splice(
            index,
            1
        );

    }


    saveCart(cart);

    displayCart();

}


/* ================= REMOVE ITEM ================= */

function removeItem(index) {

    const cart =
        getCart();


    if (!cart[index]) {
        return;
    }


    const answer =
        confirm(
            "Remove this product from your cart?"
        );


    if (!answer) {
        return;
    }


    cart.splice(
        index,
        1
    );


    saveCart(cart);

    displayCart();

}


/* ================= CLEAR CART ================= */

function clearCart() {

    const cart =
        getCart();


    if (cart.length === 0) {

        alert(
            "Your cart is already empty."
        );

        return;

    }


    const answer =
        confirm(
            "Are you sure you want to clear your cart?"
        );


    if (!answer) {
        return;
    }


    localStorage.removeItem(
        CART_KEY
    );


    displayCart();

}


/* ================= CART COUNT ================= */

function updateCartCount() {

    const cart =
        getCart();


    let count = 0;


    cart.forEach(
        function(item) {

            count +=
                Number(
                    item.quantity || 0
                );

        }
    );


    const cartCount =
        document.getElementById(
            "cartCount"
        );


    if (cartCount) {

        cartCount.innerText =
            count;

    }

}


/* ==================================================
   AUTH HEADER
================================================== */

function updateAuthHeader() {

    const isLoggedIn =
        localStorage.getItem(
            "isLoggedIn"
        );


    const currentUser =
        localStorage.getItem(
            "currentUser"
        );


    const loginLink =
        document.getElementById(
            "loginLink"
        );


    const accountLink =
        document.getElementById(
            "accountLink"
        );


    const logoutLink =
        document.getElementById(
            "logoutLink"
        );


    if (
        isLoggedIn === "true" &&
        currentUser
    ) {

        if (loginLink) {

            loginLink.style.display =
                "none";

        }


        if (accountLink) {

            accountLink.style.display =
                "inline-block";

        }


        if (logoutLink) {

            logoutLink.style.display =
                "inline-block";

        }

    }

    else {

        if (loginLink) {

            loginLink.style.display =
                "inline-block";

        }


        if (accountLink) {

            accountLink.style.display =
                "none";

        }


        if (logoutLink) {

            logoutLink.style.display =
                "none";

        }

    }

}


/* ==================================================
   LOGOUT
================================================== */

function logoutUser() {

    const answer =
        confirm(
            "Are you sure you want to logout?"
        );


    if (!answer) {
        return;
    }


    /*
        Login information witharai
        remove karanne.

        Registered users saha
        shopping cart delete wenne naha.
    */

    localStorage.removeItem(
        "isLoggedIn"
    );


    localStorage.removeItem(
        "loggedInUser"
    );


    localStorage.removeItem(
        "currentUser"
    );


    localStorage.removeItem(
        "redirectAfterLogin"
    );


    window.location.href =
        "../../index.php";

}


/* ==================================================
   PROCEED TO CHECKOUT
================================================== */

function goToCheckout() {

    const cart =
        getCart();


    /*
        Cart empty nam checkout yanna ba.
    */

    if (cart.length === 0) {

        alert(
            "Your cart is empty. Please add a product first."
        );

        return;

    }


    const isLoggedIn =
        localStorage.getItem(
            "isLoggedIn"
        );


    const currentUser =
        localStorage.getItem(
            "currentUser"
        );


    /*
        LOGIN WELA NATHNAM

        Cart
          ↓
        Login
          ↓
        Checkout
    */

    if (
        isLoggedIn !== "true" ||
        currentUser === null
    ) {

        /*
            Login success unama
            yanna one page eka save karanawa.
        */

        localStorage.setItem(
            "redirectAfterLogin",
            "../checkout/checkout.php"
        );


        window.location.href =
            "../auth/login.php";


        return;

    }


    /*
        LOGIN WELA NAM

        Cart
          ↓
        Checkout direct
    */

    window.location.href =
        "../checkout/checkout.php";

}


/* ==================================================
   PAGE LOAD
================================================== */

document.addEventListener(
    "DOMContentLoaded",
    function() {


        /* CART */

        displayCart();

        updateCartCount();


        /* AUTH */

        updateAuthHeader();



        /* ================= CLEAR CART BUTTON ================= */

        const clearCartButton =
            document.getElementById(
                "clearCart"
            );


        if (clearCartButton) {

            clearCartButton.addEventListener(
                "click",
                function() {

                    clearCart();

                }
            );

        }



        /* ================= CHECKOUT BUTTON ================= */

        const checkoutButton =
            document.getElementById(
                "checkoutButton"
            );


        if (checkoutButton) {

            checkoutButton.addEventListener(
                "click",
                function() {

                    goToCheckout();

                }
            );

        }



        /* ================= LOGOUT BUTTON ================= */

        const logoutLink =
            document.getElementById(
                "logoutLink"
            );


        if (logoutLink) {

            logoutLink.addEventListener(
                "click",
                function() {

                    logoutUser();

                }
            );

        }

    }
);