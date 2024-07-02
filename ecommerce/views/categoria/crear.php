<?php if (isset($edit) && isset($cat) && is_object($cat)) : ?>
    <div class="row titulo-seccion">
        <div class="col-md-12">
            <h3>Editar Categoría <?= $cat->nombre ?></h3>
        </div>
    </div>
    <?php $url_action = base_url . "categoria/save&id=" . $cat->id; ?>
<?php else : ?>
    <div class="row titulo-seccion">
        <div class="col-md-12">
            <h3>Crear Categoría</h3>
        </div>
    </div>
    <?php $url_action = base_url . "categoria/save"; ?>
<?php endif; ?>

<form action="<?= $url_action ?>" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" value="<?= isset($cat) && is_object($cat) ? $cat->nombre : '' ?>" required />

    <button type="submit">
        <i class="fa-solid fa-floppy-disk"></i>
    </button>
</form>