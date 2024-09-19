<?php
// Database connection
$servername = "localhost";
$username = "root"; // Adjust to your DB username
$password = ""; // Adjust to your DB password
$dbname = "kinapclearance"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staffName = $conn->real_escape_string($_POST['StaffName']);
    $employeeNo = $conn->real_escape_string($_POST['EmployeeNo']);
    $department = $conn->real_escape_string($_POST['Department']);
    $email = $conn->real_escape_string($_POST['Email']);

    // Check if the employee already exists
    $checkQuery = "SELECT * FROM Staff WHERE EmployeeNo = '$employeeNo'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Employee exists, perform update
        $updateQuery = "UPDATE Staff 
                        SET Fullname = '$staffName', Department = '$department', Email = '$email'
                        WHERE EmployeeNo = '$employeeNo'";
        
        if ($conn->query($updateQuery) === TRUE) {
            echo "<script>alert('Your account has been updated successfully. Continue to approve clearances.'); 
                    window.location.href='Approval.php';
                  </script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Employee doesn't exist, insert new record
        $insertQuery = "INSERT INTO Staff (EmployeeNo, Fullname, Department, Email)
                        VALUES ('$employeeNo', '$staffName', '$department', '$email')";
        
        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>alert('Your account has been created successfully. Continue to approve clearances.'); 
                    window.location.href='Approval.php';
                   </script>";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
