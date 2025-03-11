<?php
session_start();
//Inicialización del inventario
if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = ['milk' => 0, 'soft drink' => 0];
}
//Manejo de solicitudes POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Captura de datos del formulario
    $worker = $_POST['worker_name'] ?? '';
    $product = $_POST['product'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);


    //Acciones en el inventario
    if ($product && $quantity > 0) {
        if ($_POST['action'] == 'add') {
            $_SESSION['inventory'][$product] += $quantity;
        } elseif ($_POST['action'] == 'remove') {
            if ($_SESSION['inventory'][$product] >= $quantity) {
                $_SESSION['inventory'][$product] -= $quantity;
            } else {
                $error = "Error: No hay suficientes unidades disponibles para eliminar.";
            }
        }
    }

    // Reiniciar inventario
    if (isset($_POST['reset'])) {
        $_SESSION['inventory'] = ['milk' => 0, 'soft drink' => 0];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { font-size: 24px; font-weight: bold; }
        label, select, input, button { margin: 5px 0; }
        .inventory { margin-top: 15px; font-weight: bold; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Supermarket Management</h1>
    <form method="POST">
        <label>Nombre empleado: <input type="text" name="worker_name" value="<?php echo $_POST['worker_name'] ?? ''; ?>"></label>
        
        <h3>Escoge producto:</h3>
        <select name="product">
            <option value="soft drink">Bebida energética</option>
            <option value="milk">Leche</option>
        </select>
        
        <h3>Cantidad de producto:</h3>
        <input type="number" name="quantity" value="0">
        <br>
        <button type="submit" name="action" value="add">Añadir</button>
        <button type="submit" name="action" value="remove">Borrar</button>
        <button type="submit" name="reset" value="true">Reiniciar</button>
    </form>
    
    <div class="inventory">
        <p>Empleado: <span><?php echo $_POST['worker_name'] ?? ''; ?></span></p>
        <p>Unidades de leche: <span><?php echo $_SESSION['inventory']['milk']; ?></span></p>
        <p>Unidades de Bebida energética: <span><?php echo $_SESSION['inventory']['soft drink']; ?></span></p>
        <p class="error"><?php echo $error ?? ''; ?></p>
    </div>
</body>
</html>