<!DOCTYPE html>
<html>
<head>
    <title>Add New Employee</title>
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
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Add New Employee</h1>

    <?php
    if (isset($_POST['submit'])) {
        require_once 'db_config.php';

        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $department = $_POST['department'];
        $hireDate = $_POST['hire_date'];

        $sql = "INSERT INTO employees (first_name, last_name, email, phone, department, hire_date)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $phone, $department, $hireDate);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Employee added successfully!</p>";
        } else {
            echo "<p class='error'>Error adding employee: " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <form method="post" action="">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone"><br><br>

        <label for="department">Department:</label>
        <input type="text" name="department"><br><br>

        <label for="hire_date">Hire Date:</label>
        <input type="date" name="hire_date"><br><br>

        <button type="submit" name="submit">Add Employee</button>
    </form>

    <p><a href="index.php">Back to Employee List</a></p>
</body>
</html>
