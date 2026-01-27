$(document).ready(function () {
    $('#form').submit(function (e) {
        let form = $(this);
        let submitBtn = $('#submitBtn');
        let btnText = $('#btnText');
        let btnLoading = $('#btnLoading');

        form.find('span.text-danger').not('label span.text-danger').text('');
        form.find('.is-invalid').removeClass('is-invalid');

        if (submitBtn.length) {
            submitBtn.prop('disabled', true);
            if (btnText.length) btnText.text('Processing...');
            if (btnLoading.length) btnLoading.removeClass('d-none');
        }
    });
});
