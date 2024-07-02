<?php if (isset($edit) && isset($pro) && is_object($pro)) : ?>
    <div class="row titulo-seccion">
        <div class="col-md-12">
            <h3>Editar producto <?= $pro->nombre ?></h3>
        </div>
    </div>
    <?php $url_action = base_url . "producto/save&id=" . $pro->id; ?>
<?php else : ?>
    <div class="row titulo-seccion">
        <div class="col-md-12">
            <h3>Crear nuevos productos</h3>
        </div>
    </div>
    <?php $url_action = base_url . "producto/save"; ?>
<?php endif; ?>

<!--enctype="multipart/form-data" para enviar ficheros por el formulario-->
<div class="form_container">
    <form action="<?= $url_action ?>" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?= isset($pro) && is_object($pro) ? $pro->nombre : '' ?>" />

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion"> <?= isset($pro) && is_object($pro) ? $pro->descripcion : '' ?>
        </textarea>

        <label for="precio">Precio</label>
        <input type="text" name="precio" value="<?= isset($pro) && is_object($pro) ? $pro->precio : '' ?>" />

        <label for="stock">Stock</label>
        <input type="number" name="stock" value="<?= isset($pro) && is_object($pro) ? $pro->stock : '' ?>" />

        <label for="categoria">Categoria</label>
        <?php $categorias = Utils::showCategorias(); ?>
        <select name="categoria">
            <?php while ($cat = $categorias->fetch_object()) : ?>
                <option value="<?= $cat->id ?>" <?= isset($pro) && is_object($pro) && $cat->id == $pro->categoria_id ? 'selected' : '' ?>>
                    <?= $cat->nombre ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="imagen">Imagen</label>
        <?php if (isset($pro) && is_object($pro) && !empty($pro->imagen)) : ?>
            <img src="<?= base_url ?>/uploads/images/<?= $pro->imagen ?>" class="thumb editar" />
        <?php endif; ?>
        <input type="file" name="imagen" />

        <button type="submit">
            <i class="fa-solid fa-floppy-disk"></i>
        </button>
    </form>
</div>