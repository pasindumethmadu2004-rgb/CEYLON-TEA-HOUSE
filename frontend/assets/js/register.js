document.addEventListener(
    "DOMContentLoaded",
    function() {

        // ===============================
        // CART COUNT
        // ===============================

        function updateCartCount() {

            const cart =
                JSON.parse(
                    localStorage.getItem(
                        "ceylonTeaCart"
                    )
                ) || [];

            let count = 0;

            cart.forEach(function(item) {
                count += Number(item.quantity);
            });

            const cartCount =
                document.getElementById(
                    "cartCount"
                );

            if (cartCount) {
                cartCount.innerText = count;
            }
        }

        updateCartCount();


        // ===============================
        // ELEMENTS
        // ===============================

        const registerForm =
            document.getElementById(
                "registerForm"
            );

        const firstName =
            document.getElementById(
                "firstName"
            );

        const lastName =
            document.getElementById(
                "lastName"
            );

        const email =
            document.getElementById(
                "registerEmail"
            );

        const phone =
            document.getElementById(
                "phone"
            );

        const password =
            document.getElementById(
                "registerPassword"
            );

        const confirmPassword =
            document.getElementById(
                "confirmPassword"
            );

        const terms =
            document.getElementById(
                "terms"
            );

        const message =
            document.getElementById(
                "registerMessage"
            );


        // ===============================
        // PASSWORD SHOW / HIDE
        // ===============================

        const togglePassword =
            document.getElementById(
                "togglePassword"
            );

        const toggleConfirmPassword =
            document.getElementById(
                "toggleConfirmPassword"
            );

        if (togglePassword) {

            togglePassword.addEventListener(
                "click",
                function() {

                    if (password.type === "password") {
                        password.type = "text";
                        togglePassword.innerText = "Hide";
                    } else {
                        password.type = "password";
                        togglePassword.innerText = "Show";
                    }
                }
            );
        }


        if (toggleConfirmPassword) {

            toggleConfirmPassword.addEventListener(
                "click",
                function() {

                    if (
                        confirmPassword.type ===
                        "password"
                    ) {
                        confirmPassword.type =
                            "text";

                        toggleConfirmPassword.innerText =
                            "Hide";

                    } else {

                        confirmPassword.type =
                            "password";

                        toggleConfirmPassword.innerText =
                            "Show";
                    }
                }
            );
        }


        // ===============================
        // REGISTER
        // ===============================

        if (registerForm) {

            registerForm.addEventListener(
                "submit",
                function(event) {

                    event.preventDefault();

                    const firstNameValue =
                        firstName.value.trim();

                    const lastNameValue =
                        lastName.value.trim();

                    const emailValue =
                        email.value
                            .trim()
                            .toLowerCase();

                    const phoneValue =
                        phone.value.trim();

                    const passwordValue =
                        password.value;

                    const confirmPasswordValue =
                        confirmPassword.value;


                    // Empty fields
                    if (
                        firstNameValue === "" ||
                        lastNameValue === "" ||
                        emailValue === "" ||
                        phoneValue === "" ||
                        passwordValue === "" ||
                        confirmPasswordValue === ""
                    ) {

                        showMessage(
                            "Please fill in all fields.",
                            "error"
                        );

                        return;
                    }


                    // Email check
                    if (
                        !emailValue.includes("@")
                    ) {

                        showMessage(
                            "Please enter a valid email address.",
                            "error"
                        );

                        return;
                    }


                    // Password length
                    if (
                        passwordValue.length < 6
                    ) {

                        showMessage(
                            "Password must contain at least 6 characters.",
                            "error"
                        );

                        return;
                    }


                    // Password confirmation
                    if (
                        passwordValue !==
                        confirmPasswordValue
                    ) {

                        showMessage(
                            "Passwords do not match.",
                            "error"
                        );

                        return;
                    }


                    // Terms
                    if (
                        !terms.checked
                    ) {

                        showMessage(
                            "Please accept the Terms & Conditions.",
                            "error"
                        );

                        return;
                    }


                    // Existing users
                    let users =
                        JSON.parse(
                            localStorage.getItem(
                                "ceylonTeaUsers"
                            )
                        ) || [];


                    // Duplicate email check
                    const existingUser =
                        users.find(
                            function(user) {

                                return (
                                    user.email.toLowerCase()
                                    === emailValue
                                );
                            }
                        );


                    if (existingUser) {

                        showMessage(
                            "An account with this email already exists.",
                            "error"
                        );

                        return;
                    }


                    // New user
                    const newUser = {

                        firstName:
                            firstNameValue,

                        lastName:
                            lastNameValue,

                        email:
                            emailValue,

                        phone:
                            phoneValue,

                        password:
                            passwordValue,

                        role:
                            "user"
                    };


                    users.push(newUser);


                    // Save users
                    localStorage.setItem(
                        "ceylonTeaUsers",
                        JSON.stringify(users)
                    );


                    showMessage(
                        "Account created successfully! Redirecting to login...",
                        "success"
                    );


                    // Register una passe LOGIN
                    setTimeout(
                        function() {

                            window.location.href =
                                "login.php";

                        },
                        1000
                    );
                }
            );
        }


        // ===============================
        // MESSAGE
        // ===============================

        function showMessage(
            text,
            type
        ) {

            if (!message) {
                return;
            }

            message.innerText = text;

            message.className =
                "form-message " + type;
        }

    }
);