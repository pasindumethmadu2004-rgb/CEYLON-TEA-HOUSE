/* ================= GET CART ================= */

function getCheckoutCart() {

    return JSON.parse(
        localStorage.getItem(
            "ceylonTeaCart"
        )
    ) || [];

}



/* ================= FORMAT PRICE ================= */

function formatCheckoutPrice(price) {

    return "Rs. " +
        Number(price).toLocaleString();

}



/* ================= CART COUNT ================= */

function updateCheckoutCartCount() {

    const cart =
        getCheckoutCart();


    let count = 0;


    cart.forEach(function (item) {

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



/* ================= DISPLAY ORDER SUMMARY ================= */

function displayCheckoutItems() {

    const cart =
        getCheckoutCart();


    const checkoutItems =
        document.getElementById(
            "checkoutItems"
        );


    const emptyCheckout =
        document.getElementById(
            "emptyCheckout"
        );


    const placeOrderButton =
        document.getElementById(
            "placeOrderButton"
        );


    checkoutItems.innerHTML = "";


    let subtotal = 0;


    if (cart.length === 0) {

        emptyCheckout.style.display =
            "block";

        placeOrderButton.disabled =
            true;

    }

    else {

        emptyCheckout.style.display =
            "none";

        placeOrderButton.disabled =
            false;


        cart.forEach(function (item) {

            const itemTotal =
                Number(item.price) *
                Number(item.quantity);


            subtotal += itemTotal;


            const itemBox =
                document.createElement(
                    "div"
                );


            itemBox.className =
                "checkout-item";


            itemBox.innerHTML = `

                <div class="checkout-item-image">

                    <img
                        src="${item.image}"
                        alt="${item.name}">

                </div>


                <div class="checkout-item-info">

                    <h4>
                        ${item.name}
                    </h4>

                    <p>
                        ${item.weight}
                    </p>


                    <div class="item-bottom">

                        <span>
                            Qty: ${item.quantity}
                        </span>

                        <strong>
                            ${formatCheckoutPrice(itemTotal)}
                        </strong>

                    </div>

                </div>

            `;


            checkoutItems.appendChild(
                itemBox
            );

        });

    }


    /*
        Current temporary shipping rule:
        Orders Rs. 5000 or more = free delivery.
        Otherwise Rs. 350.
    */

    let shipping = 0;


    if (subtotal > 0 && subtotal < 5000) {

        shipping = 350;

    }


    const total =
        subtotal + shipping;


    document.getElementById(
        "checkoutSubtotal"
    ).innerText =
        formatCheckoutPrice(
            subtotal
        );


    document.getElementById(
        "checkoutShipping"
    ).innerText =
        shipping === 0 && subtotal > 0
            ? "FREE"
            : formatCheckoutPrice(
                shipping
            );


    document.getElementById(
        "checkoutTotal"
    ).innerText =
        formatCheckoutPrice(
            total
        );

}



/* ================= PAYMENT METHOD ================= */

function setupPaymentMethods() {

    const options =
        document.querySelectorAll(
            ".payment-option"
        );


    const paymentInputs =
        document.querySelectorAll(
            'input[name="payment"]'
        );


    const cardPaymentBox =
        document.getElementById(
            "cardPaymentBox"
        );


    paymentInputs.forEach(
        function (input) {

            input.addEventListener(
                "change",
                function () {

                    options.forEach(
                        function (option) {

                            option.classList.remove(
                                "active-payment"
                            );

                        }
                    );


                    this.closest(
                        ".payment-option"
                    ).classList.add(
                        "active-payment"
                    );


                    if (
                        this.value === "card"
                    ) {

                        cardPaymentBox.style.display =
                            "block";

                    }

                    else {

                        cardPaymentBox.style.display =
                            "none";

                    }

                }
            );

        }
    );

}



/* ================= CARD NUMBER FORMAT ================= */

function setupCardFormatting() {

    const cardNumber =
        document.getElementById(
            "cardNumber"
        );


    const expiry =
        document.getElementById(
            "expiry"
        );


    cardNumber.addEventListener(
        "input",
        function () {

            let value =
                this.value
                    .replace(/\D/g, "")
                    .slice(0, 16);


            value =
                value.replace(
                    /(.{4})/g,
                    "$1 "
                ).trim();


            this.value =
                value;

        }
    );


    expiry.addEventListener(
        "input",
        function () {

            let value =
                this.value
                    .replace(/\D/g, "")
                    .slice(0, 4);


            if (value.length >= 3) {

                value =
                    value.slice(0, 2) +
                    "/" +
                    value.slice(2);

            }


            this.value =
                value;

        }
    );

}



/* ================= VALIDATE CHECKOUT ================= */

function validateCheckout() {

    const requiredFields = [

        "firstName",
        "lastName",
        "email",
        "phone",
        "address",
        "city",
        "district"

    ];


    for (
        let i = 0;
        i < requiredFields.length;
        i++
    ) {

        const field =
            document.getElementById(
                requiredFields[i]
            );


        if (
            field.value.trim() === ""
        ) {

            alert(
                "Please complete all required customer and delivery details."
            );


            field.focus();


            return false;

        }

    }


    const email =
        document.getElementById(
            "email"
        ).value;


    if (
        !email.includes("@")
    ) {

        alert(
            "Please enter a valid email address."
        );

        return false;

    }


    const selectedPayment =
        document.querySelector(
            'input[name="payment"]:checked'
        );


    if (
        selectedPayment.value === "card"
    ) {

        const cardNumber =
            document.getElementById(
                "cardNumber"
            ).value;


        const expiry =
            document.getElementById(
                "expiry"
            ).value;


        const cvv =
            document.getElementById(
                "cvv"
            ).value;


        if (
            cardNumber.length < 19 ||
            expiry.length < 5 ||
            cvv.length < 3
        ) {

            alert(
                "Please complete your card details."
            );

            return false;

        }

    }


    return true;

}



/* ================= PLACE ORDER ================= */

function placeOrder() {

    const cart =
        getCheckoutCart();


    if (
        cart.length === 0
    ) {

        alert(
            "Your cart is empty."
        );

        return;

    }


    if (
        !validateCheckout()
    ) {

        return;

    }


    /*
        Backend/MySQL ekata orders save karaddi
        me section eka later update karamu.

        Dan temporary frontend order success.
    */


    localStorage.removeItem(
        "ceylonTeaCart"
    );


    updateCheckoutCartCount();


    const successOverlay =
        document.getElementById(
            "successOverlay"
        );


    successOverlay.classList.add(
        "show"
    );

}



/* ================= PAGE LOAD ================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        updateCheckoutCartCount();

        displayCheckoutItems();

        setupPaymentMethods();

        setupCardFormatting();


        document.getElementById(
            "placeOrderButton"
        ).addEventListener(
            "click",
            placeOrder
        );


        document.getElementById(
            "continueShoppingButton"
        ).addEventListener(
            "click",
            function () {

                window.location.href =
                    "../../shop.php";

            }
        );

    }
);