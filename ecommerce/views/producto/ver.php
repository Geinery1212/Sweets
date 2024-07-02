<?php if (isset($product)) : ?>
    <div class="row titulo-seccion">
        <div class="col-md-12">
            <h3><?= $product->nombre ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-8 col-xl-8">
            <div class="row" id="detail-product" data-producto-id="<?= $product->id ?>">
                <div class="image">
                    <?php if ($product->imagen != null) : ?>
                        <img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
                    <?php else : ?>
                        <img src="<?= imagen_defecto ?>" />
                    <?php endif; ?>
                </div>
                <div class="data">
                    <p class="description"><?= $product->descripcion ?></p>
                    <p class="price">$<?= number_format($product->precio, 2) ?> MXN</p>
                    <div class="opciones">
                        <button class="comprar button-general-color">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php require 'ecommerce/views/layout/carrito.php'; ?>
    </div>
<?php else : ?>
    <h1>El producto no existe</h1>
<?php endif; ?>