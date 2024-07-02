var carritoVisible = false;
var base_url = "https://enjoyyoursweets.000webhostapp.com/ecommerce/";
var unidades = 0;
if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready);
} else {
    ready();
}

function ready() {
    var botonesEliminarItem = document.getElementsByClassName('btn-eliminar');
    for (var i = 0; i < botonesEliminarItem.length; i++) {
        var button = botonesEliminarItem[i];
        button.addEventListener('click', eliminarItemCarrito);
    }

    var botonesSumarCantidad = document.getElementsByClassName('sumar-cantidad');
    for (var i = 0; i < botonesSumarCantidad.length; i++) {
        var button = botonesSumarCantidad[i];
        button.addEventListener('click', sumarCantidad);
    }

    var botonesRestarCantidad = document.getElementsByClassName('restar-cantidad');
    for (var i = 0; i < botonesRestarCantidad.length; i++) {
        var button = botonesRestarCantidad[i];
        button.addEventListener('click', restarCantidad);
    }

    var botonesAgregarAlCarrito = document.getElementsByClassName('comprar');
    for (var i = 0; i < botonesAgregarAlCarrito.length; i++) {
        var button = botonesAgregarAlCarrito[i];
        button.addEventListener('click', agregarAlCarritoClicked);
    }

    document.getElementsByClassName('btn-pagar')[0].addEventListener('click', pagarClicked);
}

function pagarClicked() {
    window.location = base_url + '/pedido/hacer';
}

function agregarAlCarritoClicked(event) {
    var button = event.target;
    var item = button.parentElement.parentElement.parentElement;
    var productoId = item.dataset.productoId;

    agregarItemAlCarrito(productoId);
    hacerVisibleCarrito();
}

function hacerVisibleCarrito() {
    carritoVisible = true;
    var carrito = document.getElementsByClassName('carrito')[0];
    carrito.style.marginRight = '0';
    carrito.style.opacity = '1';
}

function agregarItemAlCarrito(productoId) {
    fetch(`${base_url}cart/addToCart&id=${productoId}`)
        .then(response => response.text())  // Convertimos la respuesta a texto
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Extraemos el valor del elemento con id 'response'
            const responseValue = doc.getElementById('response')?.value;
            console.log(responseValue);

            // Si responseValue es una cadena JSON, la convertimos a un objeto
            const data = responseValue ? JSON.parse(responseValue) : null;

            if (data && data.success && data.producto != null) {
                var item = document.createElement('div');
                item.classList.add('carrito-item');
                item.dataset.productoId = productoId;

                item.innerHTML = `
                    <img src="${base_url}uploads/images/${data.producto.imagen}" width="80px" alt="">
                    <div class="carrito-item-detalles" id="item-carrito-${data.producto.id}">
                        <span class="carrito-item-titulo">${data.producto.nombre}</span>
                        <div class="selector-cantidad">
                            <i class="fa-solid fa-minus restar-cantidad"></i>
                            <input type="text" value="1" class="carrito-item-cantidad" disabled>
                            <i class="fa-solid fa-plus sumar-cantidad"></i>
                        </div>
                        <span class="carrito-item-precio">$${data.producto.precio} MXN</span>
                    </div>
                    <button class="btn-eliminar">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                `;
                var itemsCarrito = document.getElementsByClassName('carrito-items')[0];
                itemsCarrito.append(item);

                item.getElementsByClassName('btn-eliminar')[0].addEventListener('click', eliminarItemCarrito);
                var botonRestarCantidad = item.getElementsByClassName('restar-cantidad')[0];
                botonRestarCantidad.addEventListener('click', restarCantidad);
                var botonSumarCantidad = item.getElementsByClassName('sumar-cantidad')[0];
                botonSumarCantidad.addEventListener('click', sumarCantidad);
                unidades++;
                actualizarTotalCarrito();
            } else if (data && data.success && data.producto == null) {
                var cantidadActual = parseInt(data.quantity);
                
                var selector = document.getElementById(`item-carrito-${productoId}`);
                console.log(`item-carrito-${productoId}`);

                fetch(`${base_url}cart/up&id=${productoId}`)
                    .then(response => response.text())  // Convertimos la respuesta a texto
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Extraemos el valor del elemento con id 'response'
                        const responseValue = doc.getElementById('response')?.value;
                        console.log(responseValue);

                        // Si responseValue es una cadena JSON, la convertimos a un objeto
                        const data = responseValue ? JSON.parse(responseValue) : null;

                        if (data && data.success) {
                            selector.getElementsByClassName('carrito-item-cantidad')[0].value = cantidadActual;
                            unidades++;
                            actualizarTotalCarrito();
                        } else {
                            alert('No hay suficiente stock.');
                        }
                    });
            } else {
                alert('Error al agregar el producto al carrito.');
            }
        });
}

function sumarCantidad(event) {
    var buttonClicked = event.target;
    var selector = buttonClicked.parentElement;
    var cantidadActual = parseInt(selector.getElementsByClassName('carrito-item-cantidad')[0].value);
    var productoId = selector.parentElement.parentElement.dataset.productoId;

    fetch(`${base_url}cart/up&id=${productoId}`)
        .then(response => response.text())  // Convertimos la respuesta a texto
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Extraemos el valor del elemento con id 'response'
            const responseValue = doc.getElementById('response')?.value;
            console.log(responseValue);

            // Si responseValue es una cadena JSON, la convertimos a un objeto
            const data = responseValue ? JSON.parse(responseValue) : null;

            if (data && data.success) {
                cantidadActual++;
                unidades++;
                selector.getElementsByClassName('carrito-item-cantidad')[0].value = cantidadActual;
                actualizarTotalCarrito();
            } else {
                alert('No hay suficiente stock.');
            }
        });
}

function restarCantidad(event) {
    var buttonClicked = event.target;
    var selector = buttonClicked.parentElement;
    var cantidadActual = parseInt(selector.getElementsByClassName('carrito-item-cantidad')[0].value);
    var item = buttonClicked.parentElement.parentElement.parentElement;
    var productoId = item.dataset.productoId;

    if (cantidadActual > 1) {
        fetch(`${base_url}cart/down&id=${productoId}`)
            .then(response => response.text())  // Convertimos la respuesta a texto
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Extraemos el valor del elemento con id 'response'
                const responseValue = doc.getElementById('response')?.value;
                console.log(responseValue);

                // Si responseValue es una cadena JSON, la convertimos a un objeto
                const data = responseValue ? JSON.parse(responseValue) : null;

                if (data && data.success) {
                    cantidadActual--;
                    unidades--;
                    selector.getElementsByClassName('carrito-item-cantidad')[0].value = cantidadActual;
                    actualizarTotalCarrito();
                }
            });
    } else if (cantidadActual == 1) {
        fetch(`${base_url}cart/deleteOne&id=${productoId}`)
            .then(response => response.text())  // Convertimos la respuesta a texto
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Extraemos el valor del elemento con id 'response'
                const responseValue = doc.getElementById('response')?.value;
                console.log(responseValue);

                // Si responseValue es una cadena JSON, la convertimos a un objeto
                const data = responseValue ? JSON.parse(responseValue) : null;

                if (data && data.success) {
                    item.remove();
                    unidades--;
                    actualizarTotalCarrito();
                    // ocultarCarrito();
                } else {
                    alert('Error al eliminar el producto del carrito.');
                }
            });
    }
}

function eliminarItemCarrito(event) {
    var buttonClicked = event.target;
    var item = buttonClicked.parentElement;
    var cantidadActual = parseInt(item.getElementsByClassName('carrito-item-cantidad')[0].value);
    var productoId = item.dataset.productoId;

    fetch(`${base_url}cart/deleteOne&id=${productoId}`)
        .then(response => response.text())  // Convertimos la respuesta a texto
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Extraemos el valor del elemento con id 'response'
            const responseValue = doc.getElementById('response')?.value;

            // Si responseValue es una cadena JSON, la convertimos a un objeto
            const data = responseValue ? JSON.parse(responseValue) : null;

            if (data && data.success) {
                item.remove();
                unidades = unidades - cantidadActual;
                actualizarTotalCarrito();
                // ocultarCarrito();
            } else {
                alert('Error al eliminar el producto del carrito.');
            }
        });
}

function ocultarCarrito() {
    var carritoItems = document.getElementsByClassName('carrito-items')[0];
    if (carritoItems.childElementCount == 0) {
        var carrito = document.getElementsByClassName('carrito')[0];
        carrito.style.marginRight = '-100%';
        carrito.style.opacity = '0';
        carritoVisible = false;
    }
}

function actualizarTotalCarrito() {
    var carritoContenedor = document.getElementsByClassName('carrito')[0];
    var carritoItems = carritoContenedor.getElementsByClassName('carrito-item');
    var carritoVacioMensaje = document.getElementById('carrito-vacio');
    console.log(unidades);
    if (unidades != 0 && carritoVacioMensaje != null) {
        carritoVacioMensaje.style.display = 'none';
    } else if (unidades == 0 && carritoVacioMensaje != null) {
        carritoVacioMensaje.style.display = 'block';
    }
    var total = 0;
    for (var i = 0; i < carritoItems.length; i++) {
        var item = carritoItems[i];
        var precioElemento = item.getElementsByClassName('carrito-item-precio')[0];
        var precio = parseFloat(precioElemento.innerText.replace('$', '').replace(' MXN', ''));
        var cantidadItem = item.getElementsByClassName('carrito-item-cantidad')[0];
        var cantidad = cantidadItem.value;
        total += (precio * cantidad);
    }

    document.getElementsByClassName('carrito-precio-total')[0].innerText = '$' + total.toFixed(2).toLocaleString("es") + " MXN";
}
