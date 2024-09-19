<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Approvals</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Master.css">
    <link rel="stylesheet" href="css/Staff.css">
</head>
<body>
    <?php include 'MasterAdmin.php'; ?>
    
    
    <div class="Pagetitle">
        <!-- Dynamically insert the department name -->
        <h3>List of Staff authorised to Process Clearances</h3>   
    </div>

    <div class="container">
        <!-- Clearance Requests Title Bar -->
        <div class="title-bar">
            <h3>View Staff Members</h3>
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
            include 'fetch_staff.php'; 
        ?>
    </div>

</body>
</html>
