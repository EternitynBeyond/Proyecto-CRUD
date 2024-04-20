<?php
include '../modelo/conexion.php'; 

// Check if ID parameter is present in the POST data or URL
if(isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
} elseif(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "Invalid request.";
    exit();
}
    
// Query the database to retrieve data for the selected record
$stmt = $conexion->prepare("SELECT id, nombre, apellido, dni, fecha_nac, correo FROM personas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
    
// Check if record exists
if($result->num_rows > 0) {
    $datos = $result->fetch_assoc();
} else {
    echo "Record not found.";
    exit();
}

// Debugging: Print out received $_POST data
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"]; 
    $apellido = $_POST["apellido"]; 
    $dni = $_POST["dni"]; 
    $fecha_nac = $_POST["fecha_nac"]; 
    $correo = $_POST["correo"]; 
    $id = $_POST["id"]; // Ensure to retrieve the ID from the form

    // Prepare and bind the update statement
    $stmt = $conexion->prepare("UPDATE personas SET nombre=?, apellido=?, dni=?, fecha_nac=?, correo=? WHERE id=?");
    $stmt->bind_param("sssssi", $nombre, $apellido, $dni, $fecha_nac, $correo, $id);

    if ($stmt->execute()) {
        // Successful update
        $stmt->close(); // Close statement
        // Redirect back to index.php
        header("Location: index.php");
        exit(); // Ensure to stop script execution after redirect
    } else {
        // Error occurred during update
        echo "Error: " . $stmt->error;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Modificar persona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1 class="text-center">Modificar persona</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
            <form class="p-3" method="post" action="modificar.php"> 
    <input type="hidden" name="id" value="<?= $datos['id'] ?>">
    <div class="mb-3">
        <label for="exampleInputName" class="form-label">Nombre de la persona</label>
        <input type="text" class="form-control" id="exampleInputName" name="nombre" aria-describedby="nameHelp" value="<?= $datos['nombre'] ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputLname" class="form-label">Apellido de la persona</label>
        <input type="text" class="form-control" id="exampleInputLname" name="apellido" aria-describedby="nameHelp" value="<?= $datos['apellido'] ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputDNI" class="form-label">DNI de la persona</label>
        <input type="text" class="form-control" id="exampleInputDNI" name="dni" value="<?= $datos['dni'] ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputBirthdate" class="form-label">Fecha de nacimiento</label>
        <input type="date" class="form-control" id="exampleInputBirthdate" name="fecha_nac" value="<?= $datos['fecha_nac'] ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputemail" class="form-label">Correo</label>
        <input type="email" class="form-control" id="exampleInputemail" name="correo" value="<?= $datos['correo'] ?>">
    </div>       
    <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Guardar cambios</button>
</form>
            </div>
        </div>
    </div>
</body>
</html>
