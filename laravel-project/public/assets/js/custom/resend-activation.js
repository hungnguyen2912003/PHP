document.addEventListener('DOMContentLoaded', function() {
    const resendBtn = document.getElementById('resend-activation-btn');
    if (!resendBtn) return;

    const resendText = document.getElementById('resend-text');
    const btnLoading = document.getElementById('btnLoading');
    const cooldownTime = 120;
    const storageKey = 'activation_resend_cooldown';

    function updateButtonState(remaining) {
        if (remaining > 0) {
            resendBtn.disabled = true;
            resendText.textContent = `Resend in ${remaining}s`;
            resendBtn.classList.remove('btn-warning');
            resendBtn.classList.add('btn-secondary');
        } else {
            resendBtn.disabled = false;
            resendText.textContent = 'Activate your account';
            resendBtn.classList.remove('btn-secondary');
            resendBtn.classList.add('btn-warning');
            localStorage.removeItem(storageKey);
        }
    }

    function startCooldown(seconds) {
        let remaining = seconds;
        updateButtonState(remaining);
        const interval = setInterval(() => {
            remaining--;
            localStorage.setItem(storageKey, Date.now() + remaining * 1000);
            updateButtonState(remaining);
            if (remaining <= 0) clearInterval(interval);
        }, 1000);
    }

    const savedCooldown = localStorage.getItem(storageKey);
    if (savedCooldown) {
        const remaining = Math.ceil((parseInt(savedCooldown) - Date.now()) / 1000);
        if (remaining > 0) startCooldown(remaining);
        else localStorage.removeItem(storageKey);
    }

    resendBtn.addEventListener('click', function() {
        const userId = this.getAttribute('data-user-id');
        const route = this.getAttribute('data-route');
        const csrfToken = this.getAttribute('data-csrf');

        resendBtn.disabled = true;
        resendText.textContent = 'Sending ';
        btnLoading.classList.remove('d-none');

        fetch(route, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ user_id: userId })
        })
        .then(response => response.json())
        .then(data => {
            btnLoading.classList.add('d-none');
            
            if (data.success) {
                startCooldown(cooldownTime);
                
                flasher.success(data.message);
            } else {
                resendBtn.disabled = false;
                resendText.textContent = 'Activate your account';
                
                flasher.error(data.message || 'Something went wrong.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            flasher.error('Error: ' + error);
            btnLoading.classList.add('d-none');
            resendBtn.disabled = false;
            resendText.textContent = 'Activate your account';
        });
    });
});
