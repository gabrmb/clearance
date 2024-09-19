<?php
if (isset($_GET['RequestID'])) {
    // Get the RequestID from the query string
    $requestID = $_GET['RequestID'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'kinapclearance');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the DELETE query
    $sql = "DELETE FROM clearancerequests WHERE RequestID = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the RequestID parameter to the query
        $stmt->bind_param("i", $requestID);

        // Execute the statement
        if ($stmt->execute()) {
            // If deletion is successful, redirect to SubmitClearance.php
            header("Location: SubmitClearance.php?message=deleted");
            exit(); // Ensure the script stops after redirection
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "No RequestID specified.";
}
?>
