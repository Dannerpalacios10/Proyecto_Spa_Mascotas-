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
