document.addEventListener("DOMContentLoaded", function () {

    const cartKey = "ceylonTeaCart";


    // =========================================
    // GET CART
    // =========================================

    function getCheckoutCart() {

        try {

            return JSON.parse(
                localStorage.getItem(cartKey)
            ) || [];

        } catch (error) {

            return [];

        }

    }


    // =========================================
    // FORMAT PRICE
    // =========================================

    function formatPrice(value) {

        return "Rs. " + Number(value).toLocaleString(
            "en-LK",
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }
        );

    }


    // =========================================
    // CART COUNT
    // =========================================

    function updateCheckoutCartCount() {

        const cart = getCheckoutCart();

        const count = cart.reduce(
            function (total, item) {

                return total + Number(item.quantity || 1);

            },
            0
        );


        const cartCount =
            document.getElementById("cartCount");


        if (cartCount) {

            cartCount.textContent = count;

        }

    }


    // =========================================
    // DISPLAY CART
    // =========================================

    function displayCheckoutItems() {

        const cart = getCheckoutCart();

        const container =
            document.getElementById("checkoutItems");

        const emptyCheckout =
            document.getElementById("emptyCheckout");


        let subtotal = 0;


        if (!cart.length) {

            container.innerHTML = "";

            emptyCheckout.style.display = "block";

        } else {

            emptyCheckout.style.display = "none";


            container.innerHTML = cart.map(
                function (item) {

                    const quantity =
                        Number(item.quantity || 1);

                    const price =
                        Number(item.price || 0);

                    const total =
                        price * quantity;

                    subtotal += total;


                    return `
                        <div class="checkout-item">

                            <div class="checkout-item-image">

                                <img
                                    src="${item.image || ''}"
                                    alt="${escapeHtml(item.name || 'Tea Product')}"
                                    onerror="this.style.display='none';">

                            </div>


                            <div class="checkout-item-info">

                                <h4>
                                    ${escapeHtml(item.name || "Tea Product")}
                                </h4>

                                <p>
                                    ${formatPrice(price)}
                                </p>


                                <div class="item-bottom">

                                    <span>
                                        Qty: ${quantity}
                                    </span>

                                    <strong>
                                        ${formatPrice(total)}
                                    </strong>

                                </div>

                            </div>

                        </div>
                    `;

                }
            ).join("");

        }


        let shipping = 0;

        if (subtotal > 0 && subtotal < 5000) {

            shipping = 350;

        }


        const total = subtotal + shipping;


        document.getElementById(
            "checkoutSubtotal"
        ).textContent = formatPrice(subtotal);


        document.getElementById(
            "checkoutShipping"
        ).textContent = formatPrice(shipping);


        document.getElementById(
            "checkoutTotal"
        ).textContent = formatPrice(total);


        return total;

    }


    // =========================================
    // ESCAPE HTML
    // =========================================

    function escapeHtml(value) {

        return String(value)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");

    }


    // =========================================
    // PAYMENT METHODS
    // =========================================

    function setupPaymentMethods() {

        const options =
            document.querySelectorAll(
                ".payment-option"
            );


        const cardBox =
            document.getElementById(
                "cardPaymentBox"
            );


        options.forEach(function (option) {

            option.addEventListener(
                "click",
                function () {

                    options.forEach(
                        function (item) {

                            item.classList.remove(
                                "active-payment"
                            );

                        }
                    );


                    option.classList.add(
                        "active-payment"
                    );


                    const radio =
                        option.querySelector(
                            'input[name="paymentMethod"]'
                        );


                    if (radio) {

                        radio.checked = true;

                    }


                    if (
                        radio &&
                        radio.value === "card"
                    ) {

                        cardBox.style.display = "block";

                    } else {

                        cardBox.style.display = "none";

                    }

                }
            );

        });

    }


    // =========================================
    // VALIDATE CHECKOUT
    // =========================================

    function validateCheckout() {

        const firstName =
            document.getElementById("firstName").value.trim();

        const lastName =
            document.getElementById("lastName").value.trim();

        const email =
            document.getElementById("email").value.trim();

        const phone =
            document.getElementById("phone").value.trim();

        const address =
            document.getElementById("address").value.trim();

        const city =
            document.getElementById("city").value.trim();

        const district =
            document.getElementById("district").value.trim();


        if (!firstName) {

            alert("Please enter your first name.");

            return false;

        }


        if (!lastName) {

            alert("Please enter your last name.");

            return false;

        }


        if (!email || !email.includes("@")) {

            alert("Please enter a valid email address.");

            return false;

        }


        if (!phone) {

            alert("Please enter your phone number.");

            return false;

        }


        if (!address) {

            alert("Please enter your delivery address.");

            return false;

        }


        if (!city) {

            alert("Please enter your city.");

            return false;

        }


        if (!district) {

            alert("Please enter your district.");

            return false;

        }


        const cart = getCheckoutCart();


        if (!cart.length) {

            alert("Your cart is empty.");

            return false;

        }


        return true;

    }


    // =========================================
    // CREATE ORDER ID
    // =========================================

    function createOrderId() {

        return "CTH-" +
            Date.now();

    }


    // =========================================
    // START PAYHERE
    // =========================================

    async function startPayHerePayment() {

        const total = displayCheckoutItems();


        if (total <= 0) {

            alert("Your cart is empty.");

            return;

        }


        const firstName =
            document.getElementById("firstName").value.trim();

        const lastName =
            document.getElementById("lastName").value.trim();

        const email =
            document.getElementById("email").value.trim();

        const phone =
            document.getElementById("phone").value.trim();

        const address =
            document.getElementById("address").value.trim();

        const city =
            document.getElementById("city").value.trim();

        const district =
            document.getElementById("district").value.trim();

        const notes =
            document.getElementById("notes").value.trim();


        const orderId = createOrderId();


        const amount =
            Number(total).toFixed(2);


        const cart = getCheckoutCart();


        const itemNames = cart
            .map(function (item) {

                return item.name;

            })
            .join(", ");


        try {

            // =================================
            // GET HASH FROM PHP
            // =================================

            const response = await fetch(
                "../../../backend/api/payhere-hash.php",
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json"
                    },

                    body: JSON.stringify({

                        order_id: orderId,

                        amount: amount,

                        currency: "LKR"

                    })

                }
            );


            const data = await response.json();


            if (!data.success) {

                throw new Error(
                    data.message ||
                    "Unable to create payment."
                );

            }


            // =================================
            // PAYHERE CALLBACK
            // =================================

            payhere.onCompleted =
                function (completedOrderId) {

                    console.log(
                        "Payment completed:",
                        completedOrderId
                    );


                    localStorage.removeItem(
                        cartKey
                    );


                    showSuccess();

                };


            payhere.onDismissed =
                function () {

                    console.log(
                        "PayHere payment dismissed."
                    );

                };


            payhere.onError =
                function (error) {

                    console.error(
                        "PayHere Error:",
                        error
                    );


                    alert(
                        "Payment failed. Please try again."
                    );

                };


            // =================================
            // PAYHERE PAYMENT OBJECT
            // =================================

            const payment = {

                sandbox: true,

                merchant_id:
                    data.merchant_id,

                return_url:
                    undefined,

                cancel_url:
                    undefined,

                notify_url:
                    data.notify_url,

                order_id:
                    orderId,

                items:
                    itemNames || "Ceylon Tea House Order",

                amount:
                    amount,

                currency:
                    "LKR",

                hash:
                    data.hash,


                first_name:
                    firstName,

                last_name:
                    lastName,

                email:
                    email,

                phone:
                    phone,

                address:
                    address,

                city:
                    city,

                country:
                    "Sri Lanka",


                delivery_address:
                    address,

                delivery_city:
                    city,

                delivery_country:
                    "Sri Lanka",


                custom_1:
                    district,

                custom_2:
                    notes

            };


            console.log(
                "Starting PayHere Sandbox..."
            );


            payhere.startPayment(payment);

        } catch (error) {

            console.error(error);

            alert(
                "Unable to start PayHere payment.\n\n" +
                error.message
            );

        }

    }


    // =========================================
    // CASH ON DELIVERY
    // =========================================

    function completeCashOrder() {

        localStorage.removeItem(
            cartKey
        );


        showSuccess();

    }


    // =========================================
    // SHOW SUCCESS
    // =========================================

    function showSuccess() {

        const overlay =
            document.getElementById(
                "successOverlay"
            );


        if (overlay) {

            overlay.classList.add("show");

        }

    }


    // =========================================
    // PLACE ORDER
    // =========================================

    async function placeOrder() {

        if (!validateCheckout()) {

            return;

        }


        const paymentMethod =
            document.querySelector(
                'input[name="paymentMethod"]:checked'
            );


        if (!paymentMethod) {

            alert(
                "Please select a payment method."
            );

            return;

        }


        const button =
            document.getElementById(
                "placeOrderButton"
            );


        button.disabled = true;


        if (paymentMethod.value === "cash") {

            completeCashOrder();

            button.disabled = false;

            return;

        }


        if (paymentMethod.value === "card") {

            try {

                await startPayHerePayment();

            } catch (error) {

                console.error(error);

            }

            button.disabled = false;

        }

    }


    // =========================================
    // CONTINUE SHOPPING
    // =========================================

    const continueButton =
        document.getElementById(
            "continueShoppingButton"
        );


    if (continueButton) {

        continueButton.addEventListener(
            "click",
            function () {

                window.location.href =
                    "../../shop.php";

            }
        );

    }


    // =========================================
    // PLACE ORDER BUTTON
    // =========================================

    const placeOrderButton =
        document.getElementById(
            "placeOrderButton"
        );


    if (placeOrderButton) {

        placeOrderButton.addEventListener(
            "click",
            placeOrder
        );

    }


    // =========================================
    // INITIALIZE
    // =========================================

    updateCheckoutCartCount();

    displayCheckoutItems();

    setupPaymentMethods();

});