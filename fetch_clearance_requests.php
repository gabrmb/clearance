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

    // Check if the department was found
    if ($department) {
        // Fetch clearance requests for the user's department from the 'clearancerequests' table
        $sql = "SELECT RequestID, StudentAdmNo, StudentName, Course, ClearanceType, Email, Status, SubmissionDate, FileName
                FROM clearancerequests 
                WHERE Department = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $department);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display the records in the table
        if ($result->num_rows > 0) {
            // Output the records
            $i = 1; // For numbering
            while ($row = $result->fetch_assoc()) {
                // Determine the status and set the corresponding class
                $status = htmlspecialchars($row['Status'], ENT_QUOTES, 'UTF-8');
                $statusClass = '';
                
                if ($status === 'Approved') {
                    $statusClass = 'status-approved'; // Green
                } elseif ($status === 'Rejected') {
                    $statusClass = 'status-rejected'; // Red
                } else {
                    $statusClass = 'status-pending'; // Blue
                }
                
                echo "<tr>
                        <td>" . $i++ . "</td>
                        <td>" . htmlspecialchars($row['RequestID'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row['StudentAdmNo'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row['StudentName'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row['Course'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row['ClearanceType'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row['SubmissionDate'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($row['FileName'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td class='status $statusClass'>" . $status . "</td>
                        <td class='action-buttons'>
                            <!-- 'View File' button -->
                            <a href='uploads/" . htmlspecialchars($row['FileName'], ENT_QUOTES, 'UTF-8') . "' target='_blank' class='view-btn' title='View File'>
                                <i class='bx bxs-file-archive'></i>
                            </a>

                            <!-- 'Approve Request' button -->
                            <a href='javascript:void(0);' class='edit-btn' title='Manage Request'
                            data-requestid='" . htmlspecialchars($row['RequestID'], ENT_QUOTES, 'UTF-8') . "'
                            data-studentadmno='" . htmlspecialchars($row['StudentAdmNo'], ENT_QUOTES, 'UTF-8') . "'
                            data-studentname='" . htmlspecialchars($row['StudentName'], ENT_QUOTES, 'UTF-8') . "'
                            data-course='" . htmlspecialchars($row['Course'], ENT_QUOTES, 'UTF-8') . "'
                            data-clearancetype='" . htmlspecialchars($row['ClearanceType'], ENT_QUOTES, 'UTF-8') . "'
                            data-submissiondate='" . htmlspecialchars($row['SubmissionDate'], ENT_QUOTES, 'UTF-8') . "'>
                                <i class='bx bxs-edit'></i>
                            </a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No clearance requests found for your department.</td></tr>";
        }

        $stmt->close();
    } else {
        echo "<tr><td colspan='11'>Department not found for the logged-in user. <a href='AccountUpdate.php'>Click here to update your staff account</a></td></tr>";
    }
} else {
    echo "<tr><td colspan='11'>User not logged in. <a href='index.php'>Click here to log in.</a></td></tr>";
}

// Close the database connection
$conn->close();
?>
