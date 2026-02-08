$(document).ready(function () {
    /*****************************************
     * FORM SUBMISSION LOADING STATE
     *****************************************/

    $(document).on('submit', '#common-form', function (e) {
        let $form = $(this);
        let $btn = $form.find('#submitBtn');
        let $btnText = $form.find('#btnText');
        let $btnLoading = $form.find('#btnLoading');

        // Clear old errors and highlight invalid fields
        $form.find('span.text-danger').not('label span.text-danger').text('');
        $form.find('.is-invalid').removeClass('is-invalid');

        // Show loading state
        if ($btn.length > 0) {
            // Use setTimeout to ensure the browser has already initiated the submission
            setTimeout(function () {
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