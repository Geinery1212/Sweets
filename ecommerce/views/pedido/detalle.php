<?php if (isset($_SESSION['PedidoControllerMessageSuccess'])) : ?>
    <script>
        toastr.success("<?php echo $_SESSION['PedidoControllerMessageSuccess']; ?>");
    </script>
<?php elseif (isset($_SESSION['PedidoControllerMessageError'])) : ?>
    <script>
        toastr.error("<?php echo $_SESSION['PedidoControllerMessageError']; ?>");
    </script>
<?php elseif (isset($_SESSION['pago']) && $_SESSION['pago'] === 'APPROVED') : ?>
    <script>
        toastr.success('¡Pago exitoso! ');
    </script>
<?php endif; ?>
<?php
Utils::deleteSession('PedidoControllerMessageSuccess');
Utils::deleteSession('PedidoControllerMessageError');
Utils::deleteSession('pago');
?>

<div class="row titulo-seccion">
    <div class="col-md-12">
        <h3>Detalle del pedido</h3>
    </div>
</div>
<?php if (isset($pedido)) : ?>
    <?php if (isset($_SESSION['admin'])) : ?>
        <h3>Cambiar el estado del pedido</h3>
        <form action="<?= base_url ?>pedido/estado" method="POST">
            <input type="hidden" value="<?= $pedido->id ?>" name="pedido_id">
            <select name="estado">
                <option value="confirm" <?= $pedido->estado == 'confirm' ? 'selected' : '' ?>>Pendiente</option>
                <option value="preparation" <?= $pedido->estado == 'preparation' ? 'selected' : '' ?>>En preparacion</option>
                <option value="ready" <?= $pedido->estado == 'ready' ? 'selected' : '' ?>>Preparado</option>
                <option value="sended" <?= $pedido->estado == 'sended' ? 'selected' : '' ?>>Enviado</option>
            </select>
            <button type="submit">
                <i class="fa-solid fa-floppy-disk"></i>
            </button>
        </form>
        <br>
    <?php endif; ?>
    <div class="info-section">
        <h3>Datos del usuario</h3>
        <p><b>Nombre:</b> <?= $pedido->nombre ?></p>
        <p><b>Correo:</b> <?= $pedido->email ?></p>
        <p><b>Telefono:</b> <?= $pedido->numeroTel ?></p>
    </div>

    <div class="info-section">
        <h3>Direccion del envio</h3>
        <p><b>Municipio:</b> <?= $pedido->municipio ?></p>
        <p><b>Localidad:</b> <?= $pedido->localidad ?></p>
        <p><b>Direccion:</b> <?= $pedido->direccion ?></p>
        <p><b>Referencia:</b> <?= $pedido->referencia ?></p>
    </div>

    <div class="info-section">
        <h3>Datos del pedido</h3>
        <p><b>Número de pedido:</b> <?= $pedido->id ?></p>
        <p><b>Total a pagar:</b> $<?= number_format($pedido->coste, 2) ?> MXN</p>
    </div>

    <div class="table-responsive info-section">
        <table class="responsive-table table">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Unidades</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = $productos->fetch_object()) : ?>
                    <tr>
                        <td data-label="Imagen">
                            <?php if ($producto->imagen != null) : ?>
                                <img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" alt="Imagen del producto" class="img_carrito">
                            <?php else : ?>
                                <img src="<?= imagen_defecto ?>" alt="Imagen del producto" class="img_carrito">
                            <?php endif; ?>
                        </td>
                        <td data-label="Nombre">
                            <a href="<?= base_url ?>/producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre ?></a>
                        </td>
                        <td data-label="Precio">
                            $<?= number_format($producto->precio, 2) ?> MXN
                        </td>
                        <td data-label="Unidades">
                            <?= $producto->unidades ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>


<?php elseif (isset($_SESSION['pedido']) && $_SESSION['pedido'] != 'complete') : ?>
    <h1>Tu pedido No ha podido realizarce</h1>
<?php endif; ?>

<?php if (isset($pedido) && $pedido->estado == 'confirm') : ?>
    <div id="paypal-box-commerce">
        <div id="paypal-button-container">
            <h4>Se requiere el pago para iniciar el procesamiento de su pedido.</h4>
        </div>
    </div>
<?php endif; ?>

<script>
    paypal.Buttons({
        style: {
            layout: 'vertical',
            color: 'gold',
            shape: 'rect',
            label: 'paypal'
        },
        createOrder: (data, actions) => {
            return actions.order.create({
                purchase_units: [{
                    description: 'Compra en FarmaPlus',
                    amount: {
                        currency_code: 'MXN',
                        value: <?= json_encode($pedido->coste) ?>
                    },
                }]
            });
        },
        onApprove: (data, actions) => {
            window.location.href = <?= json_encode(base_url . "pedido/pagoCompletado&paymentID=") ?> + data.paymentID + <?= json_encode("&pedido_id=" . $pedido->id) ?>;
        },
        onCancel: (data, actions) => {
            alert('Cancelado :(');
        }
    }).render('#paypal-button-container');
</script>