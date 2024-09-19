<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Master.css">
    <link rel="stylesheet" href="css/Admin.css">
</head>
<body>
    <?php include 'MasterAdmin.php'; ?>

    <div class="dashboard-container">
        <a href="TotalUsers.php" class="widget total-users">
            <div class="widget-header">
                <i class='bx bx-users'></i>
                <h2>Total Users</h2>
            </div>
            <div class="widget-content">
                <p class="widget-number">1200</p>
            </div>
        </a>

        <a href="ActiveUsers.php" class="widget active-users">
            <div class="widget-header">
                <i class='bx bx-user-check'></i>
                <h2>Active Users</h2>
            </div>
            <div class="widget-content">
                <p class="widget-number">850</p>
            </div>
        </a>

        <a href="InactiveUsers.php" class="widget inactive-users">
            <div class="widget-header">
                <i class='bx bx-user-x'></i>
                <h2>Inactive Users</h2>
            </div>
            <div class="widget-content">
                <p class="widget-number">250</p>
            </div>
        </a>

        <a href="DeletedUsers.php" class="widget deleted-users">
            <div class="widget-header">
                <i class='bx bx-user-minus'></i>
                <h2>Deleted Users</h2>
            </div>
            <div class="widget-content">
                <p class="widget-number">100</p>
            </div>
        </a>
    </div>
</body>
</html>
