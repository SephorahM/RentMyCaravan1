<?php
session_start();

include("connectregister.php");
include("check_login.php");

$user_data = check_login($con);
$user_id = $_SESSION['user_id'];

// Fetch all caravans
$result = $con->query("SELECT * FROM caravan_db");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <title>Caravan Summary</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://www.scottishtourer.co.uk/desktop/web/ckfinder/userfiles/files/IMG_2576(1).JPG') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    .dropdown {
    display: inline-block;
    position: relative;
  }
  
  .dropbtn {
    padding: 15px 20px;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    transition: background 0.5s ease, color 0.5s ease;
  }
  
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #333;
    min-width: 180px;
    box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
    border-radius: 10px;
    overflow: hidden;
    top: 100%;
    left: 0;
    z-index: 1001;
  }
  
  .dropdown-content a {
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
    background-color: #333;
    transition: background 0.5s ease, color 0.5s ease;
  }
  
  .dropdown-content a:hover {
    background-color: #555;
    color: lightblue;
  }
  
  .dropdown:hover .dropdown-content {
    display: block;
  }
  
  .dropdown:hover .dropbtn {
    background-color: #555;
    color: lightblue;
  }

    .container {
      background: rgba(0, 128, 128, 0.9); /* teal background with slight transparency */
      max-width: 1000px;
      margin: 50px auto;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
    }

    h1 {
      text-align: center;
      color: #ffffff;
    }

    .caravan-card {
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid #b2dfdb;
      padding: 20px;
      margin: 20px 0;
      border-radius: 12px;
      display: flex;
      align-items: center;
      gap: 20px;
      transition: transform 0.2s ease;
    }

    .caravan-card:hover {
      transform: scale(1.02);
    }

    .caravan-card img {
      width: 160px;
      height: 100px;
      object-fit: cover;
      border-radius: 10px;
      border: 2px solid #ffffff;
    }

    .caravan-info {
      flex: 1;
    }

    .caravan-info h3 {
      margin: 0;
      color: #ffffff;
    }

    .caravan-info p {
      margin: 5px 0 0;
      color: #e0f7f7;
    }
  </style>
</head>
<body>
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

<div class="container">
  <h1>🚐 Caravan Listings Summary</h1>

  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="caravan-card">
        <img src="<?= htmlspecialchars($row['caravan_image']) ?>" alt="Caravan Image">
        <div class="caravan-info">
          <h3><?= htmlspecialchars($row['caravan_make'] . ' ' . $row['caravan_model']) ?> (<?= htmlspecialchars($row['caravan_year']) ?>)</h3>
          <p><?= nl2br(htmlspecialchars($row['caravan_details'])) ?></p>
          <p>📞 <?= htmlspecialchars($row['mobile_number']) ?></p>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center;">🚫 No caravans found in the database.</p>
  <?php endif; ?>

</div>

</body>
</html>