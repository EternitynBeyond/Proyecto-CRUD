<?php
include 'modelo/conexion.php'; 

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"]; 
    $apellido = $_POST["apellido"]; 
    $dni = $_POST["dni"]; 
    $fecha_nac = $_POST["fecha_nac"]; 
    $correo = $_POST["correo"]; 

    // Prepare and bind the insert statement
    $stmt = $conexion->prepare("INSERT INTO personas (nombre, apellido, dni, fecha_nac, correo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $apellido, $dni, $fecha_nac, $correo);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close statement
}

// Selecting data from the database
$sql = $conexion->query("SELECT id, nombre, apellido, dni, fecha_nac, correo FROM personas");

// Check if the query was successful
if ($sql === false) {
    echo "Error: " . $conexion->error;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de personas</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
        <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form class="p-3" method="post" action="index.php"> 
                    <div class="mb-3">
                        <label for="exampleInputName" class="form-label">Nombre de la persona</label>
                        <input type="text" class="form-control" id="exampleInputName" name="nombre" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputLname" class="form-label">Apellido de la persona</label>
                        <input type="text" class="form-control" id="exampleInputLname" name="apellido" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputDNI" class="form-label">DNI de la persona</label>
                        <input type="text" class="form-control" id="exampleInputDNI" name="dni">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputBirthdate" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control" id="exampleInputBirthdate" name="fecha_nac">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputemail" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="exampleInputemail" name="correo">
                    </div>       
                    <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Registrar</button>
                </form>
            </div>
            <div class="col-md-8">
            <br></br>
                <h2 class="text-center">Listado de personas</h2>
                <br></br>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Fecha de nacimiento</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($sql !== false) {
                            $sql->data_seek(0); // Reset the pointer to the beginning of the result set
                            while ($datos = $sql->fetch_object()) { 
                        ?>
                        <tr>
                            <td><?= $datos->id ?></td>
                            <td><?= $datos->nombre ?></td>
                            <td><?= $datos->apellido ?></td>
                            <td><?= $datos->dni ?></td>
                            <td><?= $datos->fecha_nac ?></td>
                            <td><?= $datos->correo ?></td>
                            <td>
                                <a href="controlador/modificar.php?id=<?= $datos->id ?>" class="btn btn-small btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg></a>
                                <a href="controlador/eliminar.php?id=<?= $datos->id ?>" class="btn btn-small btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg></a> 
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "Error: Failed to retrieve data from the database";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
