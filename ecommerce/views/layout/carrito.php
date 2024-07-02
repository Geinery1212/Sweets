<div class="col-12 col-md-6 col-lg-4 col-xl-4">
    <div class="row">
        <div class="carrito" id="carrito">
            <div class="header-carrito">
                <h2>Tu Carrito</h2>
            </div>

            <div class="carrito-items">
                <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1) : ?>
                    <?php foreach ($_SESSION['carrito'] as $indice => $elemento) : ?>
                        <div class="carrito-item" data-producto-id="<?= $elemento['id_producto'] ?>">
                            <?php if ($elemento['producto']->imagen != null) : ?>
                                <img src="<?= base_url ?>uploads/images/<?= $elemento['producto']->imagen ?>" width="80px" alt="<?= $elemento['producto']->imagen ?>" />
                            <?php else : ?>
                                <img src="<?= imagen_defecto ?>" width="80px" alt="<?= imagen_defecto ?>" />
                            <?php endif; ?>
                            <div class="carrito-item-detalles" id="item-carrito-<?= $elemento['producto']->id ?>">
                                <span class="carrito-item-titulo"><?= $elemento['producto']->nombre ?></span>
                                <div class="selector-cantidad">
                                    <i class="fa-solid fa-minus restar-cantidad"></i>
                                    <input type="text" value="<?= $elemento['unidades'] ?>" class="carrito-item-cantidad" disabled>
                                    <i class="fa-solid fa-plus sumar-cantidad"></i>
                                </div>
                                <span class="carrito-item-precio">$<?= $elemento['precio'] ?> MXN</span>
                            </div>
                            <button class="btn-eliminar">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p id="carrito-vacio">No hay productos en el carrito.</p>
                <?php endif; ?>


            </div>
            <div class="carrito-total">
                <?php $stats = Utils::statsCarrito(); ?>
                <div class="fila">
                    <strong>Tu Total</strong>
                    <span class="carrito-precio-total">
                        $<?= number_format($stats['total'], 2) ?> MXN
                    </span>
                </div>
                <button class="btn-pagar">Pagar <i class="fa-solid fa-bag-shopping"></i></button>
            </div>
        </div>
    </div>
</div>