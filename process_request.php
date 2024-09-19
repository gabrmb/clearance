<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'kinapclearance');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if the user is logged in and has a session value for RegNo
    if (isset($_SESSION['RegNo'])) {
        $regNo = $_SESSION['RegNo'];
        
        // Fetch the department of the logged-in user from the 'staff' table
        $stmt = $conn->prepare("SELECT Department FROM staff WHERE EmployeeNo = ?");
        $stmt->bind_param("s", $regNo);
        $stmt->execute();
        $stmt->bind_result($department);
        $stmt->fetch();
        $stmt->close();

        // If the department is found, proceed with storing approval data
        if ($department) {
            // Sanitize and collect form data
            $requestID = htmlspecialchars($_POST['RequestID'], ENT_QUOTES, 'UTF-8');
            $studentAdmNo = htmlspecialchars($_POST['StudentAdmNo'], ENT_QUOTES, 'UTF-8');
            $studentName = htmlspecialchars($_POST['StudentName'], ENT_QUOTES, 'UTF-8');
            $course = htmlspecialchars($_POST['Course'], ENT_QUOTES, 'UTF-8');
            $status = htmlspecialchars($_POST['Status'], ENT_QUOTES, 'UTF-8');
            $comments = htmlspecialchars($_POST['Comments'], ENT_QUOTES, 'UTF-8');
            $approvalDate = date("Y-m-d H:i:s"); // Current date and time

            // Check if a record already exists for this RequestID in the Approval table
            $checkSQL = "SELECT COUNT(*) FROM Approval WHERE RequestID = ?";
            $stmt = $conn->prepare($checkSQL);
            $stmt->bind_param("s", $requestID);
            $stmt->execute();
            $stmt->bind_result($recordExists);
            $stmt->fetch();
            $stmt->close();

            // Update or insert the record in the Approval table
            if ($recordExists > 0) {
                // If a record exists, update it
                $updateSQL = "UPDATE Approval 
                              SET Department = ?, Course = ?, RequestStatus = ?, ApprovalDate = ?, Comments = ? 
                              WHERE RequestID = ?";
                $stmt = $conn->prepare($updateSQL);
                $stmt->bind_param("ssssss", $department, $course, $status, $approvalDate, $comments, $requestID);
            } else {
                // If no record exists, insert a new one
                $insertSQL = "INSERT INTO Approval (Department, RequestID, StudentName, RegistrationNo, Course, RequestStatus, ApprovalDate, Comments) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertSQL);
                $stmt->bind_param("ssssssss", $department, $requestID, $studentName, $studentAdmNo, $course, $status, $approvalDate, $comments);
            }

            // Execute the query and check for success
            if ($stmt->execute()) {
                // After processing the approval, update the Status in the clearancerequests table
                $updateClearanceSQL = "UPDATE clearancerequests 
                                       SET Status = ? 
                                       WHERE RequestID = ?";
                $stmtClearance = $conn->prepare($updateClearanceSQL);
                $stmtClearance->bind_param("ss", $status, $requestID);

                if ($stmtClearance->execute()) {
                    echo "Request processed and clearance status updated successfully.";
                } else {
                    echo "Error updating clearance status: " . $stmtClearance->error;
                }

                $stmtClearance->close();
            } else {
                echo "Error processing the request: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Department not found for the logged-in user.";
        }
    } else {
        echo "User is not logged in.";
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
