function togglePassword(){

    const password =
    document.getElementById("password");

    if(password.type === "password"){

        password.type = "text";

    }else{

        password.type = "password";
    }
}

document.addEventListener("DOMContentLoaded", () => {

    const loginBtn =
    document.querySelector(".login-btn");

    if(loginBtn){

        loginBtn.addEventListener("click", () => {

            loginBtn.style.transform =
            "scale(0.97)";

            setTimeout(() => {

                loginBtn.style.transform =
                "scale(1)";

            },150);

        });

    }

});

