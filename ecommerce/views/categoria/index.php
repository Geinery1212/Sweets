<?php if (isset($_SESSION['CategoriaControllerMessageSuccess'])) : ?>
    <script>
        toastr.success("<?php echo $_SESSION['CategoriaControllerMessageSuccess']; ?>");
    </script>
<?php elseif (isset($_SESSION['CategoriaControllerMessageError'])) : ?>
    <script>
        toastr.error("<?php echo $_SESSION['CategoriaControllerMessageError']; ?>");
    </script>
<?php endif; ?>
<?php
Utils::deleteSession('CategoriaControllerMessageSuccess');
Utils::deleteSession('CategoriaControllerMessageError');
?>

<div class="row titulo-seccion">
    <div class="col-md-12">
        <h3>Gestionar categorías</h3>
    </div>
</div>
<a href="<?= base_url ?>categoria/crear" class="button button-small main-button">
    Crear categoría
</a>

<div class="table-responsive">
    <table class="responsive-table table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cat = $categorias->fetch_object()) : ?>
                <tr>
                    <td data-label="ID"><?= $cat->id; ?></td>
                    <td data-label="NOMBRE"><?= $cat->nombre; ?></td>
                    <td data-label="ACCIONES">
                        <a href="<?= base_url ?>categoria/editar&id=<?= $cat->id ?>" class="button button-gestion"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="#" class="button button-gestion button-red" onclick="return confirmDeletion(<?= $cat->id ?>);"><i class="fa-solid fa-trash"></i></a>
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
                window.location.href = "<?= base_url ?>categoria/eliminar&id=" + id;
            }
        })
    }
</script>