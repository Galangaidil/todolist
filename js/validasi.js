function registrasi() {
    var username = document.forms["RegForm"]["username"].value;
    var email = document.forms["RegForm"]["email"].value;
    var password = document.forms["RegForm"]["password"].value;

    if (username === "") {
        window.alert("Tolong masukkan username");
        username.focus();
        return false;
    }

    if (email === "") {
        window.alert("Tolong masukkan email");
        email.focus();
        return false;
    }

    if (password === "") {
        window.alert("Tolong masukkan password");
        password.focus();
        return false;
    }

    return true;
}