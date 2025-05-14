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
  <title>Caravan Summary</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://www.peakdistrict.org/wp-content/uploads/2020/06/Laneside-Caravan-Park.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    .navbar {
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: teal;
      padding: 15px;
      font-weight: bold;
      font-size: 16px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .navbar a {
      color: white;
      text-decoration: none;
      padding: 10px 18px;
      margin: 0 8px;
      border-radius: 5px;
      transition: background 0.3s ease;
    }

    .navbar a:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropbtn {
      cursor: pointer;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: teal;
      min-width: 160px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      z-index: 1;
      border-radius: 5px;
    }

    .dropdown-content a {
      color: white;
      padding: 10px 16px;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: rgba(255,255,255,0.1);
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .container {
      background: rgba(0, 128, 128, 0.9);
      max-width: 1000px;
      margin: 50px auto;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }

    h1 {
      text-align: center;
      color: #ffffff;
      margin-bottom: 30px;
      font-size: 28px;
      letter-spacing: 1px;
    }

    .caravan-card {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid #b2dfdb;
      padding: 20px;
      margin: 20px 0;
      border-radius: 12px;
      display: flex;
      align-items: center;
      gap: 20px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .caravan-card:hover {
      transform: scale(1.02);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
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
      font-size: 20px;
    }

    .caravan-info p {
      margin: 6px 0;
      color: #e0f7f7;
      font-size: 15px;
    }

    @media (max-width: 768px) {
      .caravan-card {
        flex-direction: column;
        align-items: flex-start;
      }

      .caravan-card img {
        width: 100%;
        height: auto;
      }
    }
  </style>
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