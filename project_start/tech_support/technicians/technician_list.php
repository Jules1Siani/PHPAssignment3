<?php
// Include database connection
require('../model/database.php');

// Retrieve the list of technicians
$result = $db->query("SELECT * FROM technicians");
?>

<?php include '../view/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>sportPro Technical Support</title>
</head>
<body>
    <h1>Technician List</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Password</th>
        </tr>
        <!-- Show list of technicians-->
        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $row['techID']; ?></td>
            <td><?php echo $row['firstName']; ?></td>
            <td><?php echo $row['lastName']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['password']; ?></td>
            <td>
              <a href=delete_technician.php?techID=<?php echo $row['techID']; ?>" 
                 onclick="return confirm('Do you really want to delete this technician?')">
                 Delete
               </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="add_technician.php">Add Technician</a>
</body>
</html>

<?php include '../view/footer.php'; ?>
