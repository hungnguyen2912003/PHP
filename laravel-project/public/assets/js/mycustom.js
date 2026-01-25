$(document).ready(function () {
    /*****************************************
     * LOGIN, REGISTER
     *****************************************/

    $('#registerForm').submit(function (e) {
        let name = $.trim($('#name').val());
        let username = $.trim($('#username').val());
        let email = $.trim($('#email').val());
        let password = $.trim($('#password').val());
        let password_confirmation = $.trim($('#password_confirmation').val());

        let errorMsg = [];

        if (name.length < 3)
            errorMsg.push("Name must be at least 3 characters long.");

        let usernameRegex = /^[a-zA-Z0-9_]{3,}$/;
        if (!usernameRegex.test(username))
            errorMsg.push("Username must be at least 3 characters long and contain only letters, numbers, and underscores.");

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email))
            errorMsg.push("Email is not valid.");

        if (password.length < 6)
            errorMsg.push("Password must be at least 6 characters long.");

        if (password_confirmation.length < 6)
            errorMsg.push("Confirm password must be at least 6 characters long.");

        if (password_confirmation !== password)
            errorMsg.push("Confirm password must be the same as password.");

        if (errorMsg.length > 0) {
            toastr.error(errorMsg.join("\n"));
            e.preventDefault();
        }
    })

    $('#loginForm').submit(function (e) {
        let login = $.trim($('#login').val());
        let password = $.trim($('#password').val());

        let errorMsg = [];

        if (login.length < 3)
            errorMsg.push("Username or email must be at least 3 characters long.");

        if (password.length < 6)
            errorMsg.push("Password must be at least 6 characters long.");

        if (errorMsg.length > 0) {
            toastr.error(errorMsg.join("\n"));
            e.preventDefault();
        }
    })

    $('#forgotPasswordForm').submit(function (e) {
        let email = $.trim($('#email').val());
        let errorMsg = [];

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email))
            errorMsg.push("Email is not valid.");

        if (errorMsg.length > 0) {
            toastr.error(errorMsg.join("\n"));
            e.preventDefault();
        }
    })

    $('#resetPasswordForm').submit(function (e) {
        let password = $.trim($('#password').val());
        let password_confirmation = $.trim($('#password_confirmation').val());
        let errorMsg = [];

        if (password.length < 6)
            errorMsg.push("Password must be at least 6 characters long.");

        if (password_confirmation.length < 6)
            errorMsg.push("Confirm password must be at least 6 characters long.");

        if (password_confirmation !== password)
            errorMsg.push("Confirm password must be the same as password.");

        if (errorMsg.length > 0) {
            toastr.error(errorMsg.join("\n"));
            e.preventDefault();
        }
    })

});