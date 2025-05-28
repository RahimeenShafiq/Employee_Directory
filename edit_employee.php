<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }
        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Edit Employee</h1>

    <?php
    require_once 'db_config.php';

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        if (isset($_POST['update'])) {
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $department = $_POST['department'];
            $hireDate = $_POST['hire_date'];

            $sql = "UPDATE employees SET first_name=?, last_name=?, email=?, phone=?, department=?, hire_date=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $firstName, $lastName, $email, $phone, $department, $hireDate, $id);

            if ($stmt->execute()) {
                echo "<p style='color: green;'>Employee updated successfully!</p>";
            } else {
                echo "<p class='error'>Error updating employee: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }

        // Fetch employee data to populate the form
        $sql = "SELECT id, first_name, last_name, email, phone, department, hire_date FROM employees WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            ?>
            <form method="post" action="">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required><br><br>

                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required><br><br>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>

                <label for="phone">Phone:</label>
                <input type="text" name="phone" value="<?php echo $row['phone']; ?>"><br><br>

                <label for="department">Department:</label>
                <input type="text" name="department" value="<?php echo $row['department']; ?>"><br><br>

                <label for="hire_date">Hire Date:</label>
                <input type="date" name="hire_date" value="<?php echo $row['hire_date']; ?>"><br><br>

                <button type="submit" name="update">Update Employee</button>
            </form>
            <?php
        } else {
            echo "<p class='error'>Employee not found.</p>";
        }

        $stmt->close();
    } else {
        echo "<p class='error'>Invalid employee ID.</p>";
    }

    $conn->close();
    ?>

    <p><a href="index.php">Back to Employee List</a></p>
</body>
</html>
