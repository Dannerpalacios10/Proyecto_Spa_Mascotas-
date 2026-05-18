/* MOSTRAR PASSWORD */

function togglePassword(id){

    const input =
    document.getElementById(id);

    if(input.type === "password"){

        input.type = "text";

    }else{

        input.type = "password";
    }
}

/* PASSWORD STRENGTH */

const password =
document.getElementById("password");

const confirmPassword =
document.getElementById("confirmPassword");

const bar =
document.getElementById("bar");

const match =
document.getElementById("passwordMatch");

password.addEventListener("keyup",()=>{

    const value =
    password.value;

    let strength = 0;

    /* 8 caracteres */

    if(value.length >= 8){

        strength += 20;

        document.getElementById("rule1").style.color="#22c55e";

    }else{

        document.getElementById("rule1").style.color="white";
    }

    /* MAYUSCULA */

    if(/[A-Z]/.test(value)){

        strength += 20;

        document.getElementById("rule2").style.color="#22c55e";

    }else{

        document.getElementById("rule2").style.color="white";
    }

    /* MINUSCULA */

    if(/[a-z]/.test(value)){

        strength += 20;

        document.getElementById("rule3").style.color="#22c55e";

    }else{

        document.getElementById("rule3").style.color="white";
    }

    /* NUMERO */

    if(/[0-9]/.test(value)){

        strength += 20;

        document.getElementById("rule4").style.color="#22c55e";

    }else{

        document.getElementById("rule4").style.color="white";
    }

    /* SIMBOLO */

    if(/[\W]/.test(value)){

        strength += 20;

        document.getElementById("rule5").style.color="#22c55e";

    }else{

        document.getElementById("rule5").style.color="white";
    }

    /* BARRA */

    bar.style.width =
    strength + "%";

    if(strength <= 40){

        bar.style.background =
        "#ef4444";

    }else if(strength <= 80){

        bar.style.background =
        "#f59e0b";

    }else{

        bar.style.background =
        "#22c55e";
    }
});

/* ========================================== */
/* VERIFICAR PASSWORD */
/* ========================================== */

confirmPassword.addEventListener("keyup",()=>{

    if(confirmPassword.value === ""){

        match.innerHTML = "";
        return;
    }

    if(password.value === confirmPassword.value){

        match.innerHTML =
        "✔ Las contraseñas coinciden";

        match.style.color =
        "#22c55e";

    }else{

        match.innerHTML =
        "✖ Las contraseñas no coinciden";

        match.style.color =
        "#ef4444";
    }
});