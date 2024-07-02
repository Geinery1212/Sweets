document.addEventListener("DOMContentLoaded", function() {
    var hamburguesa = document.querySelector(".hamburguesa");
    var menuLista = document.querySelector(".menu-lista");

    hamburguesa.addEventListener("click", function() {
        this.classList.toggle("abierto");
        menuLista.classList.toggle("mostrar");
    });
});