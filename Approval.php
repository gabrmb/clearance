
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Master.css">
    <link rel="stylesheet" href="css/Approval.css">
</head>
<body>
    <?php include 'MasterHOD.php'; ?>


<div class="title-bar1">
    <h2>Approve Clearance Requests</h2>   
</div>
<div class="container">

        <!-- Clearance Requests Title Bar -->
        <div class="title-bar">
            <h3>Clearance Requests</h3>
        </div>

        <!-- Pagination and Search -->
        <div class="pagination-and-search">
            <div class="pagination">
                Show 
                <select name="entries" id="entries">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">15</option>
                    <option value="25">25</option>
                </select> entries
            </div>
            <div class="search">
                Search: <input type="text" id="search" placeholder="Search requests">
            </div>
        </div>
    
    <!-- Clearance Requests Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>RequestID</th>
                    <th>StudentAdmNo</th>
                    <th>StudentName</th>
                    <th>Course</th>
                    <th>ClearanceType</th>
                    <th>Email</th>
                    <th>SubmissionDate</th>
                    <th>File Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                    // Include the PHP logic here to fetch and display the records
                    include 'fetch_clearance_requests.php'; 
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add any necessary JS scripts for pagination, searching, etc. -->
<script>
    document.getElementById('entries').addEventListener('change', function() {
        const entriesPerPage = this.value;
        console.log("Showing entries per page:", entriesPerPage);
        // Add logic to adjust the number of rows per page
    });

    document.getElementById('search').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#table-body tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
            row.style.display = match ? '' : 'none';
        });
    });
</script>

<!-- Modal Form for Approving Requests -->
<div id="approveModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Approve Request</h3>
            <span class="close-btn">&times;</span>
        </div>
        <div class="modal-body">
            <form id="approveForm" action="process_request.php" method="POST">
                <div class="form-row">
                    <label for="RequestID">Request ID:</label>
                    <input type="text" id="RequestID" name="RequestID" readonly>
                </div>
                <div class="form-row">
                    <label for="StudentAdmNo">Student Admission No:</label>
                    <input type="text" id="StudentAdmNo" name="StudentAdmNo" readonly>
                </div>
                <div class="form-row">
                    <label for="StudentName">Student Name:</label>
                    <input type="text" id="StudentName" name="StudentName" readonly>
                </div>
                <div class="form-row">
                    <label for="Course">Course:</label>
                    <input type="text" id="Course" name="Course" readonly>
                </div>
                <div class="form-row">
                    <label for="ClearanceType">Clearance Type:</label>
                    <input type="text" id="ClearanceType" name="ClearanceType" readonly>
                </div>
                <div class="form-row">
                    <label for="SubmissionDate">Submission Date:</label>
                    <input type="text" id="SubmissionDate" name="SubmissionDate" readonly>
                </div>
                <div class="form-row">
                    <label for="Status">Request Approval:</label>
                    <select id="Status" name="Status">
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="Comments">Comments:</label>
                    <textarea id="Comments" name="Comments" placeholder="Enter your comments here"></textarea>
                </div>
                <div class="form-row submit-btn">
                    <button type="submit">Process Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS for modal functionality -->
<script src="js/ApprovalModal.js"></script>

</body>
</html>