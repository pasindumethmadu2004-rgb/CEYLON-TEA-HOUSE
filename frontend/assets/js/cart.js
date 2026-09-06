// ================= GET CART =================

function getCart() {

    const cart = localStorage.getItem("ceylonTeaCart");

    if (cart) {
        return JSON.parse(cart);
    }

    return [];
}


// ================= SAVE CART =================

function saveCart(cart) {

    localStorage.setItem(
        "ceylonTeaCart",
        JSON.stringify(cart)
    );

}


// ================= FORMAT PRICE =================

function formatPrice(price) {

    return "Rs. " + Number(price).toLocaleString();

}


// ================= DISPLAY CART =================

function displayCart() {

    const cart = getCart();

    const cartItems = document.getElementById("cartItems");
    const emptyCart = document.getElementById("emptyCart");
    const cartSubtotal = document.getElementById("cartSubtotal");
    const cartTotal = document.getElementById("cartTotal");
    const cartCount = document.getElementById("cartCount");
    const checkoutButton = document.getElementById("checkoutButton");

    cartItems.innerHTML = "";

    let total = 0;
    let totalQuantity = 0;


    // ================= EMPTY CART =================

    if (cart.length === 0) {

        emptyCart.style.display = "block";

        cartSubtotal.innerText = "Rs. 0";
        cartTotal.innerText = "Rs. 0";
        cartCount.innerText = "0";

        checkoutButton.disabled = true;

        return;

    }


    emptyCart.style.display = "none";
    checkoutButton.disabled = false;


    // ================= CREATE ITEMS =================

    cart.forEach(function (item, index) {

        const subtotal =
            Number(item.price) * Number(item.quantity);

        total += subtotal;

        totalQuantity += Number(item.quantity);


        const cartItem = document.createElement("div");

        cartItem.className = "cart-item";


        cartItem.innerHTML = `

            <div class="product-info">

                <img
                    src="${item.image}"
                    alt="${item.name}"
                >

                <div class="product-text">

                    <h3>${item.name}</h3>

                    <p>
                        Weight: ${item.weight || "250g"}
                    </p>

                    <button
                        type="button"
                        class="remove-btn"
                        onclick="removeItem(${index})"
                    >
                        Remove
                    </button>

                </div>

            </div>


            <div class="item-price">

                ${formatPrice(item.price)}

            </div>


            <div class="quantity-box">

                <button
                    type="button"
                    onclick="decreaseCartQuantity(${index})"
                >
                    −
                </button>

                <span>
                    ${item.quantity}
                </span>

                <button
                    type="button"
                    onclick="increaseCartQuantity(${index})"
                >
                    +
                </button>

            </div>


            <div class="item-subtotal">

                ${formatPrice(subtotal)}

            </div>

        `;


        cartItems.appendChild(cartItem);

    });


    // ================= UPDATE SUMMARY =================

    cartSubtotal.innerText = formatPrice(total);

    cartTotal.innerText = formatPrice(total);

    cartCount.innerText = totalQuantity;

}


// ================= INCREASE QUANTITY =================

function increaseCartQuantity(index) {

    const cart = getCart();

    cart[index].quantity++;

    saveCart(cart);

    displayCart();

}


// ================= DECREASE QUANTITY =================

function decreaseCartQuantity(index) {

    const cart = getCart();

    if (cart[index].quantity > 1) {

        cart[index].quantity--;

        saveCart(cart);

        displayCart();

    }

}


// ================= REMOVE PRODUCT =================

function removeItem(index) {

    const cart = getCart();

    cart.splice(index, 1);

    saveCart(cart);

    displayCart();

}


// ================= CLEAR CART =================

function clearCart() {

    const cart = getCart();

    if (cart.length === 0) {

        alert("Your cart is already empty.");

        return;

    }


    const answer = confirm(
        "Are you sure you want to clear your cart?"
    );


    if (answer) {

        localStorage.removeItem("ceylonTeaCart");

        displayCart();

    }

}


// ================= CHECKOUT =================

function goToCheckout() {

    const cart = getCart();


    if (cart.length === 0) {

        alert(
            "Your cart is empty. Please add a product first."
        );

        return;

    }


    /*
        Checkout Page eka haduwama
        me line eka use karamu:

        window.location.href =
        "../checkout/checkout.php";
    */


    alert(
        "Your cart is ready. Checkout Page will be connected next."
    );

}


// ================= BUTTON EVENTS =================

document.addEventListener(
    "DOMContentLoaded",
    function () {

        displayCart();


        const clearCartButton =
            document.getElementById("clearCart");


        const checkoutButton =
            document.getElementById("checkoutButton");


        clearCartButton.addEventListener(
            "click",
            clearCart
        );


        checkoutButton.addEventListener(
            "click",
            goToCheckout
        );

    }
);