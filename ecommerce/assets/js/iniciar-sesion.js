document.getElementById("btn__iniciar-sesion").addEventListener("click", function(event) {
    event.preventDefault();
    iniciarSesion();
});
document.getElementById("btn__registrarse").addEventListener("click", function(event) {
    event.preventDefault();
    register();
});

// Declarando variables
var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

// Track focus state
let isInputFocused = false;

// Add focus and blur event listeners to all input fields
const inputFields = document.querySelectorAll('input');

inputFields.forEach(input => {
    input.addEventListener('focus', () => {
        isInputFocused = true;
    });
    input.addEventListener('blur', () => {
        isInputFocused = false;
    });
});

window.addEventListener("resize", function() {
    if (!isInputFocused) {
        anchoPage();
    }
});

// FUNCIONES

function anchoPage() {
    if (window.innerWidth > 850) {
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    } else {
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";
    }
}

anchoPage();

function iniciarSesion() {
    if (window.innerWidth > 850) {
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "10px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.opacity = "0";
    } else {
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "none";
    }
}

function register() {
    if (window.innerWidth > 850) {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "410px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.opacity = "0";
        caja_trasera_login.style.opacity = "1";
    } else {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.display = "none";
        caja_trasera_login.style.display = "block";
        caja_trasera_login.style.opacity = "1";
    }
}
