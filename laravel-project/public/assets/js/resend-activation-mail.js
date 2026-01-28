document.addEventListener('DOMContentLoaded', function () {
    const STORAGE_KEY = 'activation_next_resend_time';
    const COOLDOWN_SECONDS = 120; // 2 minutes

    let btnTextActivation = document.getElementById('btnTextActivation');
    let btnLoadingActivation = document.getElementById('btnLoadingActivation');
    let submitBtn = document.getElementById('resend-activation-btn');
    let form = document.getElementById('resendActivationForm');
    
    // Check cooldown on load
    const storedTime = localStorage.getItem(STORAGE_KEY);
    if (storedTime) {
        const endTime = parseInt(storedTime);
        const now = Date.now();
        if (endTime > now) {
            startCooldown(endTime);
        } else {
            localStorage.removeItem(STORAGE_KEY);
        }
    }

    function formatTime(ms) {
        const totalSeconds = Math.ceil(ms / 1000);
        const m = Math.floor(totalSeconds / 60);
        const s = totalSeconds % 60;
        return `${m}:${s < 10 ? '0' : ''}${s}`;
    }

    function startCooldown(endTime) {
        if (!submitBtn) return;
        
        submitBtn.disabled = true;
        if (btnLoadingActivation) btnLoadingActivation.classList.add('d-none');

        // Update immediately
        updateTimer(endTime);

        const interval = setInterval(() => {
            const now = Date.now();
            if (now >= endTime) {
                clearInterval(interval);
                stopCooldown();
            } else {
                updateTimer(endTime);
            }
        }, 1000);
    }

    function updateTimer(endTime) {
        const remaining = endTime - Date.now();
        if (btnTextActivation) {
            const resendInText = btnTextActivation.getAttribute('data-resend-in-text') || 'Resend in';
            btnTextActivation.innerText = `${resendInText} ${formatTime(remaining)}`;
        }
    }

    function stopCooldown() {
        localStorage.removeItem(STORAGE_KEY);
        if (submitBtn) submitBtn.disabled = false;
        if (btnTextActivation) {
            const originalText = btnTextActivation.getAttribute('data-original-text') || 'Activate your account';
            btnTextActivation.innerText = originalText;
        }
    }

    /*****************************************
     * RESEND ACTIVATION MAIL
     *****************************************/

    if (form) {
        form.addEventListener('submit', function (e) {
            // Set cooldown
            const endTime = Date.now() + (COOLDOWN_SECONDS * 1000);
            localStorage.setItem(STORAGE_KEY, endTime.toString());

            // Show loading state immediately
            setTimeout(function() {
                if (submitBtn) submitBtn.disabled = true;
                if (btnTextActivation) {
                     const sendingText = btnTextActivation.getAttribute('data-sending-text') || 'Sending...';
                     btnTextActivation.innerText = sendingText;
                }
                if (btnLoadingActivation) btnLoadingActivation.classList.remove('d-none');
            }, 0);
        });
    }
});