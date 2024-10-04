<?php
// Include database connection
require('../model/database.php');

$productCode = $name = $version = $releaseDate = "";
$error = "";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Secure inputs with filter_input()
    $productCode = filter_input(INPUT_POST, 'productCode', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $version = filter_input(INPUT_POST, 'version', FILTER_VALIDATE_FLOAT);
    $releaseDate = filter_input(INPUT_POST, 'releaseDate', FILTER_SANITIZE_STRING);

    // Validate that all fields are filled
    if (empty($productCode) || empty($name) || empty($version) || empty($releaseDate)) {
        $error = "All fields are required.";
    } else {
        // Attempt to create a DateTime object from various formats
        $date = DateTime::createFromFormat('m/d/Y', $releaseDate) 
            ?: DateTime::createFromFormat('m-d-Y', $releaseDate) 
            ?: DateTime::createFromFormat('Y-m-d', $releaseDate) 
            ?: DateTime::createFromFormat('Y/m/d', $releaseDate) 
            ?: DateTime::createFromFormat('n/j/Y', $releaseDate) 
            ?: DateTime::createFromFormat('n-j-Y', $releaseDate); 

        // Check if the date is valid
        if ($date === false) {
            $error = "Invalid date format. Please use a standard date format.";
        } else {
            // Convert to 'Y-m-d' for database storage
            $releaseDate = $date->format('Y-m-d');

            // Using prepared statements to avoid SQL injection
            $sql = "INSERT INTO products (productCode, name, version, releaseDate) 
                    VALUES (:productCode, :name, :version, :releaseDate)";
            $statement = $db->prepare($sql);
            $statement->bindValue(':productCode', $productCode);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':version', $version);
            $statement->bindValue(':releaseDate', $releaseDate);

            // Execute the query
            if ($statement->execute()) {
                header('Location: view_product.php?success=Product added successfully');
                exit();
            } else {
                $error = "Error adding product.";
            }
        }
    }
}
?>

<?php include '../view/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add a Product</title>
    <link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>
    <h1>Add a Product</h1>

    <!-- Show error messages-->
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="add_product.php" method="POST">
        <label for="productCode">Code:</label><br>
        <input type="text" id="productCode" name="productCode" value="<?php echo htmlspecialchars($productCode); ?>"><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"><br>

        <label for="version">Version:</label><br>
        <input type="text" id="version" name="version" value="<?php echo htmlspecialchars($version); ?>"><br>

        <label for="releaseDate">Release Date:</label><br>
        <input type="text" id="releaseDate" name="releaseDate" value="<?php echo htmlspecialchars($releaseDate); ?>"><br><br>

        <input type="submit" value="Add Product">
    </form>

    <br>
    <a href="view_product.php">Product List</a>
</body>
</html>

<?php include '../view/footer.php'; ?>
