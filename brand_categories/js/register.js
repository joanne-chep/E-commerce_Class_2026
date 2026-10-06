document.addEventListener("DOMContentLoaded", function () {
    const registrationForm = document.getElementById("registration-form");
    const passwordInput = document.getElementById("customer_pass");

    const ruleLength = document.getElementById("rule-length");
    const ruleUpper = document.getElementById("rule-upper");
    const ruleLower = document.getElementById("rule-lower");
    const ruleNumber = document.getElementById("rule-number");
    const ruleSpecial = document.getElementById("rule-special");

    // Real-time evaluation of password criteria while typing
    passwordInput.addEventListener("input", function () {
        const val = passwordInput.value;

        // Minimum 8 characters
        if (val.length >= 8) {
            ruleLength.className = "valid";
        } else {
            ruleLength.className = "invalid";
        }

        // At least one uppercase letter
        if (/[A-Z]/.test(val)) {
            ruleUpper.className = "valid";
        } else {
            ruleUpper.className = "invalid";
        }

        // At least one lowercase letter
        if (/[a-z]/.test(val)) {
            ruleLower.className = "valid";
        } else {
            ruleLower.className = "invalid";
        }

        // At least one numerical digit
        if (/[0-9]/.test(val)) {
            ruleNumber.className = "valid";
        } else {
            ruleNumber.className = "invalid";
        }

        // At least one special character
        if (/[@$!%*?&#^()_\-+={}[\]:;"'<>,.|/\\~`]/.test(val)) {
            ruleSpecial.className = "valid";
        } else {
            ruleSpecial.className = "invalid";
        }
    });

    // Prevent submission if password fails any of the required checks
    registrationForm.addEventListener("submit", function (event) {
        const val = passwordInput.value;
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_\-+={}[\]:;"'<>,.|/\\~`])[A-Za-z\d@$!%*?&#^()_\-+={}[\]:;"'<>,.|/\\~`]{8,}$/;

        if (!passwordRegex.test(val)) {
            event.preventDefault();
            alert("Please ensure your password meets all five complexity criteria before submitting.");
            passwordInput.focus();
        }
    });
});