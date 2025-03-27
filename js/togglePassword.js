// JavaScript function for toggling between showing and hiding the entered password
function togglePassword() {

    var password_entry = document.getElementById("password");
    
    if (password_entry.type === "password") {
        password_entry.type = "text";

    } else {

        password_entry.type = "password";

    }
}