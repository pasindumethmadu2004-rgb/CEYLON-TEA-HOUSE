document.addEventListener(
    "DOMContentLoaded",
    function() {

        // ==========================================
        // LOGIN / PROTECTED ROUTE CHECK
        // ==========================================

        const isLoggedIn =
            localStorage.getItem(
                "isLoggedIn"
            );

        const currentUserData =
            localStorage.getItem(
                "currentUser"
            );


        /*
            Login wela nathnam
            account page eka balanna denne naha.
        */

        if (
            isLoggedIn !== "true" ||
            !currentUserData
        ) {

            localStorage.setItem(
                "redirectAfterLogin",
                "../account/account.php"
            );

            window.location.replace(
                "../auth/login.php"
            );

            return;
        }


        // ==========================================
        // CURRENT USER
        // ==========================================

        let currentUser;

        try {

            currentUser =
                JSON.parse(
                    currentUserData
                );

        } catch (error) {

            logoutUser();

            return;
        }


        // ==========================================
        // ELEMENTS
        // ==========================================

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
                "profileEmail"
            );

        const phone =
            document.getElementById(
                "phone"
            );

        const profileForm =
            document.getElementById(
                "profileForm"
            );

        const profileMessage =
            document.getElementById(
                "profileMessage"
            );

        const editProfileButton =
            document.getElementById(
                "editProfileButton"
            );

        const saveProfileButton =
            document.getElementById(
                "saveProfileButton"
            );

        const sidebarName =
            document.getElementById(
                "sidebarName"
            );

        const sidebarEmail =
            document.getElementById(
                "sidebarEmail"
            );

        const profileAvatar =
            document.getElementById(
                "profileAvatar"
            );

        const logoutButton =
            document.getElementById(
                "logoutButton"
            );

        const logoutOverlay =
            document.getElementById(
                "logoutOverlay"
            );

        const cancelLogout =
            document.getElementById(
                "cancelLogout"
            );

        const confirmLogout =
            document.getElementById(
                "confirmLogout"
            );


        // ==========================================
        // CART COUNT
        // ==========================================

        function updateCartCount() {

            const cart =
                JSON.parse(
                    localStorage.getItem(
                        "ceylonTeaCart"
                    )
                ) || [];


            let count = 0;


            cart.forEach(
                function(item) {

                    count +=
                        Number(
                            item.quantity
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


        // ==========================================
        // LOAD PROFILE
        // ==========================================

        function loadProfile() {

            firstName.value =
                currentUser.firstName || "";

            lastName.value =
                currentUser.lastName || "";

            email.value =
                currentUser.email || "";

            phone.value =
                currentUser.phone || "";


            updateProfileSummary();


            /*
                Page open unama
                fields edit karanna ba.

                EDIT PROFILE click karanna one.
            */

            setEditMode(false);
        }


        // ==========================================
        // PROFILE SUMMARY
        // ==========================================

        function updateProfileSummary() {

            const fullName =
                (
                    (currentUser.firstName || "") +
                    " " +
                    (currentUser.lastName || "")
                ).trim();


            if (sidebarName) {

                sidebarName.innerText =
                    fullName || "Customer";
            }


            if (sidebarEmail) {

                sidebarEmail.innerText =
                    currentUser.email || "";
            }


            if (profileAvatar) {

                let firstLetter = "U";


                if (
                    currentUser.firstName &&
                    currentUser.firstName.length > 0
                ) {

                    firstLetter =
                        currentUser.firstName
                            .charAt(0)
                            .toUpperCase();
                }


                profileAvatar.innerText =
                    firstLetter;
            }
        }


        // ==========================================
        // EDIT MODE
        // ==========================================

        function setEditMode(editing) {

            firstName.disabled =
                !editing;

            lastName.disabled =
                !editing;

            email.disabled =
                !editing;

            phone.disabled =
                !editing;


            if (saveProfileButton) {

                saveProfileButton.disabled =
                    !editing;
            }


            if (editProfileButton) {

                if (editing) {

                    editProfileButton.innerText =
                        "CANCEL EDIT";

                } else {

                    editProfileButton.innerText =
                        "EDIT PROFILE";
                }
            }
        }


        // ==========================================
        // EDIT BUTTON
        // ==========================================

        let editing = false;


        if (editProfileButton) {

            editProfileButton.addEventListener(
                "click",
                function() {

                    editing =
                        !editing;


                    if (editing) {

                        setEditMode(true);

                        clearMessage();

                        firstName.focus();

                    } else {

                        /*
                            Cancel kaloth
                            old values aye load wenawa.
                        */

                        loadProfile();

                        editing = false;

                        clearMessage();
                    }
                }
            );
        }


        // ==========================================
        // SAVE PROFILE
        // ==========================================

        if (profileForm) {

            profileForm.addEventListener(
                "submit",
                function(event) {

                    event.preventDefault();


                    if (!editing) {
                        return;
                    }


                    const newFirstName =
                        firstName.value.trim();

                    const newLastName =
                        lastName.value.trim();

                    const newEmail =
                        email.value
                            .trim()
                            .toLowerCase();

                    const newPhone =
                        phone.value.trim();


                    // ==================================
                    // EMPTY CHECK
                    // ==================================

                    if (
                        newFirstName === "" ||
                        newLastName === "" ||
                        newEmail === "" ||
                        newPhone === ""
                    ) {

                        showMessage(
                            "Please fill in all fields.",
                            "error"
                        );

                        return;
                    }


                    // ==================================
                    // EMAIL CHECK
                    // ==================================

                    if (
                        !newEmail.includes("@")
                    ) {

                        showMessage(
                            "Please enter a valid email address.",
                            "error"
                        );

                        return;
                    }


                    // ==================================
                    // GET ALL USERS
                    // ==================================

                    let users =
                        JSON.parse(
                            localStorage.getItem(
                                "ceylonTeaUsers"
                            )
                        ) || [];


                    /*
                        Original logged-in email.

                        Me email eken users array eke
                        correct user hoyanawa.
                    */

                    const oldEmail =
                        currentUser.email
                            .toLowerCase();


                    // ==================================
                    // DUPLICATE EMAIL CHECK
                    // ==================================

                    const duplicateEmail =
                        users.find(
                            function(user) {

                                return (
                                    user.email
                                        .toLowerCase()
                                    === newEmail
                                    &&
                                    user.email
                                        .toLowerCase()
                                    !== oldEmail
                                );
                            }
                        );


                    if (duplicateEmail) {

                        showMessage(
                            "Another account already uses this email.",
                            "error"
                        );

                        return;
                    }


                    // ==================================
                    // FIND USER
                    // ==================================

                    const userIndex =
                        users.findIndex(
                            function(user) {

                                return (
                                    user.email
                                        .toLowerCase()
                                    === oldEmail
                                );
                            }
                        );


                    if (userIndex === -1) {

                        showMessage(
                            "User account could not be found.",
                            "error"
                        );

                        return;
                    }


                    // ==================================
                    // UPDATE USER
                    // ==================================

                    users[userIndex].firstName =
                        newFirstName;

                    users[userIndex].lastName =
                        newLastName;

                    users[userIndex].email =
                        newEmail;

                    users[userIndex].phone =
                        newPhone;


                    // ==================================
                    // SAVE USERS
                    // ==================================

                    localStorage.setItem(
                        "ceylonTeaUsers",
                        JSON.stringify(users)
                    );


                    // ==================================
                    // UPDATE CURRENT USER
                    // ==================================

                    currentUser =
                        users[userIndex];


                    localStorage.setItem(
                        "currentUser",
                        JSON.stringify(
                            currentUser
                        )
                    );


                    localStorage.setItem(
                        "loggedInUser",
                        currentUser.email
                    );


                    // ==================================
                    // UI UPDATE
                    // ==================================

                    updateProfileSummary();


                    editing = false;

                    setEditMode(false);


                    showMessage(
                        "Profile updated successfully!",
                        "success"
                    );
                }
            );
        }


        // ==========================================
        // LOGOUT BUTTON
        // ==========================================

        if (logoutButton) {

            logoutButton.addEventListener(
                "click",
                function() {

                    if (logoutOverlay) {

                        logoutOverlay.classList.add(
                            "show"
                        );
                    }
                }
            );
        }


        // ==========================================
        // CANCEL LOGOUT
        // ==========================================

        if (cancelLogout) {

            cancelLogout.addEventListener(
                "click",
                function() {

                    logoutOverlay.classList.remove(
                        "show"
                    );
                }
            );
        }


        // ==========================================
        // CONFIRM LOGOUT
        // ==========================================

        if (confirmLogout) {

            confirmLogout.addEventListener(
                "click",
                function() {

                    logoutUser();
                }
            );
        }


        // ==========================================
        // CLICK OUTSIDE MODAL
        // ==========================================

        if (logoutOverlay) {

            logoutOverlay.addEventListener(
                "click",
                function(event) {

                    if (
                        event.target ===
                        logoutOverlay
                    ) {

                        logoutOverlay.classList.remove(
                            "show"
                        );
                    }
                }
            );
        }


        // ==========================================
        // LOGOUT FUNCTION
        // ==========================================

        function logoutUser() {

            /*
                User account data
                ceylonTeaUsers eken DELETE
                karanne naha.

                Login session/status
                witharai clear karanne.
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


            // Login page
            window.location.replace(
                "../auth/login.php"
            );
        }


        // ==========================================
        // MESSAGE
        // ==========================================

        function showMessage(
            text,
            type
        ) {

            if (!profileMessage) {
                return;
            }


            profileMessage.innerText =
                text;


            profileMessage.className =
                "profile-message " + type;
        }


        function clearMessage() {

            if (!profileMessage) {
                return;
            }


            profileMessage.innerText = "";

            profileMessage.className =
                "profile-message";
        }


        // ==========================================
        // START
        // ==========================================

        loadProfile();

    }
);