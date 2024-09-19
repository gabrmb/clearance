<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'kinapclearance');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'regNo' is passed as a parameter
if (isset($_GET['regNo'])) {
    $regNo = $_GET['regNo'];

    // Fetch the user data by RegNo
    $sql = "SELECT * FROM Users WHERE RegNo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $regNo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Fetch the user data
        $userData = $result->fetch_assoc();

        // Insert the user data into 'deletedusers' table
        $sql_insert = "INSERT INTO deletedusers (UserID, FullName, RegNo, Department, Contact, Gender, Email, Role, Designation, UserName, AccountStatus)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param(
            "issssssssss",
            $userData['UserID'], 
            $userData['FullName'], 
            $userData['RegNo'], 
            $userData['Department'], 
            $userData['Contact'], 
            $userData['Gender'], 
            $userData['Email'], 
            $userData['Role'], 
            $userData['Designation'], 
            $userData['UserName'], 
            $userData['AccountStatus']
        );

        // Execute the insertion
        if ($stmt_insert->execute()) {
            // If data is successfully inserted, delete the user from 'Users' table
            $sql_delete = "DELETE FROM Users WHERE RegNo = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("s", $regNo);
            
            if ($stmt_delete->execute()) {
                // Success message
                echo "<script>alert('User account deleted successfully.'); window.location.href = 'UsersList.php';</script>";
            } else {
                // Error deleting the user
                echo "<script>alert('Error deleting user account. Please try again.'); window.location.href = 'UsersList.php';</script>";
            }
        } else {
            // Error inserting into deletedusers
            echo "<script>alert('Error moving user data to deletedusers. Please try again.'); window.location.href = 'UsersList.php';</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not found.'); window.location.href = 'UsersList.php';</script>";
    }
} else {
    // If no regNo parameter is passed, redirect to users list
    echo "<script>alert('No user selected.'); window.location.href = 'UsersList.php';</script>";
}
?>
