<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/Regis.css">
</head>
<body>
    <div class="Container">
        <form action="SubmitUser.php" method="post" onsubmit="return validateForm()">
            <div class="header">
                <h2>Registration</h2>
            </div>

            <div class="content">
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
                    <input type="text" placeholder="Enter the department" name="dept" required pattern="[A-Za-z\s]+" title="Department should not contain numbers">
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
            </div>

            <div class="message">
                <!-- display error message here -->
            </div>
            <div class="button-container">
                <button type="submit">Register</button>
            </div>
        </form>

        <script src="js/SignUp.js"></script>

    </div>
  
</body>
</html>
