<?php
include 'funciones_tienda.php';

$productos = [
    'camisa' => 50,
    'pantalon' => 70,
    'zapatos' => 80,
    'calcetines' => 10,
    'gorra' => 25
];

$carrito = [
    'camisa' => 2,
    'pantalon' => 1,
    'zapatos' => 1,
    'calcetines' => 3,
    'gorra' => 0
];

$subtotal = 0;
foreach ($carrito as $producto => $cantidad) {
    if ($cantidad > 0) {
        $subtotal += $productos[$producto] * $cantidad;
    }
}

$descuento = calcular_descuento($subtotal);
$impuesto = aplicar_impuesto($subtotal);
$total = calcular_total($subtotal, $descuento, $impuesto);

?>
<html>
<head>
    <title>Resumen de Compra</title>
</head>
<body>
    <h1>Resumen de Compra</h1>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
        </tr>
        <?php foreach ($carrito as $producto => $cantidad) : ?>
            <?php if ($cantidad > 0) : ?>
                <tr>
                    <td><?php echo ucfirst($producto); ?></td>
                    <td><?php echo $cantidad; ?></td>
                    <td>$<?php echo number_format($productos[$producto], 2); ?></td>
                    <td>$<?php echo number_format($productos[$producto] * $cantidad, 2); ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>

    <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
    <p>Descuento: $<?php echo number_format($descuento, 2); ?></p>
    <p>Impuesto (7%): $<?php echo number_format($impuesto, 2); ?></p>
    <p>Total a pagar: $<?php echo number_format($total, 2); ?></p>
</body>
</html>
