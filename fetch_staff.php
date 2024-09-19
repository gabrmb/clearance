<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$servername = "localhost"; // Adjust these details based on your environment
$username = "root"; 
$password = ""; 
$dbname = "kinapclearance"; // Adjust to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records from 'Staff' table
$sql = "SELECT EmployeeNo, Fullname, Department, Email FROM Staff";
$result = $conn->query($sql);

?>

<div class="staff-list">
    <h4>Staff Information</h4>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row in an HTML table with a numbering column
        echo "<table>
                <thead>
                    <tr>
                    <th>No.</th>
                    <th>Employee No</th>
                    <th>Full Name</th>
                    <th>Department</th>
                    <th>Email</th>
                </thead>
                <tbody>";
        
        // Initialize row numbering
        $num = 1;

        // Fetch each row of the result
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $num . "</td>  <!-- Display row number -->
                    <td>" . $row["EmployeeNo"] . "</td>
                    <td>" . $row["Fullname"] . "</td>
                    <td>" . $row["Department"] . "</td>
                    <td>" . $row["Email"] . "</td>
                </tr>";
            
            // Increment the row number for the next row
            $num++;
        }
        echo "</tbody>
              </table>";
    } else {
        echo "No staff records found.";
    }

    // Close the connection
    $conn->close();
    ?>
</div>
