<?php if (isset($gestion)) : ?>
    <div class="row titulo-seccion">
        <div class="col-md-12">
            <h3>Gestionar pedidos</h3>
        </div>
    </div>
<?php else : ?>
    <div class="row titulo-seccion">
        <div class="col-md-12">
            <h3>Mis pedidos</h3>
        </div>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="responsive-table table">
        <thead>
            <tr>
                <th>No Pedido</th>
                <th>Coste</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($ped = $pedidos->fetch_object()) : ?>
                <tr>
                    <td data-label="No Pedido">
                        <a href="<?= base_url ?>pedido/detalle&id=<?= $ped->id ?>">
                            <?= $ped->id ?>
                        </a>
                    </td>
                    <td data-label="Coste">
                        $<?= number_format($ped->coste, 2) ?> MXN
                    </td>
                    <td data-label="Fecha">
                        <?= $ped->fecha ?>
                    </td>
                    <td data-label="Estado">
                        <?= Utils::showStatus($ped->estado) ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>