document.addEventListener("DOMContentLoaded",()=>{

    /* CARDS */

    const cards =
    document.querySelectorAll(".card");

    cards.forEach((card,index)=>{

        // ANIMACIÓN ENTRADA
        card.style.opacity = "0";

        card.style.transform =
        "translateY(40px)";

        setTimeout(()=>{

            card.style.transition =
            ".6s ease";

            card.style.opacity = "1";

            card.style.transform =
            "translateY(0px)";

        },index * 200);

        // EFECTO HOVER
        card.addEventListener("mousemove",(e)=>{

            const rect =
            card.getBoundingClientRect();

            const x =
            e.clientX - rect.left;

            const y =
            e.clientY - rect.top;

            card.style.background =
            `
            radial-gradient(
            circle at ${x}px ${y}px,
            rgba(255,255,255,.15),
            rgba(255,255,255,.05)
            )
            `;
        });

        card.addEventListener("mouseleave",()=>{

            card.style.background =
            "rgba(255,255,255,.08)";
        });

    });

    /* NAVBAR */

    const navbar =
    document.querySelector(".navbar");

    window.addEventListener("scroll",()=>{

        if(window.scrollY > 20){

            navbar.style.background =
            "rgba(15,23,42,.9)";

            navbar.style.backdropFilter =
            "blur(25px)";

        }else{

            navbar.style.background =
            "rgba(255,255,255,.08)";
        }

    });

    /* BOTONES */

    const buttons =
    document.querySelectorAll("a, button");

    buttons.forEach(btn=>{

        btn.addEventListener("mouseenter",()=>{

            btn.style.transform =
            "translateY(-3px)";
        });

        btn.addEventListener("mouseleave",()=>{

            btn.style.transform =
            "translateY(0px)";
        });

    });

});