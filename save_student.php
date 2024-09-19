<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Master.css">
    <link rel="stylesheet" href="css">
</head>
<body>
<?php include 'MasterStudent.php'; ?>
<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'kinapclearance');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $studentRegNo = $_POST['regNo'];
    $studentName = $_POST['studentName'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $department = $_POST['department'];
    $course = $_POST['course'];
    $clearanceType = $_POST['clearanceType'];

    // Validation to ensure fields are not empty (this is just a safeguard, as you've set `required` in the HTML)
    if (empty($studentRegNo) || empty($studentName) || empty($email) || empty($contact) || empty($department) || empty($course) || empty($clearanceType)) {
        echo "<script>alert('Please fill in all fields. Ensure you have selected the DEPARTMENT,COURSE AND CLEARANCE');
                window.location.href = 'Application.php'; // Redirect back to the form page
              </script>";
        exit();
    }

    // Check for duplicate entries in the database, but allow updates if it's the same student
    $checkDuplicate = $conn->prepare("SELECT * FROM students WHERE (Email = ? OR Contact = ?) AND StudentRegNo != ?");
    $checkDuplicate->bind_param("sss", $email, $contact, $studentRegNo);
    $checkDuplicate->execute();
    $result = $checkDuplicate->get_result();

    if ($result->num_rows > 0) {
        // If there's a duplicate for a different student, prevent the update/insert
        echo "<script>
            alert('Error: Account with the provided Email or Contact already exists for a different student.');
            window.location.href = 'Application.php'; // Redirect back to the form page
        </script>";
        exit();
    }

    // Check if the record with the given registration number exists
    $checkRecord = $conn->prepare("SELECT * FROM students WHERE StudentRegNo = ?");
    $checkRecord->bind_param("s", $studentRegNo);
    $checkRecord->execute();
    $recordResult = $checkRecord->get_result();

    if ($recordResult->num_rows > 0) {
        // Record exists, so perform an update
        $stmt = $conn->prepare("UPDATE students SET StudentName = ?, Email = ?, Contact = ?, Department = ?, Course = ?, ClearanceType = ? WHERE StudentRegNo = ?");
        $stmt->bind_param("sssssss", $studentName, $email, $contact, $department, $course, $clearanceType, $studentRegNo);

        if ($stmt->execute()) {
            echo "<script>
                alert('Student details updated successfully.');
                window.location.href = 'Application.php'; // Redirect after successful update
            </script>";
        } else {
            echo "<script>
                alert('Error: Could not update the student details.');
                window.location.href = 'Application.php'; // Redirect back to the form page
            </script>";
        }
    } else {
        // Record does not exist, so perform an insert
        $stmt = $conn->prepare("INSERT INTO students (StudentRegNo, StudentName, Email, Contact, Department, Course, ClearanceType) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $studentRegNo, $studentName, $email, $contact, $department, $course, $clearanceType);

        if ($stmt->execute()) {
            echo "<script>
                alert('Student details added successfully.');
                window.location.href = 'Application.php'; // Redirect after successful insertion
            </script>";
        } else {
            echo "<script>
                alert('Error: Could not insert the student details.');
                window.location.href = 'Application.php'; // Redirect back to the form page
            </script>";
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
