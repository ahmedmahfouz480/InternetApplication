<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add student
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $sql = "INSERT INTO students (name, age, email) VALUES ('$name', '$age', '$email')";
    $conn->query($sql);
}

// Delete student
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM students WHERE id=$id";
    $conn->query($sql);
}

// Update student
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $sql = "UPDATE students SET name='$name', age='$age', email='$email' WHERE id=$id";
    $conn->query($sql);
}

// Fetch all students
$students = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Student Management</title>
</head>
<body>
    <div class="container">
        <h1>Student Management</h1>
        
        <!-- Add Student Form -->
        <form method="POST" class="form">
            <input type="hidden" name="id" value="">
            <input type="text" name="name" placeholder="Name" required>
            <input type="number" name="age" placeholder="Age" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit" name="add">Add Student</button>
        </form>

        <!-- Students Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $students->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" class="delete">Delete</a>
                        <a href="#edit" onclick="editStudent(<?= $row['id'] ?>, '<?= $row['name'] ?>', <?= $row['age'] ?>, '<?= $row['email'] ?>')" class="edit">Edit</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Edit Student Form -->
        <form method="POST" class="form" id="editForm" style="display: none;">
            <input type="hidden" name="id" id="editId">
            <input type="text" name="name" id="editName" placeholder="Name" required>
            <input type="number" name="age" id="editAge" placeholder="Age" required>
            <input type="email" name="email" id="editEmail" placeholder="Email" required>
            <button type="submit" name="update">Update Student</button>
        </form>
    </div>

    <script>
        function editStudent(id, name, age, email) {
            document.getElementById('editForm').style.display = 'block';
            document.getElementById('editId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editAge').value = age;
            document.getElementById('editEmail').value = email;
        }
    </script>
</body>
</html>
