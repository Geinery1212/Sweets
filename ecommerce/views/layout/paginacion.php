<section class="row paginacion">
    <div class="col-md-12">
        <ul>
            <?php if ($pagina_actual > 1) : ?>
                <li><a href="?pagina=<?= $pagina_actual - 1 ?>"><i class="fa-solid fa-backward"></i></a></li>
            <?php else : ?>
                <li class="disabled"><i class="fa-solid fa-backward"></i></li>
            <?php endif; ?>

            <?php
            for ($i = 1; $i <= $total_paginas; $i++) : ?>
                <?php if ($i == $pagina_actual) : ?>
                    <li class="active"><?= $i ?></li>
                <?php else : ?>
                    <li><a href="<?= pagination_url ?>?pagina=<?= $i ?>"><?= $i ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagina_actual < $total_paginas) : ?>
                <li><a href="<?= pagination_url ?>?pagina=<?= $pagina_actual + 1 ?>"><i class="fa-solid fa-forward"></i></a></li>
            <?php else : ?>
                <li class="disabled"><i class="fa-solid fa-forward"></i></li>
            <?php endif; ?>
        </ul>
    </div>
</section>