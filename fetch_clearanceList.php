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
    // Fetch approval records for all departments (no filtering by department)
    $stmt = $conn->prepare("SELECT ApprovalID, RequestID, RegistrationNo, StudentName, Course, Department, RequestStatus, ApprovalDate, Comments 
                            FROM Approval");
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the data in an HTML table with clear table head and body
    echo "<table>
            <thead>
                <tr>
                    <th>ApprovalID</th>
                    <th>RequestID</th>
                    <th>RegistrationNo</th>
                    <th>StudentName</th>
                    <th>Course</th>
                    <th>Cleared By:</th>
                    <th>Status</th>
                    <th>ApprovalDate</th>
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody>";

    // Loop through the result and display each row in the table body
    while ($row = $result->fetch_assoc()) {
        // Define the background color based on the status
        $status = $row['RequestStatus'];
        $statusColor = '';

        // if ($status === 'Pending') {
        //     $statusColor = 'background-color: lightblue;'; // Blue for Pending
        // } elseif ($status === 'Rejected') {
        //     $statusColor = 'background-color: lightcoral;'; // Red for Rejected
        // } elseif ($status === 'Approved') {
        //     $statusColor = 'background-color: lightgreen;'; // Green for Approved
        // }

        if ($status === 'Pending') {
            $statusColor = 'background-color: blue; color: white;'; // Blue for Pending
        } elseif ($status === 'Rejected') {
            $statusColor = 'background-color: red; color: white;'; // Red for Rejected
        } elseif ($status === 'Approved') {
            $statusColor = 'background-color: green; color: white;'; // Green for Approved
        }


        echo "<tr>
                <td>{$row['ApprovalID']}</td>
                <td>{$row['RequestID']}</td>
                <td>{$row['RegistrationNo']}</td>
                <td>{$row['StudentName']}</td>
                <td>{$row['Course']}</td>
                <td>{$row['Department']}</td>
                <td style='{$statusColor}'>{$row['RequestStatus']}</td>
                <td>{$row['ApprovalDate']}</td>
                <td>{$row['Comments']}</td>
              </tr>";
    }

    echo "</tbody>
          </table>";

    $stmt->close();
} else {
    echo "No session found. Please log in.";
}

// Close the database connection
$conn->close();
?>
