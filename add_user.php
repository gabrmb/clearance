<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kinapclearance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $fullName = $conn->real_escape_string($_POST['name']);
    $regNo = $conn->real_escape_string($_POST['RegistrationNo']);
    $department = $conn->real_escape_string($_POST['Department']);
    $email = $conn->real_escape_string($_POST['email']);
    $contact = $conn->real_escape_string($_POST['phoneNo']);
    $designation = $conn->real_escape_string($_POST['desig']);
    $userName = $conn->real_escape_string($_POST['uname']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirmPassword = $conn->real_escape_string($_POST['ConfirmPassword']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $role = "Undefined"; // Default role
    $accountStatus = "Inactive"; // Default account status

    // Check if password and confirm password match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert user data
    $sql = "INSERT INTO Users (FullName, RegNo, Department, Contact, Gender, Email, Role, Designation, UserName, Password, AccountStatus) 
            VALUES ('$fullName', '$regNo', '$department', '$contact', '$gender', '$email', '$role', '$designation', '$userName', '$hashedPassword', '$accountStatus')";

    // Execute the query and check for errors
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Form not submitted properly.";
}

?>
