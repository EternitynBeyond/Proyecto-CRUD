<?php
include 'modelo/conexion.php'; 

// Selecting data from the database
$sql = $conexion->query("SELECT id, nombre, apellido, dni, fecha_nac, correo FROM personas");

// Check if the query was successful
if ($sql === false) {
    echo "Error: " . $conexion->error;
} else {
    // Fetch the results
    while ($datos = $sql->fetch_object()) {
        // Output the data in your HTML table
        // ...
    }
}

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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de personas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1 class="text-center">Taller CRUD - Registro</h1>
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
                <h2 class="text-center">Listado de personas</h2>
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
                                <a href="modificar.php?id=<?= $datos->id ?>" class="btn btn-small btn-warning">Modificar</a> 
                                <a href="eliminar.php?id=<?= $datos->id ?>" class="btn btn-small btn-danger">Eliminar</a> 
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
