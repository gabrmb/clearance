
<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'kinapclearance');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$regNo = $_POST['RegNo'];
$fullName = $_POST['FullName'];
$department = $_POST['Department'];
$contact = $_POST['Contact'];
$gender = $_POST['Gender'];
$email = $_POST['Email'];
$role = $_POST['Role'];
$designation = $_POST['Designation'];
$accountStatus = $_POST['AccountStatus'];

// Update query
$sql = "UPDATE Users SET 
    FullName = '$fullName', 
    Department = '$department', 
    Contact = '$contact', 
    Gender = '$gender', 
    Email = '$email', 
    Role = '$role', 
    Designation = '$designation', 
    AccountStatus = '$accountStatus' 
    WHERE RegNo = '$regNo'";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('User details updated successfully.');
            window.location.href = 'UsersList.php'; // Reload the login page
        </script>";
    exit();
    
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
