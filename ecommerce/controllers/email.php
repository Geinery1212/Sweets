<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del pedido</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 100px;
        }

        h1 {
            color: rgb(255, 160, 122);
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
        }

        .header {
            text-align: center;
            padding: 10px;
            background-color: #fff3f0;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .establishment-name {
            font-size: 1.5em;
            color: rgb(255, 160, 122);
            margin: 0;
        }

        .order-details {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-table th,
        .order-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .order-table th {
            background-color: rgb(255, 160, 122);
            color: white;
        }

        .item-name {
            font-weight: bold;
        }

        .item-quantity,
        .item-price {
            text-align: center;
        }

        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 1.5em;
            font-weight: bold;
            color: rgb(255, 160, 122);
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .customer-info {
            margin-bottom: 20px;
            background-color: #fff3f0;
            padding: 10px;
            border-radius: 8px;
        }

        .info-label {
            font-weight: bold;
            color: rgb(255, 160, 122);
        }

        .message {
            margin-top: 20px;
            background-color: rgb(255, 160, 122);
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #888;
        }

        .footer a {
            color: rgb(255, 160, 122);
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://i.postimg.cc/pT2gRyh0/logo-tienda.png" alt="Logo" class="logo">
            <p class="establishment-name">Sweets</p>
            <h1>Detalles del pedido</h1>
        </div>

        <div class="customer-info">
            <p><span class="info-label">Nombre del cliente:</span> <?= $nombre_usuario ?></p>
            <p><span class="info-label">Número de orden:</span> #<?= $pedido->id ?></p>
        </div>

        <div class="order-details">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = $productos->fetch_object()) : ?>
                        <tr>
                            <td class="item-name"><?= $producto->nombre ?></td>
                            <td class="item-quantity"> <?= $producto->unidades ?></td>
                            <td class="item-price"><?= $producto->precio ?> MXN</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="total">
            Total: <?= $pedido->coste ?><small style="font-size: 12px !important;">MXN</small>
        </div>

        <div class="message">
            <p>¡Gracias por su orden! Apreciamos su negocio y esperamos que disfrute de su compra.</p>
        </div>

        <div class="footer">
            <p>Para cualquier consulta, por favor contacte <a href="mailto:Sweetss@gmail.com">Sweetss@gmail.com</a></p>
        </div>
    </div>
</body>

</html>