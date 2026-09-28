//This file is responsible for client-side validation of the customer registration form.
// It ensures that user inputs meet specified criteria before submission to the server, enhancing user experience and reducing server load.

document.addEventListener("DOMContentLoaded", () => {
const registerForm = document.getElementById("registerForm");
// If the form is not present on the page, exit early to avoid errors.
if (!registerForm) {
    return;
}


const nameInput = document.getElementById("customer_name");
const emailInput = document.getElementById("customer_email");
const passInput = document.getElementById("customer_pass");
const countryInput = document.getElementById("customer_country");
const cityInput = document.getElementById("customer_city");
const contactInput = document.getElementById("customer_contact");
const submitButton = document.getElementById("submitBtn");


const nameError = document.getElementById("nameError");
const emailError = document.getElementById("emailError");
const passError = document.getElementById("passError");
const countryError = document.getElementById("countryError");
const cityError = document.getElementById("cityError");
const contactError = document.getElementById("contactError");

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const phoneRegex = /^[0-9+\-\s]{7,15}$/;

function clearErrors() {
    nameError.textContent = "";
    emailError.textContent = "";
    passError.textContent = "";
    countryError.textContent = "";
    cityError.textContent = "";
    contactError.textContent = "";
}

  // Intercept the submission event
registerForm.addEventListener("submit", (e) => {
    // Reset previous feedback state
    clearErrors();

    let isValid = true;

    // Validate customer name
    if (nameInput.value.trim() === "") {
    nameError.textContent = "Please enter your full name.";
    isValid = false;
    } else if (nameInput.value.trim().length > 100) {
    nameError.textContent = "Full name cannot exceed 100 characters.";
    isValid = false;
    }

    // Validate email format and database length constraints
    const emailVal = emailInput.value.trim();
    if (emailVal === "") {
    emailError.textContent = "Please enter an email address.";
    isValid = false;
    } else if (!emailRegex.test(emailVal)) {
    emailError.textContent = "Please enter a valid email format (e.g., name@domain.com).";
    isValid = false;
    } else if (emailVal.length > 50) {
    emailError.textContent = "Email address cannot exceed 50 characters.";
    isValid = false;
    }

    // Validate password complexity/length
    if (passInput.value === "") {
    passError.textContent = "Please enter a password.";
    isValid = false;
    } else if (passInput.value.length < 6) {
    passError.textContent = "Password must be at least 6 characters long.";
    isValid = false;
    }

    // Validate country selection
    if (countryInput.value.trim() === "") {
    countryError.textContent = "Please select your country of residence.";
    isValid = false;
    }

    // Validate city name
    if (cityInput.value.trim() === "") {
    cityError.textContent = "Please enter your city.";
    isValid = false;
    } else if (cityInput.value.trim().length > 30) {
    cityError.textContent = "City cannot exceed 30 characters.";
    isValid = false;
    }

    // Validate contact number with regular expression
    const contactVal = contactInput.value.trim();
    if (contactVal === "") {
    contactError.textContent = "Please enter a contact phone number.";
    isValid = false;
    } else if (!phoneRegex.test(contactVal)) {
    contactError.textContent = "Please provide a valid phone number (digits, spaces, or +).";
    isValid = false;
    } else if (contactVal.length > 15) {
    contactError.textContent = "Contact number cannot exceed 15 digits.";
    isValid = false;
    }

    // Prevent submission if any constraint was violated
    if (!isValid) {
    e.preventDefault();
    return;
    }

    // Display a loading state on the submission button upon passing client checks
    if (submitButton) {
    submitButton.disabled = true;
    submitButton.textContent = "Registering Account...";
    }
});
});