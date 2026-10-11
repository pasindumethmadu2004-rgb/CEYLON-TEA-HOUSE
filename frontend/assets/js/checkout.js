document.addEventListener("DOMContentLoaded", () => {
    const CART_KEY = "ceylonTeaCart";
    const API_BASE = "../../../backend/api/";

    const cartItemsContainer = document.getElementById("checkoutItems");
    const emptyCheckout = document.getElementById("emptyCheckout");
    const subtotalElement = document.getElementById("checkoutSubtotal");
    const shippingElement = document.getElementById("checkoutShipping");
    const totalElement = document.getElementById("checkoutTotal");
    const placeOrderButton = document.getElementById("placeOrderButton");
    const successOverlay = document.getElementById("successOverlay");
    const continueShoppingButton = document.getElementById(
        "continueShoppingButton"
    );

    let isSubmitting = false;

    // -----------------------------
    // CART
    // -----------------------------
    function getCart() {
        try {
            const cart = JSON.parse(
                localStorage.getItem(CART_KEY) || "[]"
            );

            return Array.isArray(cart) ? cart : [];
        } catch (error) {
            console.error("Could not read cart:", error);
            return [];
        }
    }

    function getPrice(item) {
        return Number(item.price ?? item.unit_price ?? 0) || 0;
    }

    function getQuantity(item) {
        return Math.max(1, Number(item.quantity ?? 1) || 1);
    }

    function calculateTotals(cart) {
        const subtotal = cart.reduce(
            (sum, item) =>
                sum + getPrice(item) * getQuantity(item),
            0
        );

        const shipping =
            subtotal > 0 && subtotal < 5000 ? 350 : 0;

        return {
            subtotal,
            shipping,
            total: subtotal + shipping
        };
    }

    function money(amount) {
        return "Rs. " + Number(amount).toLocaleString("en-LK", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function renderCart() {
        const cart = getCart();
        const totals = calculateTotals(cart);

        if (emptyCheckout) {
            emptyCheckout.style.display =
                cart.length ? "none" : "";
        }

        if (cartItemsContainer) {
            cartItemsContainer.replaceChildren();

            cart.forEach(item => {
                const row = document.createElement("div");
                row.className = "checkout-item";

                const name = document.createElement("span");
                name.textContent =
                    item.name || item.product_name || "Tea product";

                const qty = document.createElement("span");
                qty.textContent = ` × ${getQuantity(item)} `;

                const price = document.createElement("span");
                price.textContent = money(
                    getPrice(item) * getQuantity(item)
                );

                row.append(name, qty, price);
                cartItemsContainer.appendChild(row);
            });
        }

        if (subtotalElement) {
            subtotalElement.textContent = money(totals.subtotal);
        }

        if (shippingElement) {
            shippingElement.textContent = money(totals.shipping);
        }

        if (totalElement) {
            totalElement.textContent = money(totals.total);
        }

        if (placeOrderButton) {
            placeOrderButton.disabled =
                cart.length === 0 || isSubmitting;
        }

        return { cart, ...totals };
    }

    // -----------------------------
    // FORM DETAILS
    // -----------------------------
    function getValue(id) {
        return document.getElementById(id)?.value.trim() || "";
    }

    function getCheckoutDetails() {
        return {
            first_name: getValue("firstName"),
            last_name: getValue("lastName"),
            email: getValue("email"),
            phone: getValue("phone"),
            address: getValue("address"),
            city: getValue("city"),
            district: getValue("district"),
            notes: getValue("notes")
        };
    }

    function validateDetails(details) {
        const fields = [
            ["firstName", details.first_name],
            ["lastName", details.last_name],
            ["email", details.email],
            ["phone", details.phone],
            ["address", details.address],
            ["city", details.city],
            ["district", details.district]
        ];

        for (const [id, value] of fields) {
            const input = document.getElementById(id);

            if (!value || (input && !input.checkValidity())) {
                input?.reportValidity();
                input?.focus();
                return false;
            }
        }

        return true;
    }

    // -----------------------------
    // API REQUEST
    // -----------------------------
    async function postJson(endpoint, data) {
        const response = await fetch(API_BASE + endpoint, {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        });

        const responseText = await response.text();

        let result;

        try {
            result = JSON.parse(responseText);
        } catch (error) {
            console.error(
                `Invalid response from ${endpoint}:`,
                responseText
            );

            throw new Error(
                `Invalid server response (HTTP ${response.status}).`
            );
        }

        if (!response.ok || result.success === false) {
            throw new Error(
                result.message ||
                `Request failed (HTTP ${response.status}).`
            );
        }

        return result;
    }

    // -----------------------------
    // CREATE DATABASE ORDER
    // -----------------------------
    async function createDatabaseOrder(paymentMethod, details, cart) {
        const items = cart.map(item => ({
            product_id: item.product_id ?? item.id ?? null,
            name: item.name ?? item.product_name ?? "",
            quantity: getQuantity(item)
        }));

        return postJson("create_order.php", {
            ...details,
            payment_method: paymentMethod,
            items
        });
    }

    // -----------------------------
    // SUCCESS MESSAGE
    // -----------------------------
    function showSuccess(message) {
        if (successOverlay) {
            successOverlay.style.display = "flex";
            successOverlay.classList.add("active");

            const messageElement =
                successOverlay.querySelector("[data-success-message]");

            if (messageElement) {
                messageElement.textContent = message;
            }
        } else {
            alert(message);
        }
    }

    // -----------------------------
    // FINISH COD ORDER
    // -----------------------------
    function finishCodOrder() {
        localStorage.removeItem(CART_KEY);

        isSubmitting = false;
        renderCart();

        if (placeOrderButton) {
            placeOrderButton.disabled = true;
        }

        showSuccess(
            "Your Cash on Delivery order has been placed successfully."
        );
    }

    // -----------------------------
    // RELEASE BUTTON
    // -----------------------------
    function releaseButton() {
        isSubmitting = false;

        if (placeOrderButton) {
            placeOrderButton.disabled = getCart().length === 0;
        }
    }

    // -----------------------------
    // PAYHERE CARD PAYMENT
    // -----------------------------
    async function startPayHerePayment(details, cart) {
        if (!window.payhere) {
            throw new Error(
                "PayHere SDK is not loaded. Please refresh the page and try again."
            );
        }

        // Create the database order.
        const order = await createDatabaseOrder(
            "card",
            details,
            cart
        );

        if (!order.order_id) {
            throw new Error("The server did not return the order ID.");
        }

        const orderId = Number(order.order_id);
        const amount = Number(order.total_amount).toFixed(2);

        // Get the PayHere secure hash from PHP.
        const hashData = await postJson("payhere-hash.php", {
            order_id: orderId,
            amount,
            currency: "LKR"
        });

        if (
            !hashData.merchant_id ||
            !hashData.hash ||
            !hashData.notify_url
        ) {
            throw new Error("PayHere configuration is incomplete.");
        }

        const payment = {
            sandbox: true,
            merchant_id: hashData.merchant_id,

            return_url: window.location.href,
            cancel_url: window.location.href,
            notify_url: hashData.notify_url,

            order_id: String(orderId),

            items: cart
                .map(item =>
                    item.name || item.product_name || "Tea product"
                )
                .join(", "),

            amount,
            currency: "LKR",
            hash: hashData.hash,

            first_name: details.first_name,
            last_name: details.last_name,
            email: details.email,
            phone: details.phone,

            address: details.address,
            city: details.city,
            country: "Sri Lanka",

            delivery_address: details.address,
            delivery_city: details.city,
            delivery_country: "Sri Lanka",

            custom_1: details.district,
            custom_2: details.notes
        };

        // -----------------------------
        // PAYMENT SUCCESS CALLBACK
        // -----------------------------
        window.payhere.onCompleted = function (completedOrderId) {
            console.log(
                "PayHere completed payment for order:",
                completedOrderId
            );

            /*
             * This callback indicates browser-side completion.
             * The verified server notification must still update
             * the database payment status.
             */

            if (String(completedOrderId) !== String(orderId)) {
                console.error("PayHere returned an unexpected order ID.");
                alert(
                    "The payment response could not be matched to your order. " +
                    "Please check your order status."
                );
                releaseButton();
                return;
            }

            localStorage.removeItem(CART_KEY);

            isSubmitting = false;
            renderCart();

            if (placeOrderButton) {
                placeOrderButton.disabled = true;
            }

            showSuccess(
                "Payment successful! Your order has been submitted."
            );

            setTimeout(() => {
                window.location.href = "../../index.php";
            }, 2500);
        };

        // -----------------------------
        // PAYMENT DISMISSED
        // -----------------------------
        window.payhere.onDismissed = function () {
            alert(
                "The payment window was closed. Your order may remain pending. " +
                "Please check your order status before trying again."
            );

            releaseButton();
        };

        // -----------------------------
        // PAYMENT ERROR
        // -----------------------------
        window.payhere.onError = function (error) {
            console.error("PayHere error:", error);

            alert(
                "PayHere could not complete the payment window. " +
                "Please check your existing order before trying again."
            );

            releaseButton();
        };

        // Open PayHere payment window.
        window.payhere.startPayment(payment);
    }

    // -----------------------------
    // PLACE ORDER
    // -----------------------------
    async function placeOrder() {
        if (isSubmitting) {
            return;
        }

        const { cart } = renderCart();

        if (!cart.length) {
            alert("Your cart is empty.");
            return;
        }

        const details = getCheckoutDetails();

        if (!validateDetails(details)) {
            return;
        }

        const selectedMethod =
            document.querySelector(
                'input[name="paymentMethod"]:checked'
            )?.value ||
            document.getElementById("paymentMethod")?.value ||
            "cash";

        const paymentMethod = selectedMethod.toLowerCase();

        if (!["cash", "card"].includes(paymentMethod)) {
            alert("Please select a valid payment method.");
            return;
        }

        isSubmitting = true;

        if (placeOrderButton) {
            placeOrderButton.disabled = true;
        }

        try {
            // PAYHERE CARD PAYMENT
            if (paymentMethod === "card") {
                await startPayHerePayment(details, cart);
                return;
            }

            // CASH ON DELIVERY
            const order = await createDatabaseOrder(
                "cash",
                details,
                cart
            );

            if (!order.order_id) {
                throw new Error(
                    order.message ||
                    "The server did not return the order ID."
                );
            }

            finishCodOrder();

        } catch (error) {
            console.error("Checkout error:", error);

            alert(
                error.message ||
                "Could not place your order."
            );

            releaseButton();
        }
    }

    // -----------------------------
    // EVENT LISTENERS
    // -----------------------------
    if (placeOrderButton) {
        placeOrderButton.addEventListener("click", event => {
            event.preventDefault();
            placeOrder();
        });
    }

    if (continueShoppingButton) {
        continueShoppingButton.addEventListener("click", () => {
            window.location.href = "../../index.php";
        });
    }

    // Display cart when checkout page opens.
    renderCart();
});