function togglePassword() {
    const password = document.getElementById("password");

    password.type = (password.type === "password")
        ? "text"
        : "password";
}


const countdown = document.getElementById("countdown");

if (countdown) {

    let seconds = parseInt(countdown.innerText);

    const interval = setInterval(() => {

        seconds--;

        if (seconds <= 0) {
            clearInterval(interval);
            location.reload();
            return;
        }

        countdown.innerText = seconds;

    }, 1000);
}


