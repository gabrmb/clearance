
<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Assuming session values are already set somewhere in the application
$fullName = isset($_SESSION['FullName']) ? $_SESSION['FullName'] : '';
$regNo = isset($_SESSION['RegNo']) ? $_SESSION['RegNo'] : '';
$email = isset($_SESSION['Email']) ? $_SESSION['Email'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Update</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Master.css">
    <link rel="stylesheet" href="css/AccountUpdate.css">
</head>
<body>
    <?php include 'MasterHOD.php'; ?>

<div class="container">
    <div class="form-container">
        <!-- Approve Clearances Title Bar -->
        <div class="title-bar">
            <h2>Update your Account here</h2>
        </div>

        <!-- Update Your Details Form -->
        <form action="update_staff.php" method="POST">
                <h3>Update your details here:</h3>
                <div class="form-content">
                    <div class="form-field">
                        <label for="StaffName">Staff Name</label>
                        <input type="text" id="StaffName" name="StaffName" value="<?php echo htmlspecialchars($fullName); ?>" placeholder="Enter your name" readonly>
                    </div>
                    
                    <div class="form-field">
                        <label for="EmployeeNo">Employee No</label>
                        <input type="text" id="EmployeeNo" name="EmployeeNo" value="<?php echo htmlspecialchars($regNo); ?>" placeholder="Enter your employee number" readonly>
                    </div>

                    <div class="form-field">
                        <label for="Department">Department</label>
                        <select id="Department" name="Department" required>
                            <option value="" selected>Select Department</option>
                            <option value="Deans Office">Deans Office</option>
                            <option value="House Keeping">House Keeping</option>
                            <option value="Security">Security</option>
                            <option value="Students Council">Students Council</option>
                            <option value="Library">Library</option>
                            <option value="ICT">ICT</option>
                        </select>
                    </div>

                    <div class="form-field">
                        <label for="Email">Email</label>
                        <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email" readonly>
                    </div>
                    <div class="submit-button">
                        <button type="submit">Update your details</button>
                    </div>
                </div>  
            </form>
</div>
</body>
</html>