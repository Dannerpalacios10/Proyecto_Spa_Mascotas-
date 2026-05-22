document.addEventListener("DOMContentLoaded",()=>{

    /* ANIMACIÓN TABLA */

    const rows =
    document.querySelectorAll("tbody tr");

    rows.forEach((row,index)=>{

        row.style.opacity = "0";

        row.style.transform =
        "translateY(20px)";

        setTimeout(()=>{

            row.style.transition =
            ".5s ease";

            row.style.opacity = "1";

            row.style.transform =
            "translateY(0px)";

        },index * 120);

    });

    /* HOVER FILAS */

    rows.forEach(row=>{

        row.addEventListener("mouseenter",()=>{

            row.style.transform =
            "scale(1.01)";

            row.style.background =
            "rgba(255,255,255,.06)";
        });

        row.addEventListener("mouseleave",()=>{

            row.style.transform =
            "scale(1)";

            row.style.background =
            "transparent";
        });

    });

    /* NAVBAR SCROLL */

    const navbar =
    document.querySelector(".navbar");

    window.addEventListener("scroll",()=>{

        if(window.scrollY > 20){

            navbar.style.background =
            "rgba(15,23,42,.95)";

            navbar.style.backdropFilter =
            "blur(25px)";

        }else{

            navbar.style.background =
            "rgba(255,255,255,.08)";
        }

    });

});