$(document).ready(function () {
   /*****************************************
    * LOGIN, REGISTER
    *****************************************/

    $('#registerForm').submit(function (e) {
        let name = $.trim($('input[name="name"]').val());
        let username = $.trim($('input[name="username"]').val());
        let email = $.trim($('input[name="email"]').val());
        let password = $.trim($('input[name="password"]').val());
        let password_confirmation = $.trim($('input[name="password_confirmation"]').val());
        let termsCheckbox = $('input[name="termsCheckbox"]').is(':checked');

        let errorMsg = [];

        if(name.length < 3)
            errorMsg.push("Name must be at least 3 characters long.");

        let usernameRegex = /^[a-zA-Z0-9_]{3,}$/;
        if(!usernameRegex.test(username))
            errorMsg.push("Username must be at least 3 characters long and contain only letters, numbers, and underscores.");

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailRegex.test(email))
            errorMsg.push("Email is not valid.");

        if(password.length < 6)
            errorMsg.push("Password must be at least 6 characters long.");

        if(password_confirmation.length < 6)
            errorMsg.push("Confirm password must be at least 6 characters long.");

        if(password_confirmation !== password)
            errorMsg.push("Confirm password must be the same as password.");

        if(!termsCheckbox)
            errorMsg.push("Terms and conditions must be accepted.");

        if(errorMsg.length > 0)
        {
            toastr.error(errorMsg.join("\n"));
            e.preventDefault();
        }
    })
   
});