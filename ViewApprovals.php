<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Approvals</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Master.css">
    <link rel="stylesheet" href="css/ViewApprovals.css">
</head>
<body>
    <?php 
    include 'MasterHOD.php'; 
    
    // Check if session is already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in and has a session value for RegNo
    if (isset($_SESSION['RegNo'])) {
        $regNo = $_SESSION['RegNo'];

        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'kinapclearance');

        // Check connection
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        // Fetch the department of the logged-in user from the 'staff' table
        $stmt = $conn->prepare("SELECT Department FROM staff WHERE EmployeeNo = ?");
        $stmt->bind_param("s", $regNo);
        $stmt->execute();
        $stmt->bind_result($department);
        $stmt->fetch();
        $stmt->close();
    } else {
        // Default value if no department found
        //$department = "Unknown Department";
        echo "<script>
                alert('You need to update your account to access this page.');
                window.location.href = 'AccountUpdate.php'; // Redirect back to the form page
              </script>";
    }
    ?>

    <div class="Pagetitle">
        <!-- Dynamically insert the department name -->
        <h3>Processed Clearance Requests for: <?php echo htmlspecialchars($department); ?> Department.</h3>   
    </div>

    <div class="container">
        <!-- Clearance Requests Title Bar -->
        <div class="title-bar">
            <h3>View Processed Requests</h3>
        </div>

        <!-- Pagination and Search -->
        <div class="pagination-and-search">
            <div class="pagination">
                Show 
                <select name="entries" id="entries">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select> entries
            </div>
            <div class="search">
                Search: <input type="text" id="search" placeholder="Search requests">
            </div>
        </div>
    </div>

    <!-- Clearance Requests Table -->
    <div class="table-container">
        <?php
            // Include the PHP logic here to fetch and display the records
            include 'fetch_Approvals.php'; 
        ?>
    </div>

</body>
</html>
