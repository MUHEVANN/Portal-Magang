function changeVisiblity() {
    let pass = document.getElementById("pass");
    let indi = document.getElementById("indicator");
    if (pass.type == "password") {
        pass.type = "text";
        indi.src = "assets/eye.svg";
    } else {
        pass.type = "password";
        indi.src = "assets/close-eye.svg";
    }
}
