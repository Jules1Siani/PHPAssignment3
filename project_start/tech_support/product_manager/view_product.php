<?php
// Include database connection
require('../model/database.php');

// Retrieve the list of products
$result = $db->query("SELECT * FROM products");

if (!$result) {
    die("Error retrieving products: " . $db->errorInfo()[2]);
}
?>

<?php include '../view/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>sportPro Technical Support</title>
</head>
<body>
    <h1>Product List</h1>
    <table border="1">
        <tr>
            <th>CODE</th>
            <th>Name</th>
            <th>Version</th>
            <th>Release Date</th>
            <th>Actions</th>
        </tr>
        <!-- Show list of products-->
        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['productCode']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['version']); ?></td>
            <td><?php 
                // Format the releaseDate to mm-dd-yyyy
                $releaseDate = new DateTime($row['releaseDate']);
                echo $releaseDate->format('n-j-Y'); // no leading zeros
            ?></td>
            <td>
                <a href="delete_product.php?productCode=<?php echo htmlspecialchars($row['productCode']); ?>" 
                   onclick="return confirm('Do you really want to delete this product?')">
                   Delete
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="add_product.php">Add Product</a>
</body>
</html>

<?php include '../view/footer.php'; ?>

