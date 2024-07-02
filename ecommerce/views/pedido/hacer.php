<?php if (isset($_SESSION['identity'])) : ?>
    <div class="row titulo-seccion">
        <div class="col-md-12">
            <h3>Realizar pedido</h3>
        </div>
    </div>
    <div class="titulo-pagina">
        <h3>Domicilio para el envió</h3>
    </div>

    <form action="<?= base_url ?>Pedido/add" method="POST">
        <label for="municipio">Municipio</label>
        <input type="text" name="municipio" required>
        <label for="localidad">Localidad</label>
        <input type="text" name="localidad">
        <label for="direccion">Direccion (barrio, calle, numero interior y exterior )</label>
        <textarea name="direccion" required></textarea>
        <label for="referencia" name="referencia">Referencia</label>
        <input type="text" name="referencia">
        <label for="telefono" name="telefono">Número de teléfono </label>
        <input type="text" name="telefono">

        <button type="submit">
            Continuar
        </button>
    </form>
<?php else : ?>
    <h1>Necesitas iniciar sesión para proceder con tu compra.</h1>
<?php endif; ?>