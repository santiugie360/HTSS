<?php
// Validar que se reciba el número de control y la materia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['no_control']) && isset($_POST['materia'])) {
    
    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $base_datos = "htssprueba";

    $conn = new mysqli($servidor, $usuario, $password, $base_datos);

    if ($conn->connect_error) {
        die("Error de conexión");
    }

    $no_control = $_POST['no_control'];
    $materia = $_POST['materia']; // Recibimos si es 'js', 'css' o 'html'

    // Elegir la columna correcta de forma segura
    $columna_bd = "";
    if ($materia === 'js') {
        $columna_bd = "temas_completados_js";
    } elseif ($materia === 'css') {
        $columna_bd = "temas_completados_css";
    } elseif ($materia === 'html') {
        $columna_bd = "temas_completados_html";
    } else {
        die("Error: Materia no válida"); // Por seguridad
    }

    // Preparar el SQL con la columna correcta
    $sql = "UPDATE registro_alumnos SET $columna_bd = $columna_bd + 1 WHERE no_control = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $no_control);
    
    if ($stmt->execute()) {
        echo "Exito";
    } else {
        echo "Error";
    }

    $stmt->close();
    $conn->close();
}
?>