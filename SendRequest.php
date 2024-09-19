<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kinapclearance"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $studentAdmNo = $_POST['studentAdmNo'];
    $studentName = $_POST['StudentName'];
    $department = $_POST['role'];  // Correct field name to 'department'
    $contact = $_POST['contact'];
    $course = $_POST['role'];  // Correct field name to 'course'
    $email = $_POST['email'];
    $clearanceType = $_POST['clearanceType'];

    // Handle file upload
    $documentPath = '';
    if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] == 0) {
        $targetDir = "uploads/"; // Define your upload directory
        $documentPath = $targetDir . basename($_FILES['fileUpload']['name']);
        move_uploaded_file($_FILES['fileUpload']['tmp_name'], $documentPath);
    }

    // Check for duplicate clearance request
    $stmt = $conn->prepare("SELECT * FROM ClearanceRequests WHERE StudentAdmNo = ? AND ClearanceType = ?");
    $stmt->bind_param("ss", $studentAdmNo, $clearanceType);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "A clearance request for this type has already been submitted by this student.";
    } else {
        // Insert data into the table
        $stmt = $conn->prepare("INSERT INTO ClearanceRequests (StudentAdmNo, StudentName, Department, Contact, Course, Email, ClearanceType, DocumentPath) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $studentAdmNo, $studentName, $department, $contact, $course, $email, $clearanceType, $documentPath);

        if ($stmt->execute()) {
            echo "Clearance request submitted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>
