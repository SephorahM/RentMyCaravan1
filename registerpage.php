<?php
session_start();
    include("connectregister.php");
    include("check_login.php");

    $username_exists = false;

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        //something was posted
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        // Check if username already exists
        $check_query = "SELECT * FROM register_form WHERE username = '$username' LIMIT 1";
        $check_result = mysqli_query($con, $check_query);
        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $username_exists = true;
        } else if(!empty($lastName) && !empty($username) && !empty($password) && $password === $confirmPassword && !is_numeric($username)) {
            //save to database
            $user_id = random_number(20);
            $query = "insert into register_form (user_id, firstName, lastName, username, password, confirmPassword) values ('$user_id', '$firstName', '$lastName', '$username', '$password', '$confirmPassword')";
            mysqli_query($con, $query);
            header("Location: loginpage.php");
            die;
        } else {
            echo "Please enter vailid information!";
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
    <div id="register" class="container">
        <div class="form-container">
        <h1>Register</h1>
        <form method="post">
            <input type="text" id="register-firstname" placeholder="First Name" name="firstName" required>
            <input type="text" id="register-lastname" placeholder="Last Name" name="lastName" required>
            <input type="text" id="register-username" placeholder="Username" name="username" required>
            <input type="password" id="register-password" placeholder="Password (min 8 characters)" name="password" required>
            <input type="password" id="confirm-password" placeholder="Confirm Password" name="confirmPassword" required>
            <input id="button" type="submit" value="Signup"><br><br>
            <p id="register-error" class="error"></p>
            <a href="loginpage.php" onclick="showSection('login')">Back to Login</a>
        </form>
        </div>
        </div>
        <script src="script.js"></script>
        <?php if ($username_exists): ?>
        <script>
            alert("Username already exists, please try something else.");
        </script>
        <?php endif; ?>
</body>
</html>