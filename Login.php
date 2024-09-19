<?php
session_start(); // Start session management

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'kinapclearance');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username and password from the form
$username = $_POST['username'];
$password = $_POST['password']; // Plain-text password from the user

// Prepare SQL to check if the username exists
$sql = "SELECT * FROM Users WHERE UserName = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Use password_verify to compare the plain-text password with the hashed password in the database
    if (password_verify($password, $row['Password'])) {

        // Step 1: Check account status
        if ($row['AccountStatus'] == 'Inactive') {
            echo "<script>
                alert('Your account is being activated. If you receive this message again after 24 hours, contact the admin.');
                window.location.href = 'index.php'; // Reload the login page
            </script>";
            exit(); // Stop the script here if account is inactive
        }

        // Step 2: If the account is active, start setting session variables
        if ($row['AccountStatus'] == 'Active') {
            // Store user details in session variables
            $_SESSION['FullName'] = $row['FullName'];
            $_SESSION['RegNo'] = $row['RegNo'];
            $_SESSION['UserName'] = $row['UserName'];
            $_SESSION['Email'] = $row['Email'];
            $_SESSION['Contact'] = $row['Contact'];

            // Redirect based on user role
            switch ($row['Role']) {
                case 'Admin':
                    header("Location: AdminDashboard.php");
                    exit();
                case 'Student':
                    header("Location: StudentDashboard.php");
                    exit();
                case 'Staff':
                    header("Location: HoDDashboard.php");
                    exit();
                default:
                    echo "<script>
                        alert('Invalid role.');
                        window.location.href = 'index.php'; // Reload the login page
                    </script>";
                    exit();
            }
        } else {
            echo "<script>
                alert('Invalid account status. Please contact admin.');
                window.location.href = 'index.php'; // Reload the login page
            </script>";
            exit();
        }

    } else {
        // If password does not match, show an error message
        echo "<script>
            alert('Wrong username or password.');
            window.location.href = 'index.php'; // Reload the login page
        </script>";
    }

} else {
    // If the username does not exist, show an error message
    echo "<script>
        alert('Wrong username or password.');
        window.location.href = 'index.php'; // Reload the login page
    </script>";
}

$stmt->close();
$conn->close();
?>
