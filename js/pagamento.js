document.addEventListener("click", function () {
    
    document.querySelectorAll(".item-button").forEach(button => {
        button.addEventListener("click", function () {
 
            document.querySelectorAll(".item-button").forEach(btn => btn.classList.remove("selecionado"));
            
            this.classList.add("selecionado");

        });
    });
});
