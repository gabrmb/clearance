<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'kinapclearance');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Capture the POST data
$requestID = $_POST['RequestID']; // Hidden input with the RequestID in the form
$studentAdmNo = $_POST['RegistrationNo'];
$studentName = $_POST['name'];
$department = $_POST['department'];
$phoneNo = $_POST['phoneNo'];
$course = $_POST['course'];
$email = $_POST['email'];
$clearanceType = $_POST['clearanceType'];

// Check if a file was uploaded
$fileName = '';
$filePath = '';
if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] == 0) {
    // File upload logic
    $fileName = $_FILES['uploadedFile']['name'];
    $fileTmpName = $_FILES['uploadedFile']['tmp_name'];
    $uploadDirectory = 'uploads/'; // Ensure this directory exists and is writable

    // Move the uploaded file to the target directory
    $filePath = $uploadDirectory . basename($fileName);
    if (!move_uploaded_file($fileTmpName, $filePath)) {
        die('Error uploading file.');
    }
}

// Validate all inputs before updating
if (empty($studentAdmNo) || empty($studentName) || empty($department) || empty($phoneNo) ||
    empty($course) || empty($email) || empty($clearanceType)) {
    die('All fields are required.');
}

// Check for duplication
$duplicationCheckSql = "SELECT * FROM clearancerequests 
                        WHERE StudentAdmNo = ? AND Department = ? AND RequestID != ?";
$stmtCheck = $conn->prepare($duplicationCheckSql);
$stmtCheck->bind_param("ssi", $studentAdmNo, $department, $requestID);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    // Duplication found
    echo "<script>
            alert('A clearance request with the same Registration No and Department already exists.');
            window.history.back(); // Go back to the form
          </script>";
    $stmtCheck->close();
    $conn->close();
    exit();
}

$stmtCheck->close();

// Prepare the SQL statement for updating the record
$sql = "UPDATE clearancerequests 
        SET StudentAdmNo=?, StudentName=?, Department=?, Contact=?, Course=?, Email=?, ClearanceType=?, FileName=?, FilePath=?, SubmissionDate=?
        WHERE RequestID=?";

// Prepare the current date and time
$submissionDate = date('Y-m-d H:i:s');

// Prepare the statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Error preparing the statement: ' . $conn->error);
}

// Bind the parameters
$stmt->bind_param("ssssssssssi", $studentAdmNo, $studentName, $department, $phoneNo, $course, $email, $clearanceType, $fileName, $filePath, $submissionDate, $requestID);

// Execute the query
if ($stmt->execute()) {
    echo "<script>
            alert('Clearance request updated successfully.');
            window.location.href = 'SubmitClearance.php'; // Reload the page
    </script>";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
