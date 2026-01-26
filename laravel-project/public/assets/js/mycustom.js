$(document).ready(function () {
    let btnText = $('#btnText');
    let btnLoading = $('#btnLoading');
    let submitBtn = $('#submitBtn');
    
    
    /*****************************************
     * REGISTER
     *****************************************/

    $('#registerForm').submit(function (e) {
        $(this).find('span.text-danger').not('label span.text-danger').text('');
        $(this).find('.is-invalid').removeClass('is-invalid');
        submitBtn.prop('disabled', true);
        btnText.text('Processing...');
        btnLoading.removeClass('d-none');
    })

    /*****************************************
     * LOGIN
     *****************************************/
    $('#loginForm').submit(function (e) {
        $(this).find('span.text-danger').not('label span.text-danger').text('');
        $(this).find('.is-invalid').removeClass('is-invalid');
        submitBtn.prop('disabled', true);
        btnText.text('Processing...');
        btnLoading.removeClass('d-none');
    })

    /*****************************************
     * FORGOT PASSWORD
     *****************************************/
    $('#forgotPasswordForm').submit(function (e) {
        $(this).find('span.text-danger').not('label span.text-danger').text('');
        $(this).find('.is-invalid').removeClass('is-invalid');
        submitBtn.prop('disabled', true);
        btnText.text('Processing...');
        btnLoading.removeClass('d-none');
    })

    /*****************************************
     * RESET PASSWORD
     *****************************************/
    $('#resetPasswordForm').submit(function (e) {
        $(this).find('span.text-danger').not('label span.text-danger').text('');
        $(this).find('.is-invalid').removeClass('is-invalid');
        submitBtn.prop('disabled', true);
        btnText.text('Processing...');
        btnLoading.removeClass('d-none');
    })
});