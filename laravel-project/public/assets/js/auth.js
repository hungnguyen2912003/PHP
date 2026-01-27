$(document).ready(function () {
    let btnText = $('#btnText');
    let btnLoading = $('#btnLoading');
    let submitBtn = $('#submitBtn');
    
    /*****************************************
     * AUTH FORMS HANDLING (LOGIN, REGISTER, ETC)
     *****************************************/

    // Use a single selector for all auth forms to be more maintainable
    $('#loginForm, #registerForm, #forgotPasswordForm, #resetPasswordForm').on('submit', function (e) {
        let $form = $(this);
        
        // Clear old errors and highlight invalid fields
        $form.find('span.text-danger').not('label span.text-danger').text('');
        $form.find('.is-invalid').removeClass('is-invalid');

        // Show loading state
        // Use setTimeout to ensure the browser has already initiated the submission
        // before the button is disabled. Synchronous disable can abort submission in some browsers.
        setTimeout(function() {
            submitBtn.prop('disabled', true);
            btnText.text('Processing...');
            btnLoading.removeClass('d-none');
        }, 0);
        
        return true; // Allow natural submission
    });
});