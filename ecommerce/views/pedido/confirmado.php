<?php if (isset($_SESSION['pedido']) && $_SESSION['pedido'] === 'complete') : ?>
    <div class="row titulo-seccion">
        <div class="col-md-12">
            <h3>Detalle del pedido</h3>
        </div>
    </div>
    <?php if (isset($pedido)) : ?>
        <div class="info-section">
            <h3>Datos del pedido:</h3>
            <p>Número de pedido: <?= $pedido->id ?></p>
            <p>Total a pagar: $<?= number_format($pedido->coste, 2) ?> MXN</p>
        </div>
        <div class="info-section">
            <div class="table-responsive">
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
                                        <img src="<?= base_url ?>assets/imagenes/camiseta.png" alt="Imagen del producto" class="img_carrito">
                                    <?php endif; ?>
                                </td>
                                <td data-label="Nombre">
                                    <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre ?></a>
                                </td>
                                <td data-label="Precio">
                                    $<?= number_format($producto->precio, 2) ?>MXN
                                </td>
                                <td data-label="Unidades">
                                    <?= $producto->unidades ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
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
<?php elseif (isset($_SESSION['pedido']) && $_SESSION['pedido'] !== 'complete') : ?>
    <h1>Tu pedido no ha podido realizarse</h1>
<?php endif; ?>