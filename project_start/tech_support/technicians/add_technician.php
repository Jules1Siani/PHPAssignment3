<?php
// Include database connection
require('../model/database.php');

$firstName = $lastName = $email = $phone = $password = "";
$error = "";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Securing inputs with filter_input()
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Using prepared statements to avoid SQL injection
        $sql = "INSERT INTO technicians (firstName, lastName, email, phone, password) 
                VALUES (:firstName, :lastName, :email, :phone, :password)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':phone', $phone);
        $statement->bindValue(':password', $password);  // Store password directly (no hashing)

        // Execute the query
        if ($statement->execute()) {
            header('Location: technician_list.php?success=Technician added successfully');
            exit();
        } else {
            $error = "Error adding technician.";
        }
    }
}
?>

<?php include '../view/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add a Technician</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>
    <h1>Add a Technician</h1>

    <!--  Show error messages-->
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="add_technician.php" method="POST">
        <label for="firstName">First Name:</label><br>
        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>"><br>

        <label for="lastName">Last Name:</label><br>
        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>"><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>"><br>

        <label for="password">Password:</label><br>
        <input type="text" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>"><br><br>

        <input type="submit" value="Add Technician">
    </form>

    <br>
    <a href="technician_list.php">Technician List</a>
</body>
</html>

<?php include '../view/footer.php'; ?>



