<?php if (isset($_SESSION['ProductoControllerMessageSuccess'])) : ?>
    <script>
        toastr.success("<?php echo $_SESSION['ProductoControllerMessageSuccess']; ?>");
    </script>
<?php elseif (isset($_SESSION['ProductoControllerMessageError'])) : ?>
    <script>
        toastr.error("<?php echo $_SESSION['ProductoControllerMessageError']; ?>");
    </script>
<?php endif; ?>
<?php
Utils::deleteSession('ProductoControllerMessageSuccess');
Utils::deleteSession('ProductoControllerMessageError');
?>

<div class="row titulo-seccion">
    <div class="col-md-12">
        <h3>Gestión de productos</h3>
    </div>
</div>
<a href="<?= base_url ?>producto/crear" class="button button-small main-button">
    Crear producto
</a>
<div class="table-responsive">
    <table class="responsive-table table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>PRECIO</th>
                <th>STOCK</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($pro = $productos->fetch_object()) : ?>
                <tr>
                    <td data-label="ID"><?= $pro->id; ?></td>
                    <td data-label="NOMBRE"><?= $pro->nombre; ?></td>
                    <td data-label="PRECIO">$<?= number_format($pro->precio, 2); ?> MXN</td>
                    <td data-label="STOCK"><?= $pro->stock; ?></td>
                    <td data-label="ACCIONES">
                        <!--AL SER EL TERCER PARAMETRO GET DEBE SER CON &-->
                        <a href="<?= base_url ?>producto/editar&id=<?= $pro->id ?>" class="button button-gestion"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="#" class="button button-gestion button-red" onclick="return confirmDeletion(<?= $pro->id ?>);"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    function confirmDeletion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url ?>producto/eliminar&id=" + id;
            }
        })
    }
</script>