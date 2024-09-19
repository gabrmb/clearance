<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'kinapclearance');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users data
$sql = "SELECT FullName, RegNo, Department, Contact, Gender, Email, Role, Designation, AccountStatus FROM Users";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/UsersList.css">
    <link rel="stylesheet" href="css/Master.css">
</head>
<body>
    <?php include 'MasterAdmin.php'; ?>
    <div class="container">
        <div class="header">
            <h3>Manage Users</h3>
            <button class="add-btn" onclick="openAddModal()"><i class='bx bx-user-plus'></i> Add</button>
        </div>
        
        <div class="title-bar">
            <h4>Users List</h4>
        </div>

        <div class="controls">
            <div class="entries">
                <label for="entries-select">Show</label>
                <select id="entries-select" onchange="filterEntries()">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
                <label for="entries-select ">  entries</label>
            </div>
            <div class="search">
                <label for="search-input">Search:</label>
                <input type="text" id="search-input" onkeyup="searchTable()" placeholder="Search by any field...">
            </div>
        </div>
                <table id="userTable">
                    <thead>
                        <tr>
                            <th>#</th> <!-- Numbering column -->
                            <th>Full Name</th>
                            <th>Registration No</th>
                            <th>Department</th>
                            <th>Contact</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Designation</th>
                            <th>Account Status</th>
                            <th>Action</th> <!-- Action column -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1; // Counter for numbering
                        // Fetch data from the database
                        $query = "SELECT * FROM Users";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $counter++ . "</td>"; // Displaying the row number
                            echo "<td>" . $row['FullName'] . "</td>";
                            echo "<td>" . $row['RegNo'] . "</td>";
                            echo "<td>" . $row['Department'] . "</td>";
                            echo "<td>" . $row['Contact'] . "</td>";
                            echo "<td>" . $row['Gender'] . "</td>";
                            echo "<td>" . $row['Email'] . "</td>";
                            echo "<td>" . $row['Role'] . "</td>";
                            echo "<td>" . $row['Designation'] . "</td>";
                            echo "<td>" . $row['AccountStatus'] . "</td>";
                            echo "<td>";
                            echo "<button class='edit-btn' onclick='openEditModal(" . json_encode($row) . ")'><i class='bx bxs-edit-alt'></i></button>"; // Edit button
                            echo "<button class='delete-btn' onclick='confirmDelete(\"" . $row['RegNo'] . "\")'><i class='bx bx-trash'></i></button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
    </div>

    <!-- Add Modal -->
    <div id="addUserModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Registration</h2>
            <span class="close">&times;</span> <!-- Close button -->
        </div>

        <div class="modal-body">
            <form id="registerForm" method="POST" action="add_user.php">
                <div class="input-box">
                    <label for="name">Full Name:</label>
                    <input type="text" placeholder="Enter full name" name="name" required pattern="[A-Za-z\s]+" title="Full Name should not contain numbers">
                </div>

                <div class="input-box">
                    <label for="regNo">Student Reg/Employee No:</label>
                    <input type="text" placeholder="Enter your Reg/Employee No." name="RegistrationNo" required>
                </div>

                <div class="input-box">
                    <label for="department">Department:</label>
                    <select id="Department" name="Department" required>
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
       
                <div class="input-box">
                    <label for="email">Email:</label>
                    <input type="email" placeholder="Enter your email address" name="email" required>
                </div>

                <div class="input-box">
                    <label for="phone">Phone Number:</label>
                    <input type="text" placeholder="Enter your phone number" name="phoneNo" required pattern="[0-9]+" title="Phone Number should not contain letters">
                </div>

                <div class="input-box">
                    <label for="designation">Designation:</label>
                    <input type="text" placeholder="Enter your designation" name="desig" required pattern="[A-Za-z\s]+" title="Designation should not contain numbers">
                </div>

                <div class="input-box">
                    <label for="username">UserName:</label>
                    <input type="text" placeholder="Enter username" name="uname" required>
                </div>

                <div class="input-box">
                    <label for="password">Password:</label>
                    <input type="password" placeholder="Enter your password" name="password" required>
                </div>

                <div class="input-box">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" placeholder="Confirm your password" name="ConfirmPassword" required>
                </div>

                <div class="input-box1">
                    <label for="gender">Gender:</label>
                    <div class="gender-category">
                        <input type="radio" name="gender" id="male" value="Male" required>
                        <label for="male">Male</label>
                        <input type="radio" name="gender" id="female" value="Female">
                        <label for="female">Female</label>
                        <input type="radio" name="gender" id="other" value="Other">
                        <label for="other">Other</label>
                    </div>
                </div>

                <div class="message">
                    <!-- display error message here -->
                </div>

                <div class="button-container">
                    <button type="submit">Register</button>
                </div>
                
            </form>
            
        </div>
    </div>
    </div>
    

    <!-- Edit Modal -->
    <div id="editUserModal" class="modal-edit">
        <div class="modal-content-edit">
            <div class="modal-header-edit">
                <h2>Edit User Details</h2>
                <span class="close-edit" id="closeEditModal">&times;</span> <!-- Close button -->
            </div>

            <div class="modal-body-edit">
                <form id="editForm" action="update_user.php" method="POST">
                    <!-- Hidden input to store user RegNo -->
                    <input type="hidden" name="RegNo" id="editRegNo">

                    <div class="input-box-edit">
                        <label for="editFullName">Full Name:</label>
                        <input type="text" id="editFullName" name="FullName" required>
                    </div>

                    <div class="input-box-edit">
                        <label for="editDepartment">Department:</label>
                        <select id="editDepartment" name="Department" required>
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
                            <option value="Library">Library</option>
                        </select>
                    </div>

                    <div class="input-box-edit">
                        <label for="editContact">Contact:</label>
                        <input type="text" id="editContact" name="Contact" required>
                    </div>

                    <div class="input-box-edit">
                        <label for="editGender">Gender:</label>
                        <input type="text" id="editGender" name="Gender" required>
                    </div>

                    <div class="input-box-edit">
                        <label for="editEmail">Email:</label>
                        <input type="email" id="editEmail" name="Email" required>
                    </div>

                    <div class="input-box-edit">
                        <label for="editRole">Role:</label>
                        <select id="editRole" name="Role" required>
                            <option value="" selected>Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Student">Student</option>
                            <option value="Staff">Staff</option>
                            <!-- Add other roles as needed -->
                        </select>
                    </div>

                    <div class="input-box-edit">
                        <label for="editDesignation">Designation:</label>
                        <input type="text" id="editDesignation" name="Designation" required>
                    </div>

                    <div class="input-box-edit">
                        <label for="editAccountStatus">Account Status:</label>
                        <select id="editAccountStatus" name="AccountStatus" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="button-container-edit">
                        <button type="submit">Update User Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
<script>
// Get all modals
var addModal = document.getElementById("addUserModal");
var editModal = document.getElementById("editUserModal");

// Get all close buttons
var closeAddBtn = addModal.querySelector(".close");
var closeEditBtn = document.getElementById("closeEditModal");

// Close the add modal when the close button is clicked
closeAddBtn.onclick = function() {
    addModal.style.display = "none";
}

// Close the edit modal when the close button is clicked
closeEditBtn.onclick = function() {
    editModal.style.display = "none";
}

// Close the modal if the user clicks outside the modal content
window.onclick = function(event) {
    if (event.target == addModal) {
        addModal.style.display = "none";
    } else if (event.target == editModal) {
        editModal.style.display = "none";
    }
}

// Function to open the add modal
function openAddModal() {
    addModal.style.display = "block";
}

// Function to open the edit modal and populate fields with user data
function openEditModal(userData) {
    // Fill the form with the user data
    document.getElementById('editRegNo').value = userData.RegNo;
    document.getElementById('editFullName').value = userData.FullName;
    document.getElementById('editDepartment').value = userData.Department;
    document.getElementById('editContact').value = userData.Contact;
    document.getElementById('editGender').value = userData.Gender;
    document.getElementById('editEmail').value = userData.Email;
    document.getElementById('editRole').value = userData.Role;
    document.getElementById('editDesignation').value = userData.Designation;
    document.getElementById('editAccountStatus').value = userData.AccountStatus;

    // Display the modal
    editModal.style.display = "block";
}
</script>


    <script>
        function confirmDelete(regNo) {
            if (confirm("Are you sure you want to delete this user's account?")) {
                window.location.href = "delete_users.php?regNo=" + regNo;
            }
        }
    </script>

    <script src="js/UserListModal.js"></script>

</body>
</html>
