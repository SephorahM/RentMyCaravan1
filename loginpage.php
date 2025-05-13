<?php
session_start();
    include("connectregister.php");
    include("check_login.php");

    $login_error = false; // Track login error

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        //something was posted
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if(!empty($username) && !empty($password) && !is_numeric($username))
        {
            //read from database
            $query = "select * from register_form where username = '$username' limit 1";
            $result = mysqli_query($con, $query);

            if($result)
            {
                if($result && mysqli_num_rows($result) > 0)
                {
                    $user_data = mysqli_fetch_assoc($result);

                    if($user_data['password'] === $password)
                    {
                        $_SESSION['user_id'] = $user_data['user_id'];
                        header("Location: userhomepage.php");
                        die;
                    }
                } 
            }
            
            $login_error = true;
        } else {
            $login_error = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="navbar">
        <a href="homepage.html" onclick="showSection('home')">Home</a>
        <a href="aboutus.html" onclick="showSection('about')">About</a>
        <a href="servicespage.html" onclick="showSection('services')">Services</a>
        <a href="loginpage.php" onclick="showSection('login')">Login</a>
    </div>
    <div id="login" class="container">
        <div class="form-container">
        <h1>Login</h1>
        <form method="post">
        <input type="text" id="login-username" placeholder="Username" name="username">
        <input type="password" id="login-password" placeholder="Password" name="password">        
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="registerpage.php" onclick="showSection('register')">Sign Up</a></p>
        </form>
        </div>
        </div>
    <script src="script.js"></script>
    <?php if ($login_error): ?>
    <script>
        alert("Wrong username or password!");
    </script>
    <?php endif; ?>
    </body>
</html>