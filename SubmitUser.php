<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost"; // Adjust as needed
    $username = "root"; // Adjust as needed
    $password = ""; // Adjust as needed
    $dbname = "kinapclearance"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve and sanitize form data
    $fullName = $conn->real_escape_string($_POST['name']);
    $regNo = $conn->real_escape_string($_POST['RegistrationNo']);
    $department = $conn->real_escape_string($_POST['dept']);
    $contact = $conn->real_escape_string($_POST['phoneNo']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $email = $conn->real_escape_string($_POST['email']);
    $designation = $conn->real_escape_string($_POST['desig']);
    $username = $conn->real_escape_string($_POST['uname']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT); // Hashing the password

    // Default values for Role and AccountStatus
    $role = "Undefined";
    $accountStatus = "Inactive";

    

    // Check for duplicate entries
    $duplicateCheckQuery = "SELECT * FROM Users WHERE Contact = '$contact' OR Email = '$email' OR RegNo = '$regNo' OR UserName = '$username'";
    $result = $conn->query($duplicateCheckQuery);

    if ($result->num_rows > 0) {
        // Duplicate found
        echo "<script>
                alert('Registration failed: Contact, Email, Registration Number, or Username already exists.');
                window.history.back();
              </script>";
    } else {
        // No duplicate, proceed with insertion
        $sql = "INSERT INTO Users (FullName, RegNo, Department, Contact, Gender, Email, Role, Designation, UserName, Password, AccountStatus) 
                VALUES ('$fullName', '$regNo', '$department', '$contact', '$gender', '$email', '$role', '$designation', '$username', '$password', '$accountStatus')";

        if ($conn->query($sql) === TRUE) {
            // Successful registration, redirect with an alert
            echo "<script>
                    alert('Registration successful!');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            // Error handling
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close connection
    $conn->close();
}
?>
