<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in (i.e., session variables are set)
if (!isset($_SESSION['UserName']) || !isset($_SESSION['RegNo'])) {
    // Redirect to login page if session variables are not set
    header('Location: index.php');
    exit();
}

// Retrieve the registration number from the session
$regNo = $_SESSION['RegNo'];




// Database connection
$conn = new mysqli('localhost', 'root', '', 'kinapclearance');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student = null; // Initialize student as null to check later

// Query the database to fetch student details based on session RegNo
$sql = "SELECT StudentRegNo, StudentName, Email, Contact, Department, Course, ClearanceType FROM students WHERE StudentRegNo = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Failed to prepare SQL statement: " . $conn->error);
}

// Bind the session RegNo to the SQL query
$stmt->bind_param('s', $regNo);
$stmt->execute();
$result = $stmt->get_result();

// Fetch student details if found
if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "<p>No records found for the registration number in session.</p>";
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Application</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Master.css">
    <link rel="stylesheet" href="css/Application.css">
</head>
<body>
    <?php include 'MasterStudent.php'; ?>

    <!-- Form Section -->
    <div class="form-container">
        <h3>Apply for Clearance</h3>
        <div class="info-section">
            <p>Fill in your details to start Application</p>
            <input type="search" class="search-bar" placeholder="Search..." />
        </div>
        
        <form action="save_student.php" method="post">
        <div class="content">    
            <div class="form-field">
                <label for="regNo">Student Registration No:</label>
                <!-- Auto-fill registration number from session -->
                <input type="text" id="regNo" name="regNo" value="<?php echo $regNo; ?>" placeholder="Enter Registration No" required readonly>
            </div>

            <div class="form-field">
                <label for="studentName">Student Name:</label>
                <!-- Auto-fill student name from session -->
                <input type="text" id="studentName" name="studentName" value="<?php echo $fullName; ?>" placeholder="Enter Student Name" required readonly>
            </div>

            <div class="form-field">
                <label for="email">Email:</label>
                <!-- Auto-fill email from session -->
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter Email" required readonly>
            </div>

            <div class="form-field">
                <label for="contact">Contact:</label>
                <!-- Auto-fill contact from session -->
                <input type="text" id="contact" name="contact" value="<?php echo $contact; ?>" placeholder="Enter Contact" required readonly>
            </div>

            <div class="form-field">
                <label for="department">Select Department:</label>
                <select id="department" name="department">
                    <option value="" selected>Select Department</option>
                    <option value="ICT and Computer Studies">ICT and Computer Studies</option>
                    <option value="Business and Entrepreneurship Studies">Business and Entrepreneurship Studies</option>
                    <option value="Building and Civil Engineering">Building and Civil Engineering</option>
                    <option value="Electrical and Electronics">Electrical and Electronics</option>
                    <option value="Baking Technology">Baking Technology</option>
                    <option value="Hospitality">Hospitality</option>
                    <option value="Applied Sciences">Applied Sciences</option>
                    <option value="Mechatronics">Mechatronics</option>
                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                </select>
            </div>

            <div class="form-field">
                <label for="course">Select Course:</label>
                <select id="course" name="course">
                <option value="" selected>Select Course</option>
                    <option value="Diploma in Information Communication Technology">Diploma in Information Communication Technology</option>
                    <option value="Certificate in Human Resource Management (Modular)">Certificate in Human Resource Management (Modular)</option>
                    <option value="Diploma in ELectrical and Electronics Engineering (Instrumentation Option)">Diploma in ELectrical and Electronics Engineering (Instrumentation Option)</option>
                    <option value="Diploma in Banking and Finance (TEP)">Diploma in Banking and Finance (TEP)</option>
                    <option value="Diploma in Business Management (Modular)">Diploma in Business Management (Modular)</option>
                    <option value="Diploma in Supply Chain Management (Modular)">Diploma in Supply Chain Management (Modular)</option>
                </select>
            </div>

            <div class="form-field">
                <label for="clearanceType">Type of Clearance:</label>
                <select id="clearanceType" name="clearanceType">
                    <option value="SelectRole" selected>Select Clearance Type</option>
                    <option value="Course Completion">Course Completion</option>
                    <option value="Transfer">Transfer</option>
                    <option value="Discontinuation">Discontinuation</option>
                </select>
            </div>
        </div>
           
            <div class="form-field1">
                <button type="submit" class="submit-btn">Update Details</button>
            </div>
        </form>
    </div>

    <!-- Table Section -->
 
    <div class="table-container" id="studentTable">
        <h3>Your Updated Student's Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Student Registration No</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Department</th>
                    <th>Course</th>
                    <th>Clearance Type</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($student) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['StudentRegNo']); ?></td>
                        <td><?php echo htmlspecialchars($student['StudentName']); ?></td>
                        <td><?php echo htmlspecialchars($student['Email']); ?></td>
                        <td><?php echo htmlspecialchars($student['Contact']); ?></td>
                        <td><?php echo htmlspecialchars($student['Department']); ?></td>
                        <td><?php echo htmlspecialchars($student['Course']); ?></td>
                        <td><?php echo htmlspecialchars($student['ClearanceType']); ?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="7">No data available.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="LinkButton">
            <a href="SubmitClearance.php" class="continue-btn">Click to Continue</a>
        </div>

    </div>

</body>
</html>
