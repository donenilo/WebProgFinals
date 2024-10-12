function showSignUp() {
    document.getElementById("signup").style.display = "block";
    document.getElementById("login").style.display = "none";
}

function backToLogIn() {
    document.getElementById("signup").style.display = "none";
    document.getElementById("login").style.display = "block";
}

const ltogglePassword = document.querySelector("#ltogglePassword");
const stogglePassword = document.querySelector("#stogglePassword");
const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");

const lpassword = document.querySelector("#lpassword")
const spassword = document.querySelector("#spassword")
const confirmPassword = document.querySelector("#confirmPassword")

ltogglePassword.addEventListener("click", function(e) {
    const type = lpassword.getAttribute("type") === "password" ? "text" : "password";
    lpassword.setAttribute("type", type);

    this.classList.toggle("bi-eye")
})

stogglePassword.addEventListener("click", function(e) {
    const type = spassword.getAttribute("type") === "password" ? "text" : "password";
    spassword.setAttribute("type", type);

    this.classList.toggle("bi-eye")
})

toggleConfirmPassword.addEventListener("click", function(e) {
    const type = confirmPassword.getAttribute("type") === "password" ? "text" : "password";
    confirmPassword.setAttribute("type", type);

    this.classList.toggle("bi-eye")
})