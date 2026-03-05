<?php
// ==========================================
// LÓGICA DE PROCESAMIENTO PHP Y CONEXIÓN
// ==========================================
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $base_datos = "htssprueba";

    $conn = new mysqli($servidor, $usuario, $password, $base_datos);

    if ($conn->connect_error) {
        $mensaje = "<script>alert('Error de conexión con la base de datos.');</script>";
    } else {
        $nombre = $_POST['nombre_completo'];
        $no_control = $_POST['no_control'];
        $correo = $_POST['correo'];
        $grado = $_POST['grado'];
        $grupo = $_POST['grupo'];

        if (!preg_match("/@cbtis171\.edu\.mx$/", $correo)) {
            $mensaje = "<script>alert('Error: Por favor usa tu correo institucional (@cbtis171.edu.mx)');</script>";
        } else {
            date_default_timezone_set('America/Mexico_City');
            $hora_inicio = date('Y-m-d H:i:s');

            $sql = "INSERT INTO registro_alumnos (nombre_completo, no_control, correo, grado, grupo, hora_inicio) 
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $nombre, $no_control, $correo, $grado, $grupo, $hora_inicio);

            if ($stmt->execute()) {
                // REDIRECCIÓN A index.html Y GUARDADO EN LOCALSTORAGE
                $mensaje = "<script>
                                alert('¡Registro completado y guardado!');
                                localStorage.setItem('tiene_cuenta', 'true');
                                localStorage.setItem('usuario_activo', '" . $no_control . "'); /* <-- ESTA ES LA LÍNEA CLAVE */
                                window.location.href = 'index.html';
                            </script>";
            } else {
                $mensaje = "<script>alert('Error al guardar en la base de datos: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | CBTIS 171</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        /* Fondo completamente negro */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #000000;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            color: #ffffff;
        }

        /* Estrellas blancas sin brillo exagerado */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            background-image: 
                radial-gradient(2px 2px at 20px 30px, #cccccc, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 40px 70px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 50px 160px, #aaaaaa, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 90px 40px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 130px 80px, #dddddd, rgba(0,0,0,0));
            background-repeat: repeat;
            background-size: 200px 200px;
            animation: twinkle 4s infinite alternate;
        }

        @keyframes twinkle {
            0% { opacity: 0.4; }
            100% { opacity: 0.9; }
        }

        /* Caja principal - Diseño plano */
        .login-box {
            position: relative;
            z-index: 1;
            background: #111111; /* Gris muy oscuro */
            border: 1px solid #333333; /* Borde gris */
            padding: 40px;
            border-radius: 8px; /* Bordes ligeramente redondeados */
            width: 350px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .login-box h2 {
            margin: 0 0 25px;
            text-align: center;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #ffffff; /* Blanco plano, sin sombras */
        }

        /* Contenedor de inputs */
        .user-box {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .user-box label {
            font-size: 13px;
            color: #aaaaaa; /* Gris claro */
            margin-bottom: 6px;
            font-weight: 500;
        }

        /* Nuevo diseño de los inputs: Cajas sólidas */
        .user-box input, .user-box select {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            color: #ffffff;
            background-color: #1a1a1a; /* Relleno gris oscuro */
            border: 1px solid #444444; /* Borde gris */
            border-radius: 4px;
            outline: none;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s, background-color 0.3s;
        }

        .user-box input:focus, .user-box select:focus {
            border-color: #ffffff; /* El borde se vuelve blanco al escribir */
            background-color: #222222;
        }

        /* Botón plano */
        .btn-submit {
            background: #ffffff; /* Botón blanco */
            color: #000000; /* Texto negro */
            border: none;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
            margin-top: 15px;
        }

        .btn-submit:hover {
            background: #cccccc; /* Se oscurece ligeramente al pasar el mouse */
        }
    </style>
</head>
<body>

    <?= $mensaje; ?>

    <div class="stars"></div>

    <div class="login-box">
        <h2>Registro</h2>
        <form action="" method="POST">
            
            <div class="user-box">
                <label>Nombre Completo</label>
                <input type="text" name="nombre_completo" required>
            </div>

            <div class="user-box">
                <label>No. de Control</label>
                <input type="text" name="no_control" required>
            </div>

            <div class="user-box">
                <label>Correo Institucional</label>
                <input type="email" name="correo" pattern=".*@cbtis171\.edu\.mx$" title="Debe terminar en @cbtis171.edu.mx" required>
            </div>

            <div style="display: flex; gap: 15px;">
                <div class="user-box" style="flex: 1;">
                    <label>Grado</label>
                    <select name="grado" required>
                        <option value="" disabled selected>Elige</option>
                        <option value="1">1ro</option>
                        <option value="2">2do</option>
                        <option value="3">3ro</option>
                        <option value="4">4to</option>
                        <option value="5">5to</option>
                        <option value="6">6to</option>
                    </select>
                </div>

                <div class="user-box" style="flex: 1;">
                    <label>Grupo</label>
                    <select name="grupo" required>
                        <option value="" disabled selected>Elige</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn-submit">Iniciar</button>
        </form>
    </div>

</body>
</html>