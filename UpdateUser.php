<?php
if (isset($_POST['submit'])) {
    // Retrieve form data
    $Gender = $_POST['gender'];

    // Check if Gender is valid
    if ($Gender === "") {
        echo "Please select a valid gender.";
        exit;
    }
}

// Database connection
$servername = "localhost"; // Change if necessary
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "kinapclearance"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $FullName = $_POST['FullName'];
    $RegNo = $_POST['AdmEmployeeNo'];
    $Department = $_POST['department'];
    $Contact = $_POST['contact'];
    $Gender = $_POST['gender'];
    $Email = $_POST['email'];
    $Role = $_POST['role'];
    $Designation = $_POST['designation'];
    $UserName = $_POST['Username'];
    $Password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypting the password
    $AccountStatus = 'Inactive';

    // Check for duplicates
    $checkQuery = "SELECT * FROM Users WHERE UserName = ? OR Email = ? OR RegNo = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("sss", $UserName, $Email, $RegNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "A user with the same username, email, or registration number already exists.";
    } else {
        // Insert data into the Users table
        $sql = "INSERT INTO Users (FullName, RegNo, Department, Contact, Gender, Email, Role, Designation, UserName, Password, AccountStatus)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssss", $FullName, $RegNo, $Department, $Contact, $Gender, $Email, $Role, $Designation, $UserName, $Password, $AccountStatus);

        if ($stmt->execute()) {
            echo "User details added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>
