<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['FullName']) || !isset($_SESSION['RegNo'])) {
    header('Location: index.php');
    exit();
}

$fullName = $_SESSION['FullName'];
$regNo = $_SESSION['RegNo'];
$email = $_SESSION['Email'];
$contact = $_SESSION['Contact'];

?>

<div class="topnav" id="myTopnav">
    <a href="#user" class="user">
        <i class='bx bx-user'></i>
        <span class="text">Logged in as: <strong><?php echo htmlspecialchars($fullName); ?>(Admin)</strong></span>
        <input type="hidden" name="regNo" value="<?php echo htmlspecialchars($regNo); ?>">
    </a>
    <a href="logout.php" class="logout">
        <i class='bx bx-log-out'></i>
        <span class="text"> Log Out</span>
    </a>
</div>



<div class="sidebar">
        <div class="sidebar-header">
            <h2 class="sidebar-title">KINAP Clearance</h2>
            <button class="toggle-btn" onclick="toggleSidebar()"><i class='bx bx-menu'></i></button>
        </div>
        <a href="AdminDashBoard.php"><i class='bx bx-home'></i> <span class="link-text">Dashboard</span></a>
        <a href="UsersList.php"><i class='bx bxs-user-detail'></i><span class="link-text">Users List</span></a>
        <a href="ClearanceList.php"><i class='bx bx-list-ol '></i> <span class="link-text">Clearance List</span></a>
        <a href="Reports.php"><i class='bx bx-credit-card'></i> <span class="link-text">Reports</span></a>
        <a href="Staff.php"><i class='bx bxs-user-account'></i><span class="link-text">Staff</span></a>
        <a href="#my-profile"><i class='bx bx-user'></i> <span class="link-text">My Profile</span></a>
        <a href="#chat-room"><i class='bx bx-chat'></i> <span class="link-text">Chat Room</span></a>
    </div>

    <script src="js/Master.js"></script>    