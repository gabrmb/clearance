<!DOCTYPE html>
<html lang="en">
    <head>
        <title>KINAP Clearance Management</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-N6XKjbBsCK/qkmF0JBR+hu9kcsR3TITmr5hCQU+R5JEB5yk+EvnCFOrV03FP5+nO3hRQKPeIjS5A1Dnv1A+70w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="css/Login.css">
    </head>
    <body>
        <div class ="main">
            <div class="navbar">
                <div class="icon">
                    <h2 class="logo">KinapClear</h2>
                </div>
            

                <div class="menu">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Service</a></li>
                        <li><a href="#">Design</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                <div class="search">
                    <input class="srch" type="search" name="" placeholder="Type To text">
                    <a href="#"><button class="btn">Search</button></a>
                </div>
            </div>
            <div class="content">
                <h1>KINAP Clearance <br><span>Management</span><br></h1>
                <p class="par">Welcome to the KINAP Clearance Portal! We are excited to have you here and are committed <br>
                to making your clearance process as smooth and efficient as possible. This platform has been <br>
                designed to simplify your experience, allowing you to manage and track all necessary steps for <br>
                your clearance with ease. Whether you are a graduating student or simply progressing through<br>
                 different stages of your academic journey, KINAP provides the tools and resources you need to <br>
                 complete your clearance swiftly. We're here to support you every step of the way!</p>

                    <button class="cn"><a href="https://www.kist.ac.ke/index.html">Visit Our Website</a></button>

                    <form class="form" action="Login.php" method="POST">
                        <h2>Login Here</h2>
                        <input type="text" name="username" placeholder="Enter Username Here" required>
                        <input type="password" name="password" placeholder="Enter Password Here" required>
                        <button class="btnn" type="submit">Login</button>
                                                

                        <p class="link">Forgotten your password?<br>
                        <a href="#">Click</a> Here</a><br>No Account?<br>
                        <a href="SignUp.php">Sign Up</a></p>
                        <p class="liw">Connect with us on</p>

                        <div class="icons">
                            <a href="#"><ion-icon name="logo-google"></ion-icon></a>   
                            <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                            <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                            <a href="#"><ion-icon name="logo-twitter"></ion-icon></i></a>
                                                    
                        </div>

                    </div>
            </div>
        </div> 
        <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    </body>
</html>