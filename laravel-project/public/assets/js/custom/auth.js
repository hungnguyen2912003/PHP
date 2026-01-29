$(document).ready(function () {
    let btnText = $('#btnText');
    let btnLoading = $('#btnLoading');
    let submitBtn = $('#submitBtn');
    
    /*****************************************
     * AUTH FORMS HANDLING (LOGIN, REGISTER, ETC)
     *****************************************/

    // Use a single selector for all auth forms to be more maintainable
    $('#loginForm, #registerForm, #forgotPasswordForm, #resetPasswordForm, #setFirstPasswordForm, #addUserForm').on('submit', function (e) {
        let $form = $(this);
        let $btn = $form.find('#submitBtn');
        let $btnText = $form.find('#btnText');
        let $btnLoading = $form.find('#btnLoading');
        
        // Clear old errors and highlight invalid fields
        $form.find('span.text-danger').not('label span.text-danger').text('');
        $form.find('.is-invalid').removeClass('is-invalid');

        // Show loading state
        // Use setTimeout to ensure the browser has already initiated the submission
        // before the button is disabled. Synchronous disable can abort submission in some browsers.
        if ($btn.length > 0) {
            setTimeout(function() {
                $btn.prop('disabled', true);
                let processingText = $btn.data('processing-text') || 'Processing...';
                
                if ($btnText.length > 0) {
                     $btnText.text(processingText);
                }
                
                if ($btnLoading.length > 0) {
                    $btnLoading.removeClass('d-none');
                }
            }, 0);
        }
        
        return true; // Allow natural submission
    });
});