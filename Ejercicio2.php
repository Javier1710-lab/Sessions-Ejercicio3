<?php
session_start();

// Inicialización del arreglo de números
if (!isset($_SESSION['numbers'])) {
    $_SESSION['numbers'] = [10, 20, 30];
}

//solicitudes POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Modificar un número en el arreglo
    if (isset($_POST['modify'])) {
        $position = $_POST['position'];
        $newValue = $_POST['new_value'];

        if (is_numeric($newValue) && isset($_SESSION['numbers'][$position])) { //calculo
            $_SESSION['numbers'][$position] = (int)$newValue; //aqui se actualiza el array
        }
    }

   // Calcular el promedio
    if (isset($_POST['average'])) { //promedio
        $average = array_sum($_SESSION['numbers']) / count($_SESSION['numbers']); //calculo
    }

   // Restablecer los valores originales
    if (isset($_POST['reset'])) { // boton del reset
        $_SESSION['numbers'] = [10, 20, 30]; // valores predeterminados
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Array en Sesión</title>
</head>
<body>
    <h2>Modify array saved in session</h2>

    <form method="post">
        <label for="position">Posicion a modificar:</label>
        <select name="position">
            <?php
            for ($i = 0; $i < count($_SESSION['numbers']); $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="new_value">Nuevo valor:</label>
        <input type="text" name="new_value">
        <br><br>
        
        <button type="submit" name="modify">Modifica</button>
        <button type="submit" name="average">Promedio</button>
        <button type="submit" name="reset">Reiniciar</button>
    </form>

    <p>Actual Array: <?php echo implode(", ", $_SESSION['numbers']); ?></p>

    <?php
    if (isset($average)) {
        echo "<p>Average value: " . number_format($average, 2) . "</p>";
    }
    ?>

</body>
</html>