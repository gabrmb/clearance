<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'kinapclearance');
    
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Sanitize and validate inputs
    $studentName = $conn->real_escape_string($_POST['name']);
    $studentAdmNo = $conn->real_escape_string($_POST['RegistrationNo']);
    $department = $conn->real_escape_string($_POST['department']);
    $contact = $conn->real_escape_string($_POST['phoneNo']);
    $course = $conn->real_escape_string($_POST['course']);
    $email = $conn->real_escape_string($_POST['email']);
    $clearanceType = $conn->real_escape_string($_POST['clearanceType']);
    
    // Handle file upload
    $fileName = $_FILES['uploadedFile']['name'];
    $fileTmpName = $_FILES['uploadedFile']['tmp_name'];
    $uploadDir = 'uploads/';
    $filePath = $uploadDir . basename($fileName);

    // Check for duplicate clearance request
    $checkSql = "SELECT * FROM clearancerequests WHERE StudentAdmNo = '$studentAdmNo' AND ClearanceType = '$clearanceType' AND Department = '$department'";
    
    $checkResult = $conn->query($checkSql);

    if ($checkResult === false) {
        // SQL query failed, print the error for debugging
        echo "Error: " . $conn->error;
    } else {
        // If the query succeeded, check if any records were found
        if ($checkResult->num_rows > 0) {
            // Error: Duplicate clearance request for same department
            echo "<script>
                alert('Error: Clearance request for this type and department already exists for this registration number.');
                window.history.back(); // Go back to the form
            </script>";
        } else {
            // Check if the file was uploaded successfully
            if (move_uploaded_file($fileTmpName, $filePath)) {
                // Insert data into the database
                // $submissionDate = date('Y-m-d'); // Get the current date
                $submissionDate = date('Y-m-d H:i:s'); // Get the current date and time
                
                $sql = "INSERT INTO clearancerequests (StudentAdmNo, StudentName, Department, Contact, Course, Email, ClearanceType, FileName, FilePath, Status, SubmissionDate) 
                        VALUES ('$studentAdmNo', '$studentName', '$department', '$contact', '$course', '$email', '$clearanceType', '$fileName', '$filePath', 'Pending', '$submissionDate')";
                
                if ($conn->query($sql) === TRUE) {
                    // Success: Close modal and reload page
                    echo "<script>
                        alert('Clearance request submitted successfully.');
                        window.location.href = 'SubmitClearance.php'; // Reload the page
                    </script>";
                } else {
                    // Error inserting into database
                    echo "<script>
                        alert('Error: " . $sql . "<br>" . $conn->error . "');
                        window.history.back(); // Go back to the form
                    </script>";
                }
            } else {
                // File upload error
                echo "<script>
                    alert('File upload failed. Please try again.');
                    window.history.back(); // Go back to the form
                </script>";
            }
        }
    }

    $conn->close();
}
?>
