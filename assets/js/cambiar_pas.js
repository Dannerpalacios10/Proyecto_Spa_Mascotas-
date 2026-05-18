/* ========================================= */
/* MOSTRAR / OCULTAR PASSWORD */
/* ========================================= */

function togglePassword(id, element){

    const input =
    document.getElementById(id);

    const icon =
    element.querySelector("i");

    if(input.type === "password"){

        input.type = "text";

        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");

    }else{

        input.type = "password";

        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

/* ========================================= */
/* TEMPORIZADOR */
/* ========================================= */

const timer =
document.getElementById("timer");

if(timer){

    let seconds =
    parseInt(timer.innerText);

    const interval =
    setInterval(() => {

        seconds--;

        timer.innerText = seconds;

        if(seconds <= 0){

            clearInterval(interval);

            window.location.href =
            "../auth/login.php?expirado=1";
        }

    },1000);
}