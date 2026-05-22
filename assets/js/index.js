const adminBtn =
document.querySelector(".btn-loginadmin");

if(adminBtn){

    adminBtn.addEventListener("mouseenter", ()=>{

        adminBtn.style.transform =
        "translateY(-2px)";

    });

    adminBtn.addEventListener("mouseleave", ()=>{

        adminBtn.style.transform =
        "translateY(0px)";

    });

}

const header =
document.querySelector(".header");

window.addEventListener("scroll", ()=>{

    if(window.scrollY > 50){

        header.style.background =
        "rgba(255,255,255,.98)";

        header.style.boxShadow =
        "0 5px 20px rgba(0,0,0,.12)";

    }else{

        header.style.background =
        "rgba(255,255,255,.95)";

        header.style.boxShadow =
        "0 2px 15px rgba(0,0,0,.08)";
    }

});