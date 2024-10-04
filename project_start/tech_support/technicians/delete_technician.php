<?php
// Include database connection
require('../model/database.php');

// Check if techID is passed as a query parameter
if (isset($_GET['techID'])) {
    $techID = $_GET['techID'];

    // Prepare and execute the deletion query
    $sql = "DELETE FROM technicians WHERE techID = :techID";
    $statement = $db->prepare($sql);
    $statement->bindValue(':techID', $techID, PDO::PARAM_INT);

    if ($statement->execute()) {
        // Redirect to the technician list page after successful deletion
        header('Location: technician_list.php?success=Technician deleted successfully');
        exit();
    } else {
        // Handle error if deletion fails
        echo "Error deleting technician.";
    }
} else {
    // If no techID is passed, redirect to the technician list
    header('Location: technician_list.php?error=No technician ID provided');
    exit();
}
?>


