<?php
session_start();

    include("connectregister.php");
    include("check_login.php");

    $user_data = check_login($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Home Page</title>
</head>
<body class="<?php echo isset($_SESSION['user_id']) ? 'logged-in' : 'logged_out'; ?>">
    <div class="navbar">
        <a href="userhomepage.php">Home</a>
        <div class="dropdown">
            <a class="dropbtn">List Your Caravan</a>
            <div class="dropdown-content">
            <a href="addcaravan.php">Add Caravan</a>
            <a href="caravanlist.php">Your Caravan List</a>
            </div>
        </div>
        <a href="caravansummary.php">Caravan Summary</a>
        <a href="logout.php">Logout</a>
    </div>

    <div id="user home" class="container active" style="background: teal;">
    <h1>Welcome, <?php echo $user_data['username']; ?>!</h1>
    <div class="carousel-inner" style="display: flex; transition: transform 0.5s ease; width: 100%;">
        <img src="https://www.redocean.co.uk/image/cache/products/27852/image03_2000-1500x1500.jpg" style="flex: 0 0 100%; height: 50vw; max-height: 400px; object-fit: cover;">
    </div>
    <h2>Let's get you started with renting your caravans</h2>
    <button onclick="window.location.href='addcaravan.php'" style="margin: 20px 0; padding: 10px 20px; background: orange; color: white; border: none; cursor: pointer;">Add a Caravan</button>
</body>
</html>
