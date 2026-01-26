let currentStep = 1;
const totalSteps = 4;

const steps = document.querySelectorAll(".sign-up-step");
const stepCircles = document.querySelectorAll(".step-circle");
const progressBar = document.getElementById("progress-bar");

document.addEventListener('DOMContentLoaded', () => {

    const forgotLink = document.getElementById('forgot-password-link');
    const loginForm = document.getElementById('login-form-form');
    const resetForm = document.getElementById('reset-password-form');
    const backToLoginBtn = document.getElementById('back-to-login');

    if (forgotLink && loginForm && resetForm) {
        forgotLink.addEventListener('click', function (e) {
            e.preventDefault();
            loginForm.classList.add('hidden');
            resetForm.classList.remove('hidden');
        });
    }

    if (backToLoginBtn && loginForm && resetForm) {
        backToLoginBtn.addEventListener('click', function (e) {
            e.preventDefault();
            resetForm.classList.add('hidden');
            loginForm.classList.remove('hidden');
        });
    }
    const signupscreen = document.querySelector('.sign-up-screen');
    const loginscreen = document.querySelector('.login-screen');

    const haveAccountBtn = document.getElementById('have_accaunt');
    if (haveAccountBtn) {
        haveAccountBtn.addEventListener('click', (e) => {
            if (loginscreen.classList.contains('hidden')) {
                loginscreen.classList.remove('hidden');
                signupscreen.classList.add('hidden');
            }
        });
    }

    const noAccountBtn = document.getElementById('no_accaunt');
    if (noAccountBtn) {
        noAccountBtn.addEventListener('click', (e) => {
            if (signupscreen.classList.contains('hidden')) {
                signupscreen.classList.remove('hidden');
                loginscreen.classList.add('hidden');
            }
        });
    }

    updateUI();
});


function nextStep() {
    if (!validateCurrentStep()) {
        return;
    }

    if (currentStep < totalSteps) {
        currentStep++;
        updateUI();
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        updateUI();
    }
}

function updateUI() {
    if (steps) {
        steps.forEach((step) => {
            const stepNum = parseInt(step.getAttribute("data-step"));
            if (stepNum === currentStep) {
                step.classList.add("active");
                step.style.display = "flex";
            } else {
                step.classList.remove("active");
                step.style.display = "none";
            }
        });
    }

    if (stepCircles) {
        stepCircles.forEach((circle, index) => {
            if (index + 1 <= currentStep) {
                circle.classList.add("active");
            } else {
                circle.classList.remove("active");
            }
        });
    }

    if (progressBar) {
        const progressPercent = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressBar.style.width = `${progressPercent}%`;
    }
}

function validateCurrentStep() {
    const currentStepEl = document.querySelector(`.sign-up-step[data-step="${currentStep}"]`);
    const inputs = currentStepEl.querySelectorAll("input[required], select[required]");

    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim() || !input.checkValidity()) {
            isValid = false;
            input.style.borderColor = "red";
            input.style.borderWidth = "2px";
            input.addEventListener('input', function () {
                if (this.checkValidity()) {
                    this.style.borderColor = "black";
                }
            }, { once: false });
        } else {
            input.style.borderColor = "black";
        }
    });

    return isValid;
}