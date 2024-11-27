document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    window.location.href = "shop.php";
});

function togglePassword() {
    var passwordField = document.getElementById("password");
    var passwordFieldType = passwordField.getAttribute("type");
    var togglePasswordIcon = document.querySelector(".toggle-password i");
    if (passwordFieldType === "password") {
        passwordField.setAttribute("type", "text");
        togglePasswordIcon.classList.remove("fa-eye");
        togglePasswordIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.setAttribute("type", "password");
        togglePasswordIcon.classList.remove("fa-eye-slash");
        togglePasswordIcon.classList.add("fa-eye");
    }
}