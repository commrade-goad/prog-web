let email = document.getElementById("email");
let emailError = document.getElementById("email-error");
email.addEventListener('blur', function (e) {
    let user_input = email.value;
    if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(user_input)) {
        // alert("Invalid Email!");
        // email.value = '';
        emailError.style.display = 'inline';
    } else {
        emailError.style.display = 'none';
    }
});
