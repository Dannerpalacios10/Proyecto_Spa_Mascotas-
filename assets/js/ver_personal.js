document.querySelectorAll("tr").forEach(row=>{

    row.addEventListener("mouseenter",()=>{

        row.style.transform = "scale(1.01)";
    });

    row.addEventListener("mouseleave",()=>{

        row.style.transform = "scale(1)";
    });
});