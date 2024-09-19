<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Master.css">
    <link rel="stylesheet" href="css/AdminDashboard.css"> <!-- Your custom CSS file -->
    <link rel="stylesheet" href="css/Report.css"> <!-- Your custom CSS file -->
   
</head>
<body>
    <?php include 'MasterAdmin.php'; ?>

    <!-- Navigation Links -->
    <div class="nav-links">
        <a href="Reports.php" class="active">Approved Requests</a>
        <a href="Rejected.php">Rejected Requests</a>
        <a href="Pending.php">Pending Requests</a>
        <a href="IssueClearance.php">Issue Clearance</a>
    </div>
    <form class="Report">
        <div class="form-Details">
            
        </div>
    </form>   
    <div class="LetterHead">
        <img src="images/KinapLogo.jpg" alt="Company Logo">
    </div>

    <div class="">
        
    </div>

    <?php
        // Database connection
        $servername = "localhost"; // Adjust these details based on your environment
        $username = "root"; 
        $password = ""; 
        $dbname = "kinapclearance"; 

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch records where RequestStatus is 'Approved'
        $sql = "SELECT ApprovalID, Department, RequestID, StudentName, RegistrationNo, Course, RequestStatus, ApprovalDate FROM approval WHERE RequestStatus = 'Rejected'";
        $result = $conn->query($sql);
    ?>

    <div class="report-list">
        <h4>Rejected Requests</h4>
        <?php
            if ($result->num_rows > 0) {
                // Output data of each row in an HTML table with a numbering column
                echo "<table >
                        <tr>
                            <th>No.</th>
                            <th>Approval ID</th>
                            <th>Cleared by(Department)</th>
                            <th>Request ID</th>
                            <th>Student Name</th>
                            <th>Registration No</th>
                            <th>Course</th>
                            <th>Request Status</th>
                            <th>Processed Date</th>
                        </tr>";
                
                // Initialize row numbering
                $num = 1;

                // Fetch each row of the result
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $num . "</td>  <!-- Display row number -->
                            <td>" . $row["ApprovalID"] . "</td>
                            <td>" . $row["Department"] . "</td>
                            <td>" . $row["RequestID"] . "</td>
                            <td>" . $row["StudentName"] . "</td>
                            <td>" . $row["RegistrationNo"] . "</td>
                            <td>" . $row["Course"] . "</td>
                            <td>" . $row["RequestStatus"] . "</td>
                            <td>" . $row["ApprovalDate"] . "</td>
                        </tr>";
                    
                    // Increment the row number for the next row
                    $num++;
                }
                echo "</table>";
            } else {
                echo "No Rejected requests found.";
            }

            // Close the connection
            $conn->close();
            ?>
    

    <!-- Additional content for the dashboard can go here -->
</body>
</html>
