<?php
require_once 'db_config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM employees WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=Employee deleted successfully");
        exit();
    } else {
        echo "Error deleting employee: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid employee ID.";
}

$conn->close();
?>
