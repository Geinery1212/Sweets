<?php if (isset($_SESSION['UserControllerMessageSuccess'])) : ?>
    <script>
        toastr.success("<?php echo $_SESSION['UserControllerMessageSuccess']; ?>");
    </script>
<?php endif; ?>
<?php
Utils::deleteSession('UserControllerMessageSuccess');
?>
<div class="row titulo-seccion">
    <div class="col-md-12">
        <h3>|D U L C E S|</h3>
    </div>
</div>
<?php if ($productos != false) : ?>
    <section class="row productos">
        <div class="col-12 col-md-6 col-lg-8 col-xl-8">
            <div class="row">
                <?php while ($producto = $productos->fetch_object()) : ?>
                    <article class="col-12 col-md-6 col-lg-6 col-xl-4 producto">
                        <div class="contenedor" data-producto-id="<?= $producto->id ?>">
                            <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>">
                                <h2 class="titulo"><?= $producto->nombre ?></h2>
                                <div class="thumb">
                                    <?php if ($producto->imagen != null) : ?>
                                        <img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" class="imagen-producto" alt="Imagen del producto">
                                    <?php else : ?>
                                        <img src="<?= imagen_defecto ?>" class="imagen-producto" alt="Imagen del producto">
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="info">
                                <h3 class="precio">$<?= number_format($producto->precio, 2) ?> MXN</h3>
                                <div class="opciones">
                                    <!-- <a href="<?= base_url ?>carrito/add&id=<?= $producto->id ?>" class="comprar">Agregar al carrito</a> -->
                                    <button href="#" class="comprar">Agregar al carrito</button>
                                </div>
                            </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php require 'ecommerce/views/layout/paginacion.php'; ?>
        </div>
        <?php require 'ecommerce/views/layout/carrito.php'; ?>
    </section>

<?php else : ?>
    <div class="row titulo-seccion">
        <div class="col-md-12">
            <h3>Lo sentimos, sin resultados en la búsqueda</h3>
        </div>
    </div>
<?php endif; ?>