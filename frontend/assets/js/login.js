/* ==================================================
   CEYLON TEA HOUSE - LOGIN
================================================== */

document.addEventListener(
    "DOMContentLoaded",
    function () {


        const CART_KEY =
            "ceylonTeaCart";


        /* ================= CART COUNT ================= */

        function updateCartCount() {

            const cart =
                JSON.parse(
                    localStorage.getItem(
                        CART_KEY
                    )
                ) || [];


            let count = 0;


            cart.forEach(
                function (item) {

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


        updateCartCount();



        /* ================= ELEMENTS ================= */

        const loginForm =
            document.getElementById(
                "loginForm"
            );


        const email =
            document.getElementById(
                "email"
            );


        const password =
            document.getElementById(
                "password"
            );


        const togglePassword =
            document.getElementById(
                "togglePassword"
            );


        const loginMessage =
            document.getElementById(
                "loginMessage"
            );



        /* ================= PASSWORD SHOW / HIDE ================= */

        if (
            togglePassword &&
            password
        ) {

            togglePassword.addEventListener(
                "click",
                function () {


                    if (
                        password.type ===
                        "password"
                    ) {

                        password.type =
                            "text";

                        togglePassword.innerText =
                            "🙈";

                    }

                    else {

                        password.type =
                            "password";

                        togglePassword.innerText =
                            "👁";

                    }

                }
            );

        }



        /* ================= MESSAGE ================= */

        function showMessage(
            text,
            type
        ) {

            if (!loginMessage) {
                return;
            }


            loginMessage.innerText =
                text;


            loginMessage.className =
                "login-message " +
                type;

        }



        /* ================= LOGIN ================= */

        if (loginForm) {

            loginForm.addEventListener(
                "submit",
                function (event) {


                    event.preventDefault();


                    const emailValue =
                        email.value
                            .trim()
                            .toLowerCase();


                    const passwordValue =
                        password.value;



                    /* ================= VALIDATION ================= */

                    if (
                        emailValue === "" ||
                        passwordValue === ""
                    ) {

                        showMessage(
                            "Please enter your email and password.",
                            "error"
                        );

                        return;

                    }



                    /* ================= GET REGISTERED USERS ================= */

                    const users =
                        JSON.parse(
                            localStorage.getItem(
                                "ceylonTeaUsers"
                            )
                        ) || [];



                    /* ================= FIND USER ================= */

                    const user =
                        users.find(
                            function (item) {

                                return (
                                    item.email
                                        .toLowerCase() ===
                                        emailValue &&

                                    item.password ===
                                        passwordValue
                                );

                            }
                        );



                    /* ================= INVALID LOGIN ================= */

                    if (!user) {

                        showMessage(
                            "Invalid email or password.",
                            "error"
                        );

                        return;

                    }



                    /* ==================================================
                       LOGIN SUCCESS
                    ================================================== */

                    localStorage.setItem(
                        "isLoggedIn",
                        "true"
                    );


                    localStorage.setItem(
                        "loggedInUser",
                        user.email
                    );


                    localStorage.setItem(
                        "currentUser",
                        JSON.stringify(
                            user
                        )
                    );


                    showMessage(
                        "Login successful!",
                        "success"
                    );



                    /* ==================================================
                       REDIRECT
                    ==================================================

                       CASE 1

                       Normal Login
                           ↓
                       Home


                       CASE 2

                       Cart
                           ↓
                       Proceed Checkout
                           ↓
                       Login
                           ↓
                       Checkout


                       CASE 3

                       Protected My Account
                           ↓
                       Login
                           ↓
                       My Account

                    ================================================== */


                    const redirect =
                        localStorage.getItem(
                            "redirectAfterLogin"
                        );


                    setTimeout(
                        function () {


                            if (redirect) {


                                /*
                                    Remove AFTER reading
                                    redirect destination.
                                */

                                localStorage.removeItem(
                                    "redirectAfterLogin"
                                );


                                window.location.href =
                                    redirect;

                            }

                            else {


                                /*
                                    Normal login
                                    goes HOME.
                                */

                                window.location.href =
                                    "../../index.php";

                            }

                        },
                        700
                    );

                }
            );

        }

    }
);