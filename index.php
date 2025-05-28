<!DOCTYPE html>
<html>
<head>
    <title>Employee Directory</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            text-decoration: none;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>Employee Directory</h1>
    <p><a href="add_employee.php">Add New Employee</a></p>

    <?php
    require_once 'db_config.php';

    $sql = "SELECT id, first_name, last_name, email, department FROM employees";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Department</th><th>Actions</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["first_name"] . "</td>";
            echo "<td>" . $row["last_name"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["department"] . "</td>";
            echo "<td><a href='edit_employee.php?id=" . $row["id"] . "'>Edit</a> | <a href='delete_employee.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this employee?\")'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No employees found.";
    }

    $conn->close();
    ?>

</body>
</html>
