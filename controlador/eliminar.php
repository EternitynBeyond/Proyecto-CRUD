<?php
// Include the database connection file
include '../modelo/conexion.php';

// Check if the ID parameter is set in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize and validate the ID parameter
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if ($id === false) {
        die("Invalid ID");
    }

    // Prepare and bind the delete statement
    $stmt = $conexion->prepare("DELETE FROM personas WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the delete statement
    if ($stmt->execute()) {
        // Redirect to index.php after successful deletion
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close statement
} else {
    // Redirect to index.php if ID parameter is missing
    header("Location: ../index.php");
    exit();
}
?>
