$(document).ready(function () {
    let btnText = $('#btnText');
    let btnLoading = $('#btnLoading');
    let submitBtn = $('#submitBtn');
    
    /*****************************************
     * REGISTER, LOGIN, FORGOT PASSWORD, RESET PASSWORD
     *****************************************/

    $('#form').submit(function (e) {
        e.preventDefault();
        $(this).find('span.text-danger').not('label span.text-danger').text('');
        $(this).find('.is-invalid').removeClass('is-invalid');
        submitBtn.prop('disabled', true);
        btnText.text('Processing...');
        btnLoading.removeClass('d-none');
    })
});