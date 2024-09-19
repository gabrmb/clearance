
<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Get the FullName from the session
$fullName = isset($_SESSION['FullName']) ? $_SESSION['FullName'] : '';

$studentData = null; // Initialize variable to hold student data

if (isset($_SESSION['RegNo'])) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'kinapclearance');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get student registration number from session
    $regNo = $_SESSION['RegNo'];

    // Fetch data from students table where StudentRegNo matches the session regNo
    $stmt = $conn->prepare("SELECT StudentName, Email, Contact, Course, ClearanceType FROM students WHERE StudentRegNo = ?");
    $stmt->bind_param("s", $regNo);
    $stmt->execute();
    $result = $stmt->get_result();

    // If student data exists, store it in a variable
    if ($result->num_rows > 0) {
        $studentData = $result->fetch_assoc();
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Submission</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Master.css">
    <link rel="stylesheet" href="css/Clearance.css">

</head>
<body>

<?php include 'MasterStudent.php'; ?>

<div class="container">
    <div class="header-container">
        <h1 class="header-title">Manage Your Clearance</h1>
        <button class="new-request-btn" id="newRequestBtn"><i class='bx bx-plus'></i>New Request</button>
    </div>

    <div class="table-container">
        <div class="table-title">
        <h4>List of Your Clearance Requests</h4>
        </div>

        <div class="table-controls">
            <label for="entries">Show 
                <select id="entries" name="entries">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
                 entries
            </label>

            <div class="search-box">
                <label for="search-input">Search:</label>
                <input type="text" id="search" placeholder="Search...">
            </div>
        </div>

        <table id="clearanceTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Req ID</th>
                    <th>Student Adm No</th>                    
                    <th>Department</th>
                    <th>Contact</th>
                    <th>Course</th>
                    <th>Email</th>
                    <th>Clearance Type</th>
                    <th>Submission Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Connect to the database
                $conn = new mysqli('localhost', 'root', '', 'kinapclearance');

                if ($conn->connect_error) {
                    die('Connection failed: ' . $conn->connect_error);
                }

                // Fetch the StudentAdmNo from session (RegNo)
                $regNo = isset($_SESSION['RegNo']) ? $_SESSION['RegNo'] : '';

                // Update the SQL query to filter by the StudentAdmNo
                $sql = "SELECT * FROM clearancerequests WHERE StudentAdmNo = ?";

                // Prepare the statement
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $regNo);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $index = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$index}</td>
                                <td>{$row['RequestID']}</td>
                                <td>{$row['StudentAdmNo']}</td>
                                <td>{$row['Department']}</td>
                                <td>{$row['Contact']}</td>
                                <td>{$row['Course']}</td>
                                <td>{$row['Email']}</td>
                                <td>{$row['ClearanceType']}</td>
                                <td>{$row['SubmissionDate']}</td>
                                <td>
                                    <button class='edit-btn'><i class='bx bxs-edit-alt'></i></button>
                                    <button class='delete-btn' onclick=\"confirmDelete({$row['RequestID']})\"><i class='bx bxs-trash'></i></button>
                                </td>
                            </tr>";
                        $index++;
                    }
                } else {
                    echo "<tr><td colspan='11'>No data found</td></tr>";
                }

                $stmt->close();
                $conn->close();
            ?>
            </tbody>
        </table>
    </div>
</div>  
<script>
    function confirmDelete(requestID) {
        // Confirmation prompt
        let confirmAction = confirm("Once a request is removed, it cannot be restored. Are you sure you want to remove this clearance request?");
        if (confirmAction) {
            // If the user confirms, redirect to delete_clearance.php with the RequestID
            window.location.href = "delete_clearance.php?RequestID=" + requestID;
        }
        // If the user selects "No," do nothing
    }
</script>


<!-- Modal Form for adding Request HTML -->
<div id="modalForm" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Add Clearance Request</h2>
            <span class="close">&times;</span>
        </div>

        <form action="submit_clearance.php" method="POST" enctype="multipart/form-data">
            <div class="input-box">
                <label for="name">Full Name:</label>
                <input type="text" placeholder="Enter full name" name="name" required pattern="[A-Za-z\s]+" 
                    title="Full Name should not contain numbers"
                    value="<?php echo isset($studentData) ? $studentData['StudentName'] : ''; ?>">
            </div>

            <div class="input-box">
                <label for="regNo">Student Reg:</label>
                <input type="text" placeholder="Enter student Registration No." name="RegistrationNo" required
                    value="<?php echo isset($_SESSION['RegNo']) ? $_SESSION['RegNo'] : ''; ?>" readonly>
            </div>

            <div class="input-box">
                <label for="department">(Submitted to) Department:</label>
                <select id="department" name="department" required>
                    <option value="" selected>Select Department</option>
                    <option value="Deans Office">Deans Office</option>
                    <option value="House Keeping">House Keeping</option>
                    <option value="Security">Security</option>
                    <option value="Students Council">Students Council</option>
                    <option value="Library">Library</option>
                    <option value="ICT">ICT</option>
                </select>
            </div>

            <div class="input-box">
                <label for="phone">Phone Number:</label>
                <input type="text" placeholder="Enter your phone number" name="phoneNo" required pattern="[0-9]+" 
                    title="Phone Number should not contain letters"
                    value="<?php echo isset($studentData) ? $studentData['Contact'] : ''; ?>">
            </div>

            <div class="input-box">
                <label for="course">Course:</label>
                <input type="text" placeholder="Enter course" name="course" required pattern="[A-Za-z\s]+" 
                    title="Course should not contain numbers"
                    value="<?php echo isset($studentData) ? $studentData['Course'] : ''; ?>">
            </div>

            <div class="input-box">
                <label for="email">Email:</label>
                <input type="email" placeholder="Enter your email address" name="email" required
                    value="<?php echo isset($studentData) ? $studentData['Email'] : ''; ?>">
            </div>

            <div class="input-box">
                <label for="clearanceType">Type of Clearance:</label>
                <input type="clearanceType" placeholder="Enter your clearance type" name="clearanceType" required
                    value="<?php echo isset($studentData) ? $studentData['ClearanceType'] : ''; ?>">
            </div>

            <div class="input-box">
                <label for="fileUpload">Supporting Document:</label>
                <input type="file" id="fileUpload" name="uploadedFile" required>
            </div>

            <div class="message">
                <!-- Error message can be displayed here -->
            </div>

            <div class="button-container">
                <button type="submit">Submit Request</button>
            </div>
        </form>
    </div>
</div>

<script src="js/Clearance.js"></script>


<!-- Modal Form for Editing -->
<div id="editModalForm" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Edit Clearance</h2>
            <span class="close">&times;</span>
        </div>

        <form id="editClearanceForm" action="edit_clearance.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="edit_requestID" name="RequestID">
            <div class="input-box">
                <label for="edit_name">Full Name:</label>
                <input type="text" id="edit_name" name="name" value="<?php echo $_SESSION['FullName']; ?>" readonly>
            </div>

            <div class="input-box">
                <label for="edit_regNo">Student Reg:</label>
                <input type="text" id="edit_regNo" placeholder="Enter student Registration No." name="RegistrationNo" required>
            </div>

            <div class="input-box">
                <label for="edit_department">(Submitted to) Department:</label>
                <select id="edit_department" name="department" required>
                    <option value="" selected>Select Department</option>
                    <option value="Deans Office">Deans Office</option>
                    <option value="House Keeping">House Keeping</option>
                    <option value="Security">Security</option>
                    <option value="Students Council">Students Council</option>
                    <option value="Library">Library</option>
                    <option value="ICT">ICT</option>
                </select>
            </div>

            <div class="input-box">
                <label for="edit_phone">Phone Number:</label>
                <input type="text" id="edit_phone" placeholder="Enter your phone number" name="phoneNo" required pattern="[0-9]+" title="Phone Number should not contain letters">
            </div>

            <div class="input-box">
                <label for="edit_course">Course:</label>
                <input type="text" id="edit_course" placeholder="Enter course" name="course" required pattern="[A-Za-z\s]+" title="Course should not contain numbers">
            </div>

            <div class="input-box">
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" placeholder="Enter your email address" name="email" required>
            </div>

            <div class="input-box">
                <label for="clearanceType">Type of Clearance:</label>
                <input type="text" id="edit_clearanceType" placeholder="Enter your email address" name="clearanceType" required>
            </div>

            <div class="input-box">
                <label for="edit_fileUpload">Supporting Document:</label>
                <input type="file" id="edit_fileUpload" name="uploadedFile" required>
            </div>

            <div class="message">
                <!-- Error message can be displayed here -->
            </div>

            <div class="button-container">
                <button type="submit" id="submitEdit">Edit Request</button>
            </div>
        </form>
    </div>
</div>
<script src="js/EditClearance.js"></script>
</body>
</html>
