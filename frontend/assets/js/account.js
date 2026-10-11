
document.addEventListener("DOMContentLoaded", async function () {
    const ACCOUNT_API =
        "/CEYLON-TEA-HOUSE/backend/api/account.php";

    const LOGIN_URL =
        "/CEYLON-TEA-HOUSE/frontend/modules/auth/login.php";

    const HOME_URL =
        "/CEYLON-TEA-HOUSE/frontend/index.php";

    const CART_KEY = "ceylonTeaCart";

    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const email = document.getElementById("profileEmail");
    const phone = document.getElementById("phone");
    const profileForm = document.getElementById("profileForm");
    const profileMessage = document.getElementById("profileMessage");
    const editButton = document.getElementById("editProfileButton");
    const saveButton = document.getElementById("saveProfileButton");
    const sidebarName = document.getElementById("sidebarName");
    const sidebarEmail = document.getElementById("sidebarEmail");
    const avatar = document.getElementById("profileAvatar");
    const logoutButton = document.getElementById("logoutButton");
    const logoutOverlay = document.getElementById("logoutOverlay");
    const cancelLogout = document.getElementById("cancelLogout");
    const confirmLogout = document.getElementById("confirmLogout");

    let editing = false;
    let originalProfile = {};

    function showMessage(text, type = "error") {
        if (!profileMessage) return;
        profileMessage.textContent = text;
        profileMessage.className = "profile-message " + type;
    }

    function clearMessage() {
        showMessage("", "");
    }

    function setEditMode(enabled) {
        editing = enabled;

        [firstName, lastName, email, phone].forEach(function (field) {
            if (field) field.disabled = !enabled;
        });

        if (saveButton) saveButton.disabled = !enabled;
        if (editButton) {
            editButton.textContent = enabled ? "CANCEL EDIT" : "EDIT PROFILE";
        }
    }

    function updateSummary(name, emailValue) {
        const fullName = (name || "Customer").trim();

        if (sidebarName) sidebarName.textContent = fullName;
        if (sidebarEmail) sidebarEmail.textContent = emailValue || "";
        if (avatar) avatar.textContent = fullName.charAt(0).toUpperCase();
    }

    function updateCartCount() {
        let cart = [];

        try {
            cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
        } catch (error) {
            cart = [];
        }

        const count = cart.reduce(function (total, item) {
            return total + Math.max(0, Number(item.quantity) || 0);
        }, 0);

        const cartCount = document.getElementById("cartCount");
        if (cartCount) cartCount.textContent = count;
    }

    async function apiRequest(url, options = {}) {
        const response = await fetch(url, {
            credentials: "same-origin",
            ...options,
            headers: {
                "Content-Type": "application/json",
                ...(options.headers || {})
            }
        });

        const result = await response.json();

        if (response.status === 401) {
            localStorage.setItem(
                "redirectAfterLogin",
                window.location.pathname
            );
            window.location.replace(LOGIN_URL);
            throw new Error("Please log in again.");
        }

        if (!response.ok || result.success === false) {
            throw new Error(result.message || "Request failed.");
        }

        return result;
    }

    // Check the real PHP login session.
    try {
        const result = await apiRequest(ACCOUNT_API);

        const user = result.user;

        if (!user) {
            throw new Error("Account details were not returned.");
        }

        const fullName = user.full_name || user.name || "";
        const nameParts = fullName.trim().split(/\s+/);

        originalProfile = {
            firstName: user.first_name || nameParts[0] || "",
            lastName: user.last_name || nameParts.slice(1).join(" "),
            email: user.email || "",
            phone: user.phone || ""
        };

        firstName.value = originalProfile.firstName;
        lastName.value = originalProfile.lastName;
        email.value = originalProfile.email;
        phone.value = originalProfile.phone;

        updateSummary(fullName, originalProfile.email);
        setEditMode(false);
        updateCartCount();

    } catch (error) {
        console.error("Account loading error:", error);

        if (error.message !== "Please log in again.") {
            showMessage(
                "Could not load account details. Please check the account API.",
                "error"
            );
        }

        return;
    }

    if (editButton) {
        editButton.addEventListener("click", function () {
            if (editing) {
                firstName.value = originalProfile.firstName;
                lastName.value = originalProfile.lastName;
                email.value = originalProfile.email;
                phone.value = originalProfile.phone;

                setEditMode(false);
                clearMessage();
            } else {
                setEditMode(true);
                clearMessage();
                firstName.focus();
            }
        });
    }

    if (profileForm) {
        profileForm.addEventListener("submit", async function (event) {
            event.preventDefault();
            if (!editing) return;

            const updatedUser = {
                first_name: firstName.value.trim(),
                last_name: lastName.value.trim(),
                email: email.value.trim().toLowerCase(),
                phone: phone.value.trim()
            };

            if (
                !updatedUser.first_name ||
                !updatedUser.last_name ||
                !updatedUser.email ||
                !updatedUser.phone
            ) {
                showMessage("Please fill in all fields.");
                return;
            }

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(updatedUser.email)) {
                showMessage("Please enter a valid email address.");
                return;
            }

            try {
                const result = await apiRequest(ACCOUNT_API, {
                    method: "POST",
                    body: JSON.stringify(updatedUser)
                });

                const user = result.user || {};
                const fullName =
                    user.full_name ||
                    (updatedUser.first_name + " " + updatedUser.last_name);

                originalProfile = {
                    firstName: updatedUser.first_name,
                    lastName: updatedUser.last_name,
                    email: updatedUser.email,
                    phone: updatedUser.phone
                };

                updateSummary(fullName, updatedUser.email);
                setEditMode(false);
                showMessage("Profile updated successfully!", "success");

            } catch (error) {
                showMessage(error.message || "Could not update your profile.");
            }
        });
    }

    if (logoutButton && logoutOverlay) {
        logoutButton.addEventListener("click", function () {
            logoutOverlay.classList.add("show");
        });
    }

    if (cancelLogout && logoutOverlay) {
        cancelLogout.addEventListener("click", function () {
            logoutOverlay.classList.remove("show");
        });
    }

    if (logoutOverlay) {
        logoutOverlay.addEventListener("click", function (event) {
            if (event.target === logoutOverlay) {
                logoutOverlay.classList.remove("show");
            }
        });
    }

    if (confirmLogout && logoutOverlay) {
        confirmLogout.addEventListener("click", async function () {
            confirmLogout.disabled = true;

            try {
                const response = await fetch(
                    "/CEYLON-TEA-HOUSE/backend/api/logout.php",
                    {
                        method: "POST",
                        credentials: "same-origin"
                    }
                );

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || "Logout failed.");
                }

                localStorage.removeItem("isLoggedIn");
                localStorage.removeItem("loggedInUser");
                localStorage.removeItem("currentUser");
                localStorage.removeItem("redirectAfterLogin");

                window.location.href = HOME_URL;

            } catch (error) {
                showMessage(error.message || "Logout failed.");
                confirmLogout.disabled = false;
            }
        });
    }
});
